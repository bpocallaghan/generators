<?php

namespace Bpocallaghan\Generators\Commands;

class ViewAddEditCommand extends ViewCommand
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
