<?php

namespace Bpocallaghan\Generators\Commands;

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
    protected $description = 'Create a new Notification class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Notification';
}