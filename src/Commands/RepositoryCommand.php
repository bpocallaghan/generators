<?php

namespace Bpocallaghan\Generators\Commands;

class RepositoryCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Add an extra option to use for generating the file
     * @var string
     */
    //protected $extraOption = 'contract';

    /**
     * Get the console command options.
     *
     * @return array
     */
    /*protected function getOptions()
    {
        return array_merge([
            [
                'contract',
                null,
                InputOption::VALUE_OPTIONAL,
                'The name of the contract interface to implement.',
                'Contract'
            ],
        ], parent::getOptions());
    }*/
}