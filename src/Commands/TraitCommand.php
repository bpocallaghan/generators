<?php

namespace Bpocallaghan\Generators\Commands;

class TraitCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Trait file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';
}