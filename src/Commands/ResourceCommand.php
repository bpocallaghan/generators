<?php

namespace Bpocallaghan\Generators\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ResourceCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Resource (Model, Views, Controller, Migration, Seeder)';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    private $repositoryContract = false;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->resource = $this->getResourceOnly();
        $this->settings = config('generators.defaults');

        $this->callModel();
        $this->callView();
        $this->callRepository();
        $this->callController();
        $this->callMigration();
        $this->callSeeder();
        $this->callTest();
        $this->callFactory();
        $this->callMigrate();

        // confirm dump autoload
        if ($this->confirm("Run 'composer dump-autoload'?")) {
            $this->composer->dumpAutoloads();
        }

        $this->info('All Done!');
        $this->info('Remember to add ' . "`Route::resource('" . str_replace(
            '_',
            '-',
            $this->getCollectionName()
        ) . "', '" . $this->getResourceControllerName() . "');`" . ' in `routes\\web.php`');
    }

    /**
     * Call the generate:model command
     */
    private function callModel(): void
    {
        $name = $this->getModelName();

        $resourceString = $this->getResourceOnly();
        $resourceStringLength = strlen($this->getResourceOnly());

        if ($resourceStringLength > 18) {
            $ans = $this->confirm("Your resource {$resourceString} may have too many characters to use for many to many relationships. The length is {$resourceStringLength}. Continue?");
            if ($ans === false) {
                echo "generate:resource cancelled!";
                die;
            }
        }

        if ($this->confirm("Create a $name model?")) {
            $this->callCommandFile('model');
        }
    }

    /**
     * Generate the resource views
     */
    private function callView(): void
    {
        if ($this->confirm("Create crud views for the $this->resource resource?")) {
            $views = config('generators.resource_views');
            foreach ($views as $key => $name) {
                $resource = $this->argument('resource');
                if (Str::contains($resource, '.')) {
                    $resource = str_replace('.', '/', $resource);
                }

                $this->callCommandFile(
                    'view',
                    $this->getViewPath($resource),
                    $key . $this->option('view'),
                    ['--name' => $name]
                );
            }
        }
    }

    /**
     * Generate the Repository / Contract Pattern files
     */
    private function callRepository(): void
    {
        // check the config
        if (config('generators.settings.controller.repository_contract')) {
            if ($this->confirm("Create a repository and contract for the $this->resource resource?")) {
                $name = $this->getModelName();

                $this->repositoryContract = true;

                $this->callCommandFile('contract', $name);
                $this->callCommandFile('repository', $name);

                //$contract = $name . config('generators.settings.contract.postfix');
                //$this->callCommandFile('repository', $name, ['--contract' => $contract]);
            }
        }
    }

    /**
     * Generate the resource controller
     */
    private function callController(): void
    {
        $name = $this->getResourceControllerName();

        if ($this->confirm("Create a controller ($name) for the $this->resource resource?")) {
            $arg = $this->getArgumentResource();
            $name = substr_replace(
                $arg,
                Str::plural($this->resource),
                strrpos($arg, $this->resource),
                strlen($this->resource)
            );

            if ($this->repositoryContract) {
                $this->callCommandFile('controller', $name, 'controller_repository');
            } else {

                // if admin - update stub
                if (Str::contains($name, 'admin.') || $this->option('controller') === 'admin') {
                    $this->callCommandFile('controller', $name, 'controller_admin');
                } else {
                    $this->callCommandFile('controller', $name, 'controller');
                }
            }
        }
    }

    /**
     * Call the generate:migration command
     */
    private function callMigration(): void
    {
        $name = $this->getMigrationName($this->option('migration'));

        if ($this->confirm("Create a migration ($name) for the $this->resource resource?")) {
            $this->callCommand('migration', $name, [
                '--model'  => false,
                '--schema' => $this->option('schema')
            ]);
        }
    }

    /**
     * Call the generate:seed command
     */
    private function callSeeder(): void
    {
        $name = $this->getSeedName() . config('generators.settings.seeder.postfix');

        if ($this->confirm("Create a seeder ($name) for the $this->resource resource?")) {
            $this->callCommandFile('seeder');
        }
    }

    /**
     * Call the generate:test command
     */
    private function callTest(): void
    {
        $name = $this->getModelName() . 'Test';

        if ($this->confirm("Create a test ($name) for the $this->resource resource?")) {
            // feature test
            $this->callCommandFile('test', Str::plural($name));

            // unit test
            $this->call('generate:file', [
                'name'   => $name,
                '--type' => 'test',
                '--unit' => 'Unit',
            ]);
        }
    }

    /**
     * Call the generate:factory command
     */
    private function callFactory(): void
    {
        $name = $this->getModelName() . 'Factory';

        if ($this->confirm("Create a factory ($name) for the $this->resource resource?")) {
            $this->callCommandFile('factory', $name);
        }
    }

    /**
     * Call the migrate command
     */
    protected function callMigrate(): void
    {
        if ($this->confirm('Migrate the database?')) {
            $this->call('migrate');
        }
    }

    /**
     * @param       $command
     * @param       $name
     * @param array $options
     */
    private function callCommand($command, $name, $options = []): void
    {
        $options = array_merge($options, [
            'name'    => $name,
            '--plain' => $this->option('plain'),
            '--force' => $this->option('force')
        ]);

        $this->call('generate:' . $command, $options);
    }

    /**
     * Call the generate:file command to generate the given file
     *
     * @param       $type
     * @param null  $name
     * @param null  $stub
     * @param array $options
     */
    private function callCommandFile($type, $name = null, $stub = null, $options = []): void
    {
        $this->call('generate:file', array_merge($options, [
            'name'    => ($name ? $name : $this->argument('resource')),
            '--type'  => $type,
            '--force' => $this->optionForce(),
            '--plain' => $this->optionPlain(),
            '--stub'  => ($stub ?: $this->optionStub()),
        ]));
    }

    /**
     * The resource argument
     * Lowercase and singular each word
     *
     * @return array|mixed|string
     */
    private function getArgumentResource()
    {
        $name = $this->argument('resource');
        if (Str::contains($name, '/')) {
            $name = str_replace('/', '.', $name);
        }

        if (Str::contains($name, '\\')) {
            $name = str_replace('\\', '.', $name);
        }

        // lowecase and singular
        $name = strtolower(Str::singular($name));

        return $name;
    }

    /**
     * If there are '.' in the name, get the last occurence
     *
     * @return string
     */
    private function getResourceOnly()
    {
        $name = $this->getArgumentResource();
        if (!Str::contains($name, '.')) {
            return $name;
        }

        return substr($name, strripos($name, '.') + 1);
    }

    /**
     * Get the Controller name for the resource
     *
     * @return string
     */
    private function getResourceControllerName(): string
    {
        return $this->getControllerName(
            Str::plural($this->resource),
            false
        ) . config('generators.settings.controller.postfix');
    }

    /**
     * Get the name for the migration
     *
     * @param null $name
     * @return string
     */
    private function getMigrationName($name = null): string
    {
        return 'create_' . Str::plural($this->getResourceName($name)) . '_table';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['resource', InputArgument::REQUIRED, 'The name of the resource being generated.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            [
                'view',
                null,
                InputOption::VALUE_OPTIONAL,
                'Specify the stub for the views',
                null
            ],
            [
                'controller',
                null,
                InputOption::VALUE_OPTIONAL,
                'Specify the stub for the controller',
                null
            ],
            ['migration', null, InputOption::VALUE_OPTIONAL, 'Optional migration name', null],
            [
                'schema',
                's',
                InputOption::VALUE_OPTIONAL,
                'Optional schema to be attached to the migration',
                null
            ],
        ]);
    }
}
