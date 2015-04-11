<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class ViewCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:view';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new blade view file';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'View';

	/**
	 * Build the class with the given name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function buildClass($name)
	{
		$stub = parent::buildClass($name);

		// foo.bar => Foo\Bar
		$name = $this->convertNameToNamespace($name);

		// /posts/comments
		$stub = str_replace('{{url}}', '/' . str_replace('.', '/', $this->argument('name')), $stub);

		// posts
		$stub = str_replace('{{collection}}', $this->getCollectionName($name), $stub);

		// Post
		$stub = str_replace('{{model}}', $this->getModelName($name), $stub);

		// post
		$stub = str_replace('{{resource}}', $this->getResourceName($name), $stub);

		// Posts
		$stub = str_replace('{{collectionUpper}}', ucwords($this->getCollectionName($name)), $stub);

		// Posts
		$stub = str_replace('{{path}}', ucwords($this->getPath($name)), $stub);

		return $stub;
	}

	/**
	 * Get the destination class path.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function getPath($name)
	{
		return './resources/views/' . str_replace('.', '/', $this->argument('name')) . '.blade.php';
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['force', null, InputOption::VALUE_NONE, 'Warning: Overide file if it already exist'],
		];
	}
}
