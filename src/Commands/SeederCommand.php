<?php

namespace Bpocallaghan\Generators\Commands;

class SeederCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Database Seeder class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';
}
