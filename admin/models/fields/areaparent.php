<?php
/**
 * Joomla! 3.0 component MapFrance
 *
 * @package 	MapFrance
 * @copyright   Copyright (C) 2015 Philippe Ousset. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Area Parent Form Field class
 */
class JFormFieldAreaParent extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var        string
	 * @since   1.6
	 */
	protected $type = 'AreaParent';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		$options = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.id AS value, a.title AS text, a.level')
			->from('#__mapfrance_areas AS a')
			->join('LEFT', $db->quoteName('#__mapfrance_areas') . ' AS b ON a.lft > a.lft AND a.rgt < b.rgt');

		if ($map = $this->form->getValue('map'))
		{
			$query->where('a.map = ' . $db->quote($map));
		}
		else
		{
			$query->where('a.map != ' . $db->quote(''));
		}

		// Prevent parenting to children of this item.
		if ($id = $this->form->getValue('id'))
		{
			$query->join('LEFT', $db->quoteName('#__mapfrance_areas') . ' AS p ON p.id = ' . (int) $id)
				->where('NOT(a.lft >= p.lft AND a.rgt <= p.rgt)');
		}

		$query->group('a.id, a.title, a.level, a.lft, a.rgt, a.map, a.parent_id')
			->order('a.lft ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		// Pad the option text with spaces using depth level as a multiplier.
		for ($i = 0, $n = count($options); $i < $n; $i++)
		{
			$options[$i]->text = str_repeat('- ', $options[$i]->level-1) . $options[$i]->text;
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
