<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class FileCommand extends GeneratorCommand
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:file';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a file from any stub in the config';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'File';

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		$key = $this->option('stub') . '_stub';
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
		$type = $this->option('type');
		$name = $this->argument('name');
		switch($type)
		{
			case 'model':
				return parent::getPath($name);
				break;
			case 'view':
				return './resources/views/' . str_replace('.', '/', $name) . '.blade.php';
				break;
			case 'controller':
				return $this->getControllerPath($name);
				break;
		}

		$this->error('Oops, we could not find the stub for the type: "' . $type . '"');
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
			['type', null, InputOption::VALUE_OPTIONAL, 'The type of file: model, view, controller, migration, seed', 'view'],
			['force', null, InputOption::VALUE_NONE, 'Warning: Overide file if it already exist'],
		];
	}
}
