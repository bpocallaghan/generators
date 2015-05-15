<?php

namespace Bpocallaghan\Generators\Traits;

trait SettingsAccessors
{

	/**
	 * Settings of the file type to be generated
	 *
	 * @var array
	 */
	protected $settings = [];

	/**
	 * Find the type's settings and set local var
	 */
	public function setSettings()
	{
		$type = $this->option('type');
		$options = config('generators.settings');

		$found = false;
		// loop through the settings and find the type key
		foreach ($options as $key => $settings)
		{
			if ($type == $key)
			{
				$found = true;
				break;
			}
		}

		if ($found === false)
		{
			$this->error('Oops!, no settings key by the type name provided');
			exit;
		}

		// set the default keys and values if they do not exist
		$defaults = config('generators.defaults');
		foreach ($defaults as $key => $value)
		{
			if (!isset($settings[$key]))
			{
				$settings[$key] = $defaults[$key];
			}
		}

		$this->settings = $settings;
	}

	/**
	 * Return false or the value for given key from the settings
	 * @param $key
	 * @return bool
	 */
	public function settingsKey($key)
	{
		if (is_array($this->settings) == false && isset($this->settings[$key]) == false)
		{
			return false;
		}

		return $this->settings[$key];
	}

	/**
	 * Get the directory format setting's value
	 */
	protected function settingsDirectoryFormat()
	{
		return $this->settings['directory_format'];
	}

	/**
	 * Get the directory format setting's value
	 */
	protected function settingsDirectoryNamespace()
	{
		return $this->settingsKey('directory_namespace') ? $this->settings['directory_namespace'] : false;
	}
}
