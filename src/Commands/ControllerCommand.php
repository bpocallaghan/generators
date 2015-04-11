<?php

namespace Bpocallaghan\Generators\Commands;

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
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		parent::fire();

		$this->composer->dumpAutoloads();
	}

	/**
	 * Parse the name for the class.
	 *
	 * @param  string  $name
	 * @return string
	 */
	protected function parseName($name)
	{
		return $this->getControllerPath($name);
	}

	/**
	 * Build the class with the given name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function buildClass($name)
	{
		$stub = parent::buildClass($name);

		// countries
		$stub = str_replace('{{collection}}', $this->getCollectionName($name), $stub);

		// country
		$stub = str_replace('{{resource}}', $this->getResourceName($name), $stub);

		// Country
		$stub = str_replace('{{model}}', $this->getModelName($name), $stub);

		// countries || posts.comments
		$stub = str_replace('{{view}}', $this->getViewPath($name), $stub);

		return $stub;
	}
}
