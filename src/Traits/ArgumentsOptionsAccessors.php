<?php

namespace Bpocallaghan\Generators\Traits;

trait ArgumentsOptionsAccessors
{
    /**
     * Get the argument name of the file that needs to be generated
     * If settings exist, remove the postfix from the file
     */
    protected function argumentName()
    {
        if ($this->settings) {
            return str_replace($this->settings['postfix'], '', $this->argument('name'));
        }

        return $this->argument('name');
    }

    /**
     * Get the value for the force option
     */
    protected function optionForce()
    {
        return $this->option('force');
    }

    /**
     * Get the value for the plain option
     */
    protected function optionPlain()
    {
        return $this->option('plain');
    }

    /**
     * Get the value for the stub option
     */
    protected function optionStub()
    {
        return $this->option('stub');
    }

    /**
     * Get the value for the model option
     */
    protected function optionModel()
    {
        return $this->option('model');
    }

    /**
     * Get the value for the schema option
     */
    protected function optionSchema()
    {
        return $this->option('schema');
    }

    /**
     * Get the value for the name option
     */
    protected function optionName()
    {
        return $this->option('name');
    }
}
