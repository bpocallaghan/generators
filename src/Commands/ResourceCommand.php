<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ResourceCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:resource';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new resource (model, views, controller, migration, seed)';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Resource';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->resource = $this->getResourceInput();

		$this->callModel();
		$this->callView();
		$this->callController();
		$this->callMigration();
		$this->callSeed();
		$this->callMigrate();

		$this->info('All Done!');
		$this->info('Remember to add ' .
			"`Route::resource('" . $this->getCollectionName() . "', '" .
			$this->getControllerName($this->convertNameToNamespace($this->argument('resource'))) . "');`" .
			' in the `app\\Http\\routes.php`');
	}

	/**
	 * Call the generate:model command
	 */
	private function callModel()
	{
		$name = $this->getModelName();

		if ($this->confirm("Create a $name model? [yes|no]"))
		{
			$this->callCommand('model', $name);
		}
	}

	/**
	 * Call the generate:view command
	 */
	private function callView()
	{
		if ($this->confirm("Create crud views for the $this->resource resource? [yes|no]"))
		{
			$name = str_plural($this->argument('resource'));

			foreach (['index', 'add_edit', 'show'] as $key => $command)
			{
				$this->call('generate:view:' . $command, [
					'name'    => $name,
					'--force' => $this->option('force')
				]);
			}
		}
	}

	/**
	 * Call the generate:controller command
	 */
	private function callController()
	{
		$namespace = $this->convertNameToNamespace($this->argument('resource'));

		$name = $this->getControllerName($namespace);

		if ($this->confirm("Create a controller ($name) for the $this->resource resource? [yes|no]"))
		{
			$this->callCommand('controller', $name);
		}
	}

	/**
	 * Call the generate:migration command
	 */
	private function callMigration()
	{
		$name = $this->getMigrationName($this->option('migration'));

		if ($this->confirm("Create a migration ($name) for the $this->resource resource? [yes|no]"))
		{
			$this->callCommand('migration', $name, [
				'--model'  => false,
				'--schema' => $this->option('schema')
			]);
		}
	}

	/**
	 * Call the generate:seed command
	 */
	private function callSeed()
	{
		$name = $this->getSeedName();

		if ($this->confirm("Create a seed ($name) for the $this->resource resource? [yes|no]"))
		{
			$this->callCommand('seed', $name);
		}
	}

	/**
	 * Call the migrate command
	 */
	protected function callMigrate()
	{
		if ($this->confirm('Migrate the database? [yes|no]'))
		{
			$this->call('migrate');
		}
	}

	/**
	 * @param       $command
	 * @param       $name
	 * @param array $options
	 */
	private function callCommand($command, $name, $options = [])
	{
		$options = array_merge($options, [
			'name'    => $name,
			'--plain' => $this->option('plain'),
			'--force' => $this->option('force')
		]);

		$this->call('generate:' . $command, $options);
	}

	/**
	 * If there are '.' in the name, get the last occurence
	 *
	 * @return string
	 */
	private function getResourceInput()
	{
		if (strpos($this->argument('resource'), '.') === false)
		{
			return strtolower(str_singular($this->argument('resource')));
		}

		return strtolower(str_singular(substr($this->argument('resource'), strpos($this->argument('resource'), '.') + 1)));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['resource', InputArgument::REQUIRED, 'The name of the resource being generated.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array_merge(parent::getOptions(), [
			['migration', null, InputOption::VALUE_OPTIONAL, 'Optional migration name', null],
			['schema', 's', InputOption::VALUE_OPTIONAL, 'Optional schema to be attached to the migration', null],
		]);
	}

}
