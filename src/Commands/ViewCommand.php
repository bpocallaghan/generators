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
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		$key = 'view_' . $this->option('stub') . '_stub';
		$stub = config('generators.' . $key);

		if(is_null($stub))
		{
			$this->error('The stub does not exist in the config file - "' . $key . '"');
			exit;
		}

		return $stub;
	}

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
			['stub', null, InputOption::VALUE_OPTIONAL, 'The name of the view stub you would like to generate.', 'index'],
			['force', null, InputOption::VALUE_NONE, 'Warning: Overide file if it already exist'],
		];
	}
}
