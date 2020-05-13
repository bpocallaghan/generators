<?php

namespace Bpocallaghan\Generators\Commands;

class ExceptionCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:exception';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Exception class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Exception';
}