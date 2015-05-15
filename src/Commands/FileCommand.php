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
	protected $description = 'Create a file from a stub in the config';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'File';

	/**
	 * Get the filename of the file to generate
	 *
	 * @return string
	 */
	private function getFileName()
	{
		$name = $this->getArgumentNameOnly();

		switch ($this->option('type'))
		{
			case 'view':
				$name = ($this->option('view-name') ? $this->option('view-name') : $name);
				break;
			case 'model':
				$name = $this->getModelName();
				break;
			case 'controller':
				$name = $this->getControllerName($name);
				break;
			case 'seed':
				$name = $this->getSeedName($name);
				break;
		}

		return $this->settings['prefix'] . $name . $this->settings['postfix'] . $this->settings['file_type'];
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// setup
		$this->setSettings();
		$this->resource = $this->getResourceName($this->getUrl());

		// check the path where to create and save file
		$path = $this->getPath('');
		if ($this->files->exists($path) && $this->option('force') === false)
		{
			return $this->error($this->type . ' already exists!');
		}

		// make all the directories
		$this->makeDirectory($path);

		// build file and save it at location
		$this->files->put($path, $this->buildClass($this->argumentName()));

		// output to console
		$this->info(ucfirst($this->option('type')) . ' created successfully.');
		$this->info('- ' . $path);

		// if we need to run "composer dump-autoload"
		if ($this->settings['dump_autoload'] === true)
		{
			$this->composer->dumpAutoloads();
		}
	}

	/**
	 * Get the destination class path.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function getPath($name)
	{
		$name = $this->getFileName();

		$withName = boolval($this->option('view-name'));

		$path = $this->settings['path'];
		if($this->settingsDirectoryNamespace() === true)
		{
			$path .= $this->getArgumentPath($withName);
		}

		$path .= $name;

		return $path;
	}

	/**
	 * Build the class with the given name.
	 *
	 * @param  string $name
	 * @return string
	 */
	protected function buildClass($name)
	{
		$stub = $this->files->get($this->getStub());

		// foo.bar = App\Foo
		$stub = str_replace('{{namespace}}', $this->getNamespace($name), $stub);

		// App\
		$stub = str_replace('{{rootNamespace}}', $this->getAppNamespace(), $stub);

		// foo.bar = bar
		$stub = str_replace('{{class}}', $this->getClassName(), $stub);

		$url = $this->getUrl();

		// /foo/bar
		$stub = str_replace('{{url}}', $this->getUrl(), $stub);

		// posts
		$stub = str_replace('{{collection}}', $this->getCollectionName(), $stub);

		// Post
		$stub = str_replace('{{model}}', $this->getModelName(), $stub);

		// post
		$stub = str_replace('{{resource}}', $this->resource, $stub);

		// Posts
		$stub = str_replace('{{collectionUpper}}', ucwords($this->getCollectionName()), $stub);

		// Posts
		$stub = str_replace('{{path}}', ucwords($this->getPath('')), $stub);

		// posts || posts.comments
		$stub = str_replace('{{view}}', $this->getViewPath($url), $stub);

		// posts
		$stub = str_replace('{{table}}', $this->getTableName($url), $stub);

		return $stub;
	}

	/**
	 * Get the full namespace name for a given class.
	 *
	 * @param  string $name
	 * @param bool    $withApp
	 * @return string
	 */
	protected function getNamespace($name, $withApp = true)
	{
		$path = str_replace('/', '\\', $this->getArgumentPath()) . $this->settings['namespace'];

		$pieces = array_map('ucfirst', explode('/', $path));

		$namespace = ($withApp === true ? $this->getAppNamespace() : '') . implode('\\', $pieces);

		$namespace = rtrim(ltrim(str_replace('\\\\', '\\', $namespace), '\\'), '\\');

		return $namespace;
	}

	/**
	 * Get the url for the given name
	 *
	 * @return string
	 */
	protected function getUrl()
	{
		return '/' . rtrim(implode('/', array_map('strtolower', explode('/', $this->getArgumentPath(true)))), '/');
	}

	/**
	 * Get the class name
	 * @return mixed
	 */
	protected function getClassName()
	{
		return str_replace([$this->settings['file_type']], [''], $this->getFileName());
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array_merge([
			['type', null, InputOption::VALUE_OPTIONAL, 'The type of file: model, view, controller, migration, seed', 'view'],
			['view-name', null, InputOption::VALUE_NONE, 'If you want a custom name for the view files'],
		], parent::getOptions());
	}
}
