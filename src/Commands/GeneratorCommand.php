<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;

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
}