<?php

namespace Bpocallaghan\Generators\Commands;

class ViewAddEditCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:view:add_edit';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new blade add-edit view file';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'View_Add_Edit';

	/**
	 * Build the class with the given name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function buildClass($name)
	{
		$stub = $this->files->get($this->getStub());

		$this->replaceUrl($stub);
		$this->replaceModel($stub);
		$this->replaceResource($stub);

		return $stub;
	}

	private function replaceUrl(&$stub)
	{
		$url = '/' . str_replace('.', '/', $this->argument('name')) . '/';

		$stub = str_replace('{{$url}}', $url, $stub);

		return $this;
	}

	/**
	 * Replace the model name in the view stub
	 *
	 * @param $stub
	 * @return string
	 */
	protected function replaceModel(&$stub)
	{
		$name = ucwords(str_singular($this->getFileName()));

		$stub = str_replace('{{model}}', $name, $stub);

		return $this;
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
		return './resources/views/' . str_replace('.', '/', $this->argument('name')) . '/add_edit.blade.php';
	}
}
