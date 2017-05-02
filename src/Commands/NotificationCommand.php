<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputOption;

class NotificationCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Notification';
}