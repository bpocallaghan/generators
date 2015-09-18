<?php

namespace Bpocallaghan\Generators\Commands;

class ControllerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';
}