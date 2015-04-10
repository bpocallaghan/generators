<?php

namespace Bpocallaghan\Generators\Commands;

use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

abstract class GeneratorCommand extends LaravelGeneratorCommand
{

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$name = $this->parseName($this->getNameInput());

		$path = $this->getPath($name);

		if ($this->files->exists($path) && $this->option('force') === false)
		{
			return $this->error($this->type.' already exists!');
		}

		$this->makeDirectory($path);

		$this->files->put($path, $this->buildClass($name));

		$this->info($this->type.' created successfully.');

		$this->info('- ' . $path = $this->getPath($name));
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return config('generators.' . strtolower($this->type) . ($this->option('plain')? '_plain':'') . '_stub');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The name of class being generated.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['plain', null, InputOption::VALUE_NONE, 'Generate an empty class.'],
			['force', null, InputOption::VALUE_NONE, 'Warning: Overide file if it already exist'],
		];
	}
}