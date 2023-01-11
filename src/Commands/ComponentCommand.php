<?php

namespace Bpocallaghan\Generators\Commands;

class ComponentCommand extends GeneratorCommand
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'generate:component';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new Component Component and View';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Component';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        parent::handle();

        $this->call('generate:file', [
            'name' => $this->argumentName(),
            '--type' => strtolower($this->type) . '_view',
            '--stub' => strtolower($this->type) . '_view',
        ]);
    }
}
