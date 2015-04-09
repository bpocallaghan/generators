<?php

namespace Bpocallaghan\Generators\Commands;

class ViewCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:view';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new blade view file';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'View';

	/**
	 * Get the destination class path.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function getPath($name)
	{
		return './resources/views/' . str_replace('.', '/', $this->argument('name')) . '.blade.php';
	}
}
