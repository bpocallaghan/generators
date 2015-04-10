<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class ControllerCommand extends GeneratorCommand
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
	 * Build the class with the given name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function buildClass($name)
	{
		$stub = $this->files->get($this->getStub());

		$stub = $this->replaceClass($stub, $name);

		$this->replaceNamespace($stub, $name);

		// regions
		$this->replaceCollection($stub);

		// region
		$this->replaceResource($stub);

		// Region
		$this->replaceModel($stub);

		// regions || geography.regions (folder seperator)
		$this->replaceView($stub);

		return $stub;
	}

	/**
	 * Replace the collection placeholder for the given stub.
	 *
	 * @param  string $stub
	 * @return $this
	 */
	protected function replaceCollection(&$stub)
	{
		$stub = str_replace('{{collection}}', $this->getCollectionName(), $stub);

		return $this;
	}

	/**
	 * Replace the collection placeholder for the given stub.
	 *
	 * @param $stub
	 * @return $this
	 */
	public function replaceResource(&$stub)
	{
		$stub = str_replace('{{resource}}', $resource = str_singular($this->getCollectionName()), $stub);

		return $this;
	}

	/**
	 * Replace the collection placeholder for the given stub.
	 *
	 * @param $stub
	 * @return $this
	 */
	public function replaceModel(&$stub)
	{
		$stub = str_replace('{{model}}', ucwords($this->getCollectionName()), $stub);

		return $this;
	}

	/**
	 * Replace the collection placeholder for the given stub.
	 *
	 * @param $stub
	 * @return $this
	 */
	public function replaceView(&$stub)
	{
		$view = strtolower(str_replace(['Controller', '\\'], ['', '.'], $this->argument('name')));

		$stub = str_replace('{{view}}', $view, $stub);

		return $this;
	}

	/**
	 * Get the controller name without the controller prefix
	 *
	 * @return string
	 */
	private function getCollectionName()
	{
		return strtolower(str_replace('Controller', '', class_basename($this->argument('name'))));
	}

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace)
	{
		return $rootNamespace . '\Http\Controllers';
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
