<?php

namespace Bpocallaghan\Generators\Commands;

class MiddlewareCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:middleware';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Middleware class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Middleware';
}