<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:model';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new Eloquent model class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Model';

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace)
	{
		return $rootNamespace . '\Models';
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

		$table = str_plural(snake_case($this->argument('name')));

		// regions
		$stub = str_replace('{{table}}', $table, $stub);

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
			['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file as well.'],
		];
	}
}