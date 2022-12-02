<?php

namespace Bpocallaghan\Generators\Traits;

trait ArgumentsOptions
{
    /**
     * Get the argument name of the file that needs to be generated
     * If settings exist, remove the postfix from the file
     */
    protected function argumentName(): array|bool|string|null
    {
        if ($this->settings) {
            return str_replace($this->settings['postfix'], '', $this->argument('name'));
        }

        return $this->argument('name');
    }

    /**
     * Get the value for the force option
     */
    protected function optionForce(): bool|array|string|null
    {
        return $this->option('force');
    }

    /**
     * Get the value for the plain option
     */
    protected function optionPlain(): bool|array|string|null
    {
        return $this->option('plain');
    }

    /**
     * Get the value for the stub option
     */
    protected function optionStub(): bool|array|string|null
    {
        return $this->option('stub');
    }

    /**
     * Get the value for the model option
     */
    protected function optionModel(): bool|array|string|null
    {
        return $this->option('model');
    }

    /**
     * Get the value for the schema option
     */
    protected function optionSchema(): bool|array|string|null
    {
        return $this->option('schema');
    }

    /**
     * Get the value for the name option
     */
    protected function optionName(): bool|array|string|null
    {
        return $this->option('name');
    }

    /**
     * Get the value for the name option
     */
    protected function optionTest(): bool|array|string|null
    {
        return $this->option('test');
    }

    /**
     * Get the value for the extra option
     */
    protected function optionExtra(): bool|array|string|null
    {
        return $this->option($this->extraOption);
    }
}
