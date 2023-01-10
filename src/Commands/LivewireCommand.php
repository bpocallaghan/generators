<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class LivewireCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:livewire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Livewire Component and View';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Livewire';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
//        $this->call('generate:file', [
//                'name' => $this->argumentName(),
//                '--type'  => strtolower($this->type),
//                '--stub' => 'repository_contract',
//            ]);

//        if (!$this->option('contract')) {
            parent::handle();
//        } else {
//            $this->call('generate:repository', [
//                'name' => $this->argumentName(),
//                '--stub' => 'repository_contract',
//            ]);
//        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge([

        ], parent::getOptions());
    }
}
