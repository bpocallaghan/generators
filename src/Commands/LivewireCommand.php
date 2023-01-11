<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class LivewireCommand extends GeneratorCommand
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'generate:livewire';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new Livewire Component and View';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Livewire';

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

        if ($this->option('request') === true || $this->option('request') === 'true') {
            $this->call('generate:request', [
                'name' => $this->argumentName(),
            ]);
        }
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return array_merge([
            ['request', null, InputOption::VALUE_NONE, 'Want a request for this component?'],
        ], parent::getOptions());
    }
}
