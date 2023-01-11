<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class ConsoleCommand extends GeneratorCommand
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'generate:console';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new Artisan Console Command';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Console';

    /**
     * Add an extra option to use for generating the file
     * @var string
     */
    protected $extraOption = 'command';

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return array_merge([
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal command that should be assigned.', 'command:name'],
        ], parent::getOptions());
    }
}
