<?php
/**
 * Part of the Joomla! Framework Form Package
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Form\Field;

use Joomla\Form\Html\Select as HtmlSelect;

/**
 * Integer Form Field class for the Joomla! Framework.
 *
 * Provides a select list of integers with specified first, last and step values.
 *
 * @since  1.0
 */
class IntegerField extends ListField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $type = 'Integer';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   1.0
	 */
	protected function getOptions()
	{
		$options = array();

		$select = new HtmlSelect;

		// Try to inject the text object into the field
		try
		{
			$select->setText($this->getText());
		}
		catch (\RuntimeException $exception)
		{
			// A Text object was not set, ignore the error and try to continue processing
		}

		// Initialize some field attributes.
		$first = (int) $this->element['first'];
		$last = (int) $this->element['last'];
		$step = (int) $this->element['step'];

		// Sanity checks.
		if ($step == 0)
		{
			// Step of 0 will create an endless loop.
			return $options;
		}
		elseif ($first < $last && $step < 0)
		{
			// A negative step will never reach the last number.
			return $options;
		}
		elseif ($first > $last && $step > 0)
		{
			// A position step will never reach the last number.
			return $options;
		}
		elseif ($step < 0)
		{
			// Build the options array backwards.
			for ($i = $first; $i >= $last; $i += $step)
			{
				$options[] = $select->option($i);
			}
		}
		else
		{
			// Build the options array.
			for ($i = $first; $i <= $last; $i += $step)
			{
				$options[] = $select->option($i);
			}
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
