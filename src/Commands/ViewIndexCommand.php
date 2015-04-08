<?php

namespace Bpocallaghan\Generators\Commands;

class ViewIndexCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:view:index';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new blade index view file';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'View_Index';

	/**
	 * Build the class with the given name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function buildClass($name)
	{
		$stub = $this->files->get($this->getStub());

		$this->replaceResourceName($stub);

		return $stub;
	}

	/**
	 * Replace the resource name in the view stub
	 *
	 * @param $stub
	 * @return string
	 */
	protected function replaceResourceName(&$stub)
	{
		$resource = substr($this->argument('name'), strpos($this->argument('name'), '.') + 1);
		$name = ucwords(str_plural($resource));

		$stub = str_replace('{{resource}}', $name, $stub);

		return $this;
	}

	/**
	 * Get the destination class path.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function getPath($name)
	{
		return './resources/views/' . str_replace('.', '/', $this->argument('name')) . '/index.blade.php';
	}
}
