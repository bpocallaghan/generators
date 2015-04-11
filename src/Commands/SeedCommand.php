<?php

namespace Bpocallaghan\Generators\Commands;

class SeedCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:seed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new database seed class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Seed';

	/**
	 * Parse the name and format according to the root namespace.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function parseName($name)
	{
		$name = $this->convertNameToNamespace($name);

		return $this->getSeedName($name);
	}

	/**
	 * Get the destination class path.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function getPath($name)
	{
		return './database/seeds/' . $this->getSeedName($name) . '.php';
	}
}
