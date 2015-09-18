<?php

namespace Bpocallaghan\Generators\Commands;

class SeedCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database seed class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seed';
}
