<?php

namespace Bpocallaghan\Generators\Commands;

class JobCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Job class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job';
}