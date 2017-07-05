<?php

namespace Bpocallaghan\Generators\Commands;

use Symfony\Component\Console\Input\InputArgument;

class MigrationPivotCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:migration:pivot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration pivot class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Pivot';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $name = $this->parseName($this->getNameInput());
        $path = $this->getPath($name);

        if ($this->files->exists($path) && $this->optionForce() === false) {
            return $this->error($this->type . ' already exists!');
        }

        // if we need to append the parent models
        $modelOne = $this->getModelName($this->argument('tableOne'));
        $modelTwo = $this->getModelName($this->argument('tableTwo'));
        if ($this->confirm("Add Many To Many Relationship in '{$modelOne}' and '{$modelTwo}' Models? [yes|no]")) {
            $this->addRelationshipsInParents();
        }

        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type . ' created successfully.');
        $this->info('- ' . $path);
    }

    /**
     * Empty 'name' argument
     *
     * @return string
     */
    protected function getNameInput()
    {
        return '';
    }

    /**
     * Parse the name and format.
     *
     * @param  string $name
     * @return string
     */
    protected function parseName($name)
    {
        $tables = array_map('str_singular', $this->getSortedTableNames());
        $name = implode('', array_map('ucwords', $tables));
        $pieces = explode('_', $name);
        $name = implode('', array_map('ucwords', $pieces));

        return "Create{$name}PivotTable";
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name = null)
    {
        return './database/migrations/' . date('Y_m_d_His') . '_create_' . $this->getPivotTableName() . '_pivot_table.php';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replacePivotTableName($stub)
            ->replaceSchema($stub)
            ->replaceClass($stub, $name);
    }

    /**
     * Apply the name of the pivot table to the stub.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replacePivotTableName(&$stub)
    {
        $stub = str_replace('{{pivotTableName}}', $this->getPivotTableName(), $stub);

        return $this;
    }

    /**
     * Apply the correct schema to the stub.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceSchema(&$stub)
    {
        $tables = $this->getSortedTableNames();

        $stub = str_replace(['{{columnOne}}', '{{columnTwo}}'],
            array_merge(array_map('str_singular', $tables), $tables), $stub);

        $stub = str_replace(['{{tableOne}}', '{{tableTwo}}'],
            array_merge(array_map('str_plural', $tables), $tables), $stub);

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        return str_replace('{{class}}', $class, $stub);
    }

    /**
     * Get the name of the pivot table.
     *
     * @return string
     */
    protected function getPivotTableName()
    {
        return implode('_', array_map('str_singular', $this->getSortedTableNames()));
    }

    /**
     * Sort the two tables in alphabetical order.
     *
     * @return array
     */
    protected function getSortedTableNames()
    {
        $tables = [
            strtolower($this->argument('tableOne')),
            strtolower($this->argument('tableTwo'))
        ];

        sort($tables);

        return $tables;
    }

    /**
     * Append Many to Many Relationships in Parent Models
     */
    public function addRelationshipsInParents()
    {
        $options = config('generators.settings');
        if (!$options['model']) {
            $this->info('Model files not found.');

            return;
        }

        $modelSettings = $options['model'];

        // model names
        $modelOne = $this->getModelName($this->argument('tableOne'));
        $modelTwo = $this->getModelName($this->argument('tableTwo'));

        // model path
        $modelOnePath = $modelSettings['path'] . $modelOne . '.php';
        $modelTwoPath = $modelSettings['path'] . $modelTwo . '.php';

        $this->addRelationshipInModel($modelOnePath, $modelTwo, $this->argument('tableTwo'));
        $this->addRelationshipInModel($modelTwoPath, $modelOne, $this->argument('tableOne'));
    }

    /**
     * Insert the many to many relationship in model
     * @param $modelPath
     * @param $relationshipModel
     * @param $tableName
     */
    private function addRelationshipInModel($modelPath, $relationshipModel, $tableName)
    {
        // load model
        $model = $this->files->get($modelPath);

        // get the position where to insert into file
        $index = strlen($model) - strpos(strrev($model), '}') - 1;

        // load many to many stub
        $stub = $this->files->get(config('generators.' . 'many_many_relationship_stub'));
        $stub = str_replace('{{model}}', $relationshipModel, $stub);
        $stub = str_replace('{{relationship}}', camel_case($tableName), $stub);
        //$stub = str_replace('{{relationship}}', strtolower(str_plural($relationshipModel)), $stub);

        // insert many many stub in model
        $model = substr_replace($model, $stub, $index, 0);

        // save model file
        $this->files->put($modelPath, $model);

        $this->info("{$relationshipModel} many to many Relationship added in {$modelPath}");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return config('generators.' . strtolower($this->type) . '_stub');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['tableOne', InputArgument::REQUIRED, 'The name of the first table.'],
            ['tableTwo', InputArgument::REQUIRED, 'The name of the second table.']
        ];
    }
}
