<?php

namespace Bpocallaghan\Generators\Commands;

use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

abstract class GeneratorCommand extends LaravelGeneratorCommand
{

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return config('generators.' . strtolower($this->type) . '_stub');
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
			['plain', null, InputOption::VALUE_OPTIONAL, 'Generate an empty class.'],
		];
	}
}