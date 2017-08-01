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
    protected $description = 'Create a new Rrepository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';
}