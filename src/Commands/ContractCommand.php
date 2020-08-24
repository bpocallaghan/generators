<?php

namespace Bpocallaghan\Generators\Commands;

class ContractCommand extends GeneratorCommand
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'generate:contract';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new Contract class';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Contract';
}
