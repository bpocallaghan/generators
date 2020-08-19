<?php

namespace Bpocallaghan\Generators\Commands;

class RequestCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form Request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';
}
