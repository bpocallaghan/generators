<?php

namespace Bpocallaghan\Generators\Commands;

class ViewIndexCommand extends ViewCommand
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
