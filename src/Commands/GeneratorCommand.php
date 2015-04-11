<?php

namespace Bpocallaghan\Generators\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Composer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;

abstract class GeneratorCommand extends LaravelGeneratorCommand
{

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
		$name = $this->parseName($this->getNameInput());

		$path = $this->getPath($name);

		if ($this->files->exists($path) && $this->option('force') === false)
		{
			return $this->error($this->type . ' already exists!');
		}

		$this->makeDirectory($path);

		$this->files->put($path, $this->buildClass($name));

		$this->info($this->type . ' created successfully.');

		$this->info('- ' . $path);
	}

	/**
	 * Get the resource name
	 *
	 * @param $name
	 * @return string
	 */
	protected function getResourceName($name)
	{
		$name = isset($name) ? $name : $this->resource;

		return str_singular(strtolower(str_replace('Controller', '', class_basename($name))));
	}

	/**
	 * Get the name for the model
	 *
	 * @param null $name
	 * @return string
	 */
	protected function getModelName($name = null)
	{
		// bar => Bar
		// bars => Bar
		return ucwords(camel_case($this->getResourceName($name)));
	}

	/**
	 * Get the name for the controller
	 *
	 * @param null $resource
	 * @return string
	 */
	protected function getControllerName($resource = null)
	{
		// bar => BarsController
		// Foo\Bar => Foo\BarsController
		// foo_bar => FooBarsController
		// BarController => BarsController
		return ucwords(str_plural(camel_case(str_replace('Controller', '', $resource)))) . 'Controller';
	}

	/**
	 * Get the full path for the controller
	 *
	 * @param $name
	 * @return mixed|string
	 */
	protected function getControllerPath($name)
	{
		$rootNamespace = $this->getAppNamespace();

		if (starts_with($name, $rootNamespace))
		{
			return $name;
		}

		$name = $this->convertNameToNamespace($name);

		// Bar => BarController
		$name = str_replace('Controller', '', $name) . 'Controller';

		return $this->getControllerPath($this->getDefaultNamespace(trim($rootNamespace, '\\')) . '\\' . $name);
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
		$name = substr($name, strpos($name, '\Controllers') + 13);

		$name = implode('\\', array_map('str_plural', explode('\\', $name)));

		return strtolower(str_replace(['Controllers', 'Controller', '\\'], ['', '', '.'], $name));
	}

	/**
	 * Get the table name
	 *
	 * @param $name
	 * @return string
	 */
	protected function getTableName($name)
	{
		return str_plural(snake_case(class_basename($name)));
	}

	/**
	 * Get the name for the migration
	 *
	 * @param null $name
	 * @return string
	 */
	protected function getMigrationName($name = null)
	{
		return 'create_' . str_plural($this->getResourceName($name)) . '_table';
	}

	/**
	 * Get the name for the seed
	 *
	 * @param null $resource
	 * @return string
	 */
	protected function getSeedName($resource = null)
	{
		$resource = str_replace('tableseeder', '', $this->getResourceName($resource));

		return ucwords(str_singular(camel_case($resource))) . 'TableSeeder';
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return config('generators.' . strtolower($this->type) . ($this->input->hasOption('plain') && $this->option('plain') ? '_plain' : '') . '_stub');
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
	 * Convert the name into a valid namespace
	 *
	 * @param $name
	 * @return mixed
	 */
	protected function convertNameToNamespace($name)
	{
		// foo/bar => foo\bar
		$name = str_replace('/', '\\', $name);

		// foo.bar => foo\bar
		$name = str_replace('.', '\\', $name);

		// upercase after every \ || foo\bar => Foo\Bar
		$name = implode('\\', array_map('ucfirst', explode('\\', $name)));

		return $name;
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
			['force', null, InputOption::VALUE_NONE, 'Warning: Overide file if it already exist'],
		];
	}
}