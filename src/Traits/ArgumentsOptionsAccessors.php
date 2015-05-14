<?php

namespace Bpocallaghan\Generators\Traits;

trait ArgumentsOptionsAccessors
{
	/**
	 * Get the argument name of the file that needs to be generated
	 * If settings exist, remove the postfix from the file
	 *
	 * @return array|mixed|string
	 */
	protected function getArgumentName()
	{
		if ($this->settings)
		{
			return str_replace($this->settings['postfix'], '', $this->argument('name'));
		}

		return $this->argument('name');
	}

	/**
	 * Get the value for the force option
	 *
	 * @return array|string
	 */
	protected function getOptionForce()
	{
		return $this->option('force');
	}

	/**
	 * Get the value for the plain option
	 *
	 * @return array|string
	 */
	protected function getOptionPlain()
	{
		return $this->option('plain');
	}

	/**
	 * Get the value for the stub option
	 *
	 * @return array|string
	 */
	protected function getOptionStub()
	{
		return $this->option('stub');
	}

	/**
	 * Get the value for the model option
	 *
	 * @return array|string
	 */
	protected function getOptionModel()
	{
		return $this->option('model');
	}
}