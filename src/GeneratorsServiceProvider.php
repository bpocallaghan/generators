<?php

namespace Bpocallaghan\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{

	private $commandPath = 'command.bpocallaghan.';
	private $packagePath = 'Bpocallaghan\Generators\Commands\\';

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// merge config
		$configPath = __DIR__ . '/config/config.php';
		$this->mergeConfigFrom($configPath, 'generators');

		// register all the artisan commands
		$this->registerCommand('PublishCommand', 'publish');
		$this->registerCommand('ControllerCommand', 'controller');
		$this->registerCommand('ModelCommand', 'model');
		$this->registerCommand('MigrationCommand', 'migration');
		$this->registerCommand('MigrationPivotCommand', 'migrate.pivot');
		$this->registerCommand('SeedCommand', 'seed');
		$this->registerCommand('ViewCommand', 'view');
		$this->registerCommand('ViewIndexCommand', 'view.index');
		$this->registerCommand('ViewAddEditCommand', 'view.add_edit');
		$this->registerCommand('ViewShowCommand', 'view.show');
		$this->registerCommand('ResourceCommand', 'resource');
		$this->registerCommand('FileCommand', 'file');
	}

	/**
	 * Register a singleton command
	 *
	 * @param $class
	 * @param $command
	 */
	private function registerCommand($class, $command)
	{
		$this->app->singleton($this->commandPath . $command, function ($app) use ($class)
		{
			return $app[$this->packagePath . $class];
		});

		$this->commands($this->commandPath . $command);
	}

}
