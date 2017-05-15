<?php

namespace Bpocallaghan\Generators\Commands;

use File;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class PublishCommand extends GeneratorCommand
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
    protected $description = 'Copy stubs and config for user modification';

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
        $path = $this->getConfigPath();

        // if generatords config already exist
        if ($this->files->exists($path) && $this->option('force') === false) {
            $this->error("{$path} already exists! Run 'generate:publish-stubs --force' to override the config file.");
            die;
        }

        File::copy(__DIR__ . '/../config/config.php', $path);
    }

    /**
     * Copy the stubs directory
     */
    private function copyStubsDirectory()
    {
        $path = $this->option('path');

        // if controller stub already exist
        if ($this->files->exists($path . DIRECTORY_SEPARATOR . 'controller.stub') && $this->option('force') === false) {
            $this->error("Stubs already exists! Run 'generate:publish-stubs --force' to override the stubs.");
            die;
        }

        File::copyDirectory(__DIR__ . '/../../resources/stubs', $path);
    }

    /**
     * Update stubs path in the new published config file
     */
    private function updateStubsPathsInConfigFile()
    {
        $updated = str_replace('vendor/bpocallaghan/generators/', '',
            File::get($this->getConfigPath()));
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
            [
                'path',
                null,
                InputOption::VALUE_OPTIONAL,
                'Which directory should the templates be copied to?',
                'resources/stubs'
            ],
            ['force', null, InputOption::VALUE_NONE, 'Warning: Override files if it already exist']
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