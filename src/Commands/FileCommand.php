<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class FileCommand extends GeneratorCommand
{

  use \Illuminate\Console\AppNamespaceDetectorTrait;

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

		// overide the name
		if($this->option('name'))
		{
			return $this->option('name') . $this->settings['file_type'];
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
		if ($this->files->exists($path) && $this->optionForce() === false)
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

		$withName = boolval($this->option('name'));

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

		// examples used for the placeholders is for 'foo.bar'

		// App\Foo
		$stub = str_replace('{{namespace}}', $this->getNamespace($name), $stub);

		// App\
		$stub = str_replace('{{rootNamespace}}', $this->getAppNamespace(), $stub);

		// Bar
		$stub = str_replace('{{class}}', $this->getClassName(), $stub);

		$url = $this->getUrl(); // /foo/bar

		// /foo/bar
		$stub = str_replace('{{url}}', $this->getUrl(), $stub);

		// bars
		$stub = str_replace('{{collection}}', $this->getCollectionName(), $stub);

		// Bars
		$stub = str_replace('{{collectionUpper}}', ucwords($this->getCollectionName()), $stub);

		// Bar
		$stub = str_replace('{{model}}', $this->getModelName(), $stub);

		// bar
		$stub = str_replace('{{resource}}', $this->resource, $stub);

		// ./resources/views/foo/bar.blade.php
		$stub = str_replace('{{path}}', $this->getPath(''), $stub);

		// foos.bars
		$stub = str_replace('{{view}}', $this->getViewPath($url), $stub);

		// bars
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
		$path = (strlen($this->settings['namespace']) >= 2? $this->settings['namespace'] . '\\' : '');

		// dont add the default namespace if specified not to in config
		if($this->settingsDirectoryNamespace() === true)
		{
			$path .= str_replace('/', '\\', $this->getArgumentPath());
		}

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
		return ucwords(camel_case(str_replace([$this->settings['file_type']], [''], $this->getFileName())));
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
		], parent::getOptions());
	}
}
