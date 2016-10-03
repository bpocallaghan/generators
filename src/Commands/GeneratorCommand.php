<?php

namespace Bpocallaghan\Generators\Commands;

use Bpocallaghan\Generators\Traits\ArgumentsOptionsAccessors;
use Bpocallaghan\Generators\Traits\SettingsAccessors;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;

abstract class GeneratorCommand extends LaravelGeneratorCommand
{
    use ArgumentsOptionsAccessors, SettingsAccessors;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * The resource argument
     *
     * @var string
     */
    protected $resource = "";

    /**
     * The lowercase resource argument
     *
     * @var string
     */
    protected $resourceLowerCase = "";

    function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files);

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->call('generate:file', [
            'name'    => $this->argumentName(),
            '--type'  => strtolower($this->type), // settings type
            '--plain' => $this->optionPlain(), // if plain stub
            '--force' => $this->optionForce(), // force override
            '--stub'  => $this->optionStub(), // custom stub name
            '--name'  => $this->optionName(), // custom name for file
        ]);
    }

    /**
     * Only return the name of the file
     * Ignore the path / namespace of the file
     *
     * @return array|mixed|string
     */
    protected function getArgumentNameOnly()
    {
        $name = $this->argumentName();

        if (str_contains($name, '/')) {
            $name = str_replace('/', '.', $name);
        }

        if (str_contains($name, '\\')) {
            $name = str_replace('\\', '.', $name);
        }

        if (str_contains($name, '.')) {
            return substr($name, strrpos($name, '.') + 1);
        }

        return $name;
    }

    /**
     * Return the path of the file
     *
     * @param bool $withName
     * @return array|mixed|string
     */
    protected function getArgumentPath($withName = false)
    {
        $name = $this->argumentName();

        if (str_contains($name, '.')) {
            $name = str_replace('.', '/', $name);
        }

        if (str_contains($name, '\\')) {
            $name = str_replace('\\', '/', $name);
        }

        // ucfirst char, for correct namespace
        $name = implode('/', array_map('ucfirst', explode('/', $name)));

        // if we need to keep lowercase
        if ($this->settingsDirectoryFormat() === 'strtolower') {
            $name = implode('/', array_map('strtolower', explode('/', $name)));
        }

        // if we want the path with name
        if ($withName) {
            return $name . '/';
        }

        if (str_contains($name, '/')) {
            return substr($name, 0, strripos($name, '/') + 1);
        }

        return '';
    }

    /**
     * Get the resource name
     *
     * @param      $name
     * @param bool $format
     * @return string
     */
    protected function getResourceName($name, $format = true)
    {
        // we assume its already formatted to resource name
        if ($name && $format === false) {
            return $name;
        }

        $name = isset($name) ? $name : $this->resource;

        $this->resource = lcfirst(str_singular(class_basename($name)));
        $this->resourceLowerCase = strtolower($name);

        return $this->resource;
    }

    /**
     * Get the name for the model
     *
     * @param null $name
     * @return string
     */
    protected function getModelName($name = null)
    {
        $name = isset($name) ? $name : $this->resource;

        //return ucwords(camel_case($this->getResourceName($name)));

        return str_singular(ucwords(camel_case(class_basename($name))));
    }

    /**
     * Get the name for the controller
     *
     * @param null $name
     * @return string
     */
    protected function getControllerName($name = null)
    {
        return ucwords(camel_case(str_replace($this->settings['postfix'], '', ($name))));
    }

    /**
     * Get the name for the seed
     *
     * @param null $name
     * @return string
     */
    protected function getSeedName($name = null)
    {
        return ucwords(camel_case(str_replace($this->settings['postfix'], '',
            $this->getResourceName($name))));
    }

    /**
     * Get the name of the collection
     *
     * @param null $name
     * @return string
     */
    protected function getCollectionName($name = null)
    {
        return str_plural($this->getResourceName($name));
    }

    /**
     * Get the path to the view file
     *
     * @param $name
     * @return string
     */
    protected function getViewPath($name)
    {
        $pieces = explode('/', $name);

        // dont plural if reserve word
        foreach ($pieces as $k => $value) {
            if (!in_array($value, config('generators.reserve_words'))) {
                $pieces[$k] = str_plural(snake_case($pieces[$k]));
            }
        }


        $name = implode('.', $pieces);

        //$name = implode('.', array_map('str_plural', explode('/', $name)));

        return strtolower(rtrim(ltrim($name, '.'), '.'));
    }

    /**
     * Get the table name
     *
     * @param $name
     * @return string
     */
    protected function getTableName($name)
    {
        return str_replace("-", "_", str_plural(snake_case(class_basename($name))));
    }

    /**
     * Get name of file/class with the pre and post fix
     *
     * @param $name
     * @return string
     */
    protected function getFileNameComplete($name)
    {
        return $this->settings['prefix'] . $name . $this->settings['postfix'];
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . config('generators.' . strtolower($this->type) . '_namespace');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $key = $this->getOptionStubKey();

        // get the stub path
        $stub = config('generators.' . $key);

        if (is_null($stub)) {
            $this->error('The stub does not exist in the config file - "' . $key . '"');
            exit;
        }

        return $stub;
    }

    /**
     * Get the key where the stub is located
     *
     * @return string
     */
    protected function getOptionStubKey()
    {
        $plain = $this->option('plain');
        $stub = $this->option('stub') . ($plain ? '_plain' : '') . '_stub';

        // if no stub, we assume its the same as the type
        if (is_null($this->option('stub'))) {
            $stub = $this->option('type') . ($plain ? '_plain' : '') . '_stub';
        }

        return $stub;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of class being generated.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', null, InputOption::VALUE_NONE, 'Generate an empty class.'],
            ['force', null, InputOption::VALUE_NONE, 'Warning: Override file if it already exist'],
            [
                'stub',
                null,
                InputOption::VALUE_OPTIONAL,
                'The name of the view stub you would like to generate.'
            ],
            [
                'name',
                null,
                InputOption::VALUE_OPTIONAL,
                'If you want to override the name of the file that will be generated'
            ],
        ];
    }
}
