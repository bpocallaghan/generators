<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class TestCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new test class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Test';

    /**
     * Add an extra option to use for generating the file
     * @var string
     */
    protected $extraOption = 'unit';

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge([
            [
                'unit',
                null,
                InputOption::VALUE_OPTIONAL,
                'Create a unit test.',
                'Feature'
            ],
        ], parent::getOptions());
    }
}