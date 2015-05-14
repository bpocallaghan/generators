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
		$this->settings = config('generators.defaults');

		$this->callModel();
		$this->callView();
		$this->callController();
		$this->callMigration();
		$this->callSeed();
		$this->callMigrate();

		$this->info('All Done!');
		$this->info('Remember to add ' .
			"`Route::resource('" . $this->getCollectionName() . "', '" .
			$this->getControllerName() . "');`" .
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
			$this->callCommandFile('model');
		}
	}

	/**
	 * Generate the resource views
	 */
	private function callView()
	{
		if ($this->confirm("Create crud views for the $this->resource resource? [yes|no]"))
		{
			$views = config('generators.resource_views');
			foreach ($views as $key => $name)
			{
				$this->callCommandFile('view', $key, ['--view-name' => $name]);
			}
		}
	}

	/**
	 * Generate the resource controller
	 */
	private function callController()
	{
		$name = $this->getControllerName(str_plural($this->resource), false) . config('generators.settings.controller.postfix');

		if ($this->confirm("Create a controller ($name) for the $this->resource resource? [yes|no]"))
		{
			$this->callCommandFile('controller');
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
		$name = $this->getSeedName() . config('generators.settings.seed.postfix');

		if ($this->confirm("Create a seed ($name) for the $this->resource resource? [yes|no]"))
		{
			$this->callCommandFile('seed');
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
	 * Call the generate:file command to generate the given file
	 *
	 * @param       $type
	 * @param null  $stub
	 * @param array $options
	 */
	private function callCommandFile($type, $stub = null, $options = [])
	{
		$this->call('generate:file', array_merge($options, [
			'name'    => $this->argument('resource'),
			'--type'  => $type,
			'--force' => $this->getOptionForce(),
			'--plain' => $this->getOptionPlain(),
			'--stub'  => ($stub ? $stub : $this->getOptionStub()),
		]));
	}

	/**
	 * If there are '.' in the name, get the last occurence
	 *
	 * @return string
	 */
	private function getResourceInput()
	{
		$name = $this->argument('resource');
		if (strpos($name, '.') === false)
		{
			return strtolower(str_singular($name));
		}

		return strtolower(str_singular(substr($name, strpos($name, '.') + 1)));
	}

	/**
	 * Get the name for the migration
	 *
	 * @param null $name
	 * @return string
	 */
	private function getMigrationName($name = null)
	{
		return 'create_' . str_plural($this->getResourceName($name)) . '_table';
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
