<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class ModelCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        parent::fire();

        if ($this->option('migration')) {
            $name = $this->getMigrationName();

            $this->call('generate:migration', [
                'name'     => $name,
                '--model'  => false,
                '--schema' => $this->option('schema')
            ]);
        }
    }

    /**
     * Get the name for the migration
     *
     * @return string
     */
    private function getMigrationName()
    {
        return 'create_' . str_plural(strtolower($this->getArgumentNameOnly())) . '_table';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge([
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file as well.'],
            ['schema', 's', InputOption::VALUE_OPTIONAL, 'Optional schema to be attached to the migration', null],
        ], parent::getOptions());
    }
}