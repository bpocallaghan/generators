<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends GeneratorCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:controller';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new resource controller class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Controller';

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace)
	{
		return $rootNamespace.'\Http\Controllers';
	}

	/**
	 * Replace the placeholders for the given stub.
	 *
	 * @param  string $stub
	 * @param  string $name
	 * @return $this
	 */
	protected function replaceNamespace(&$stub, $name)
	{
		parent::replaceNamespace($stub, $name);

		$collection = strtolower(str_replace('Controller', '', class_basename($name)));

		$view = strtolower(str_replace(['Controller', '\\'], ['', '.'], $this->argument('name')));

		// regions || geography.regions (folder seperator)
		$stub = str_replace('{{view}}', $view, $stub);

		// regions
		$stub = str_replace('{{collection}}', $collection, $stub);

		// region
		$stub = str_replace('{{resource}}', $resource = str_singular($collection), $stub);

		// Region
		$stub = str_replace('{{model}}', ucwords($resource), $stub);

		return $this;
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['plain', 'p', InputOption::VALUE_NONE, 'Generate an empty controller.'],
			['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller.'],
		];
	}
}
