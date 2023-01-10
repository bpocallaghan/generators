<?php

namespace Bpocallaghan\Generators\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class FileCommand extends GeneratorCommand
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'generate:file';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a file from a stub in the config';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'File';

    /**
     * Get the filename of the file to generate
     * @return string
     */
    private function getFileName()
    {
        $name = $this->getArgumentNameOnly();

        switch ($this->option('type')) {
            case 'view':
                break;
            case 'model':
                $name = $this->getModelName();
                break;
            case 'controller':
                $name = $this->getControllerName($name);
                break;
            case 'livewire':
                $name = $this->getControllerName($name);
                break;
            case 'livewire_view':
                $name = $this->getViewName($name);
                break;
            case 'seeder':
                $name = $this->getSeederName($name);
                break;
        }

        // override the name
        if ($this->option('name')) {
            return $this->option('name') . $this->settings['file_type'];
        }

        return $this->settings['prefix'] . $name . $this->settings['postfix'] . $this->settings['file_type'];
    }

    /**
     * Execute the console command.
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->setSettings();
        $this->getResourceName($this->getUrl(false));

        // check the path where to create and save file
        $path = $this->getPath('');
        if ($this->files->exists($path) && $this->optionForce() === false) {
            return $this->error($this->type . ' already exists!');
        }

        // make all the directories
        $this->makeDirectory($path);

        // build file and save it at location
        $this->files->put($path, $this->buildClass($this->argumentName()));

        // check if there is an output handler function
        $output_handler = config('generators.output_path_handler');
        $this->info(ucfirst($this->option('type')) . ' created successfully.');
        if (is_callable($output_handler)) {
            // output to console from the user defined function
            $this->info($output_handler(Str::after($path, '.')));
        } else {
            // output to console
            $this->info('- ' . $path);
        }

        // if we need to run "composer dump-autoload"
        if ($this->settings['dump_autoload'] === true) {
            if ($this->confirm("Run 'composer dump-autoload'?")) {
                $this->composer->dumpAutoloads();
            }
        }

        // if we need to generate a test file
        if ($this->option('test')) {
            // ./app/Http
            $name = Str::replace('./app', '', $path);
            $name = Str::replace('/Http/', '', $name);
            $name = Str::replace('.php', '', $name);

            $this->call('generate:test', [
                'name' => $name,
                '--unit' => $this->settings['postfix'] !== 'Controller',
            ]);
        }
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = $this->getFileName();

        $withName = (bool)$this->option('name');

        $path = $this->settings['path'];

        if ($this->settingsDirectoryNamespace() === true) {
            $path .= $this->getArgumentPath($withName);
        }

        $path .= $name;

        return $path;
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        // examples used for the placeholders is for 'foo.bar'

        // App\Foo
        $stub = str_replace('{{namespace}}', $this->getNamespace($name), $stub);

        // Foo
        $stub = str_replace('{{namespaceWithoutApp}}', $this->getNamespace($name, false), $stub);

        // App\
        $stub = str_replace('{{rootNamespace}}', $this->getLaravel()->getNamespace(), $stub);

        // Bar
        $stub = str_replace('{{class}}', $this->getClassName(), $stub);

        $url = $this->getUrl(); // /foo/bar

        // /foo/bar
        $stub = str_replace('{{url}}', $this->getUrl(), $stub);

        // bars
        $stub = str_replace('{{collection}}', $this->getCollectionName(), $stub);

        // Bars
        $stub = str_replace('{{collectionUpper}}', $this->getCollectionUpperName(), $stub);

        // Bar
        $stub = str_replace('{{model}}', $this->getModelName(), $stub);

        // Bar
        $stub = str_replace('{{resource}}', $this->resource, $stub);

        // bar
        $stub = str_replace('{{resourceLowercase}}', $this->resourceLowerCase, $stub);

        // ./resources/views/foo/bar.blade.php
        $stub = str_replace('{{path}}', $this->getPath(''), $stub);

        // foos.bars
        $stub = str_replace('{{view}}', $this->getViewPath($this->getUrl(false)), $stub);

        // foos.bars (remove admin or website if first word)
        $stub = str_replace('{{viewPath}}', $this->getViewPathFormatted($this->getUrl(false)), $stub);

        // bars
        $stub = str_replace('{{table}}', $this->getTableName($url), $stub);

        // console command name
        $stub = str_replace('{{command}}', $this->option('command'), $stub);

        // contract file name
        $stub = str_replace('{{contract}}', $this->getContractName(), $stub);

        // contract namespace
        $stub = str_replace('{{contractNamespace}}', $this->getContractNamespace(), $stub);

        return $stub;
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param string $name
     * @param bool $withApp
     * @return string
     */
    protected function getNamespace($name, $withApp = true)
    {
        $path = (strlen($this->settings['namespace']) >= 2 ? $this->settings['namespace'] . '\\' : '');

        // dont add the default namespace if specified not to in config
        if ($this->settingsDirectoryNamespace() === true) {
            $path .= str_replace('/', '\\', $this->getArgumentPath());
        }

        $pieces = array_map('ucfirst', explode('/', $path));

        $namespace = ($withApp === true ? $this->getLaravel()->getNamespace() : '') . implode('\\', $pieces);

        $namespace = rtrim(ltrim(str_replace('\\\\', '\\', $namespace), '\\'), '\\');

        return $namespace;
    }

    /**
     * Get the url for the given name
     *
     * @param bool $lowercase
     * @return string
     */
    protected function getUrl($lowercase = true)
    {
        if ($lowercase) {
            $url = '/' . rtrim(implode(
                    '/',
                    array_map('Str::snake', explode('/', $this->getArgumentPath(true)))
                ), '/');
            $url = (implode('/', array_map('Str::slug', explode('/', $url))));

            return $url;
        }

        return '/' . rtrim(implode('/', explode('/', $this->getArgumentPath(true))), '/');
    }

    /**
     * Get the class name
     * @return mixed
     */
    protected function getClassName()
    {
        return ucwords(Str::camel(str_replace(
            [$this->settings['file_type']],
            [''],
            $this->getFileName()
        )));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge([
            ['type', null, InputOption::VALUE_OPTIONAL, 'The type of file: model, view, controller, migration, seed', 'view'],
            // optional for to generate:console
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal command that should be assigned.', 'command:name'],
            // optional for to generate:test
            ['unit', null, InputOption::VALUE_OPTIONAL, 'Create a unit test.', 'Feature'],
        ], parent::getOptions());
    }
}
