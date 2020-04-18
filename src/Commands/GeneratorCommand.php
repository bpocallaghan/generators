<?php

namespace Bpocallaghan\Generators\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Bpocallaghan\Generators\Traits\Settings;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Bpocallaghan\Generators\Traits\ArgumentsOptions;
use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;

abstract class GeneratorCommand extends LaravelGeneratorCommand
{
    use ArgumentsOptions, Settings;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * The resource argument
     *
     * @var string
     */
    protected $resource = '';

    /**
     * The lowercase resource argument
     *
     * @var string
     */
    protected $resourceLowerCase = '';

    /**
     * @var string
     */
    protected $extraOption = '';

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
    public function handle()
    {
        $args = [
            'name'    => $this->argumentName(),
            '--type'  => strtolower($this->type), // settings type
            '--plain' => $this->optionPlain(), // if plain stub
            '--force' => $this->optionForce(), // force override
            '--stub'  => $this->optionStub(), // custom stub name
            '--name'  => $this->optionName(), // custom name for file
        ];

        // extra custom option
        if ($this->extraOption) {
            $args["--{$this->extraOption}"] = $this->optionExtra();
        }

        $this->call('generate:file', $args);
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

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '.', $name);
        }

        if (Str::contains($name, '\\')) {
            $name = str_replace('\\', '.', $name);
        }

        if (Str::contains($name, '.')) {
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

        if (Str::contains($name, '.')) {
            $name = str_replace('.', '/', $name);
        }

        if (Str::contains($name, '\\')) {
            $name = str_replace('\\', '/', $name);
        }

        // ucfirst char, for correct namespace
        $name = implode('/', array_map('ucfirst', explode('/', $name)));

        // if we need to keep lowercase
        if ($this->settingsDirectoryFormat() === 'strtolower') {
            $name = implode('/', array_map('strtolower', explode('/', $name)));
        }

        // if type Test -> see if Feature or Unit
        if ($this->option('type') === 'test') {
            $folder = $this->option('unit') ?? 'Unit'; // Feature unless null -> Unit

            $name = $folder . DIRECTORY_SEPARATOR . $name;
        }

        // if we want the path with name
        if ($withName) {
            return $name . '/';
        }

        if (Str::contains($name, '/')) {
            return substr($name, 0, strripos($name, '/') + 1);
        }

        // if test - return the prefix folder
        if ($this->option('type') === 'test') {
            return ($this->option('unit') ?? 'Unit') . DIRECTORY_SEPARATOR;
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

        $this->resource = lcfirst(Str::singular(class_basename($name)));
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

        //return ucwords(Str::camel($this->getResourceName($name)));

        return Str::singular(ucwords(Str::camel(class_basename($name))));
    }

    /**
     * Get the name for the controller
     *
     * @param null $name
     * @return string
     */
    protected function getControllerName($name = null)
    {
        return ucwords(Str::camel(str_replace($this->settings['postfix'], '', ($name))));
    }

    /**
     * Get the name for the seed
     *
     * @param null $name
     * @return string
     */
    protected function getSeedName($name = null)
    {
        return ucwords(Str::camel(str_replace($this->settings['postfix'], '',
            $this->getCollectionName($name))));
    }

    /**
     * Get the name of the collection
     *
     * @param null $name
     * @return string
     */
    protected function getCollectionName($name = null)
    {
        return Str::plural($this->getResourceName($name));
    }

    /**
     * Get the plural uppercase name of the resouce
     * @param null $name
     * @return null|string
     */
    protected function getCollectionUpperName($name = null)
    {
        $name = Str::plural($this->getResourceName($name));

        $pieces = explode('_', $name);
        $name = "";
        foreach ($pieces as $k => $str) {
            $name .= ucfirst($str);
        }

        return $name;
    }

    /**
     * Get the name of the contract
     * @param null $name
     * @return string
     */
    protected function getContractName($name = null)
    {
        $name = isset($name) ? $name : $this->resource;

        $name = Str::singular(ucwords(Str::camel(class_basename($name))));

        return $name . config('generators.settings.contract.postfix');
    }

    /**
     * Get the namespace of where contract was created
     * @param bool $withApp
     * @return string
     */
    protected function getContractNamespace($withApp = true)
    {
        // get path from settings
        $path = config('generators.settings.contract.namespace') . '\\';

        // dont add the default namespace if specified not to in config
        $path .= str_replace('/', '\\', $this->getArgumentPath());

        $pieces = array_map('ucfirst', explode('/', $path));

        $namespace = ($withApp === true ? $this->getLaravel()->getNamespace() : '') . implode('\\', $pieces);

        $namespace = rtrim(ltrim(str_replace('\\\\', '\\', $namespace), '\\'), '\\');

        return $namespace;
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
                $pieces[$k] = Str::plural(Str::snake($pieces[$k]));
            }
        }

        $name = implode('.', $pieces);

        return strtolower(rtrim(ltrim($name, '.'), '.'));
    }

    /**
     * Remove 'admin' and 'webiste' if first in path
     * The Base Controller has it as a 'prefix path'
     *
     * @param $name
     * @return string
     */
    protected function getViewPathFormatted($name)
    {
        $path = $this->getViewPath($name);

        if (strpos($path, 'admin.') === 0) {
            $path = substr($path, 6);
        }

        if (strpos($path, 'admins.') === 0) {
            $path = substr($path, 7);
        }

        if (strpos($path, 'website.') === 0) {
            $path = substr($path, 8);
        }

        if (strpos($path, 'websites.') === 0) {
            $path = substr($path, 9);
        }

        return $path;
    }

    /**
     * Get the table name
     *
     * @param $name
     * @return string
     */
    protected function getTableName($name)
    {
        return str_replace("-", "_", Str::plural(Str::snake(class_basename($name))));
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
     * @param string $rootNamespace
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
        $stub = config('generators.stubs.' . $key);

        if ($stub === null) {
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
        $stub = $this->option('stub') . ($plain ? '_plain' : '');

        // if no stub, we assume its the same as the type
        if (is_null($this->option('stub'))) {
            $stub = $this->option('type') . ($plain ? '_plain' : '');
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
