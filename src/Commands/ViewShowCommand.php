<?php

namespace Bpocallaghan\Generators\Commands;

class ViewShowCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:view:show';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new blade show view file';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'View_Show';

	/**
	 * Build the class with the given name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function buildClass($name)
	{
		$stub = $this->files->get($this->getStub());

		$this->replaceResource($stub);

		return $stub;
	}

	/**
	 * Replace the resource name in the view stub
	 *
	 * @param $stub
	 * @return string
	 */
	protected function replaceResource(&$stub)
	{
		$name = strtolower(str_singular($this->getFileName()));

		$stub = str_replace('{{resource}}', $name, $stub);

		return $this;
	}

	/**
	 * Get the file name only
	 *
	 * @return string
	 */
	private function getFileName()
	{
		if(strpos($this->argument('name'), '.') === false)
		{
			return $this->argument('name');
		}

		return substr($this->argument('name'), strpos($this->argument('name'), '.') + 1);
	}

	/**
	 * Get the destination class path.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function getPath($name)
	{
		return './resources/views/' . str_replace('.', '/', $this->argument('name')) . '/show.blade.php';
	}
}
