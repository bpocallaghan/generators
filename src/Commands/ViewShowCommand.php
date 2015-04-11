<?php

namespace Bpocallaghan\Generators\Commands;

class ViewShowCommand extends ViewCommand
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
