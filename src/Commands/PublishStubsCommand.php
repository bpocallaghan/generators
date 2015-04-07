<?php

namespace Bpocallaghan\Generators\Commands;

use File;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class PublishStubsCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:publish-stubs';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Copy generator stubs for user modification';

	/**
	 * Execute the command
	 */
	public function fire()
	{
		$this->copyConfigFile();
		$this->copyStubsDirectory();
		$this->updateStubsPathsInConfigFile();

		$this->info("The config file has been copied to '" . $this->getConfigPath() . "'.");
		$this->info("The stubs have been copied to '{$this->option('path')}'.");
	}

	/**
	 * Copy the config file to the default config folder
	 */
	private function copyConfigFile()
	{
		File::copy(__DIR__ . '/../config/config.php', $this->getConfigPath());
	}

	/**
	 * Copy the stubs directory
	 */
	private function copyStubsDirectory()
	{
		File::copyDirectory(__DIR__ . '/../../resources/stubs', $this->option('path'));
	}

	/**
	 * Update stubs path in the new published config file
	 */
	private function updateStubsPathsInConfigFile()
	{
		$updated = str_replace('packages/bpocallaghan/generators/', '', File::get($this->getConfigPath()));
		File::put($this->getConfigPath(), $updated);
	}

	/**
	 * Get the config file path
	 *
	 * @return string
	 */
	private function getConfigPath()
	{
		return config_path('generators.php');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['path', null, InputOption::VALUE_OPTIONAL, 'Which directory should the templates be copied to?', 'resources/stubs']
		];
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		//
	}
}