<?php

namespace Bpocallaghan\Generators\Commands;

use Illuminate\Support\Str;
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
    protected $description = 'Create a new Eloquent Model class';

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
    public function handle()
    {
        parent::handle();

        if ($this->option('migration')) {
            $this->call('generate:migration', [
                'name' => $this->getMigrationName(),
                '--model' => false,
                '--schema' => $this->option('schema')
            ]);
        }

        if ($this->option('factory')) {
            $this->call('generate:factory', [
                'name' => $this->getArgumentNameOnly(),
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
        $name = $this->getArgumentNameOnly();
        $name = preg_replace('/\B([A-Z])/', '_$1', $name);
        $name = strtolower($name);
        $name = Str::plural($name);

        return "create_{$name}_table";
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
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory file as well.'],
            ['schema', 's', InputOption::VALUE_OPTIONAL, 'Optional schema to be attached to the migration', null],
        ], parent::getOptions());
    }
}
