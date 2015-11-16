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
 * Area Ordering Form Field class
 */
class JFormFieldAreaOrdering extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var        string
	 * @since   1.7
	 */
	protected $type = 'AreaOrdering';

	/**
	 * Method to get the list of siblings in a menu.
	 * The method requires that parent be set.
	 *
	 * @return  array  The field option objects or false if the parent field has not been set
	 * @since   1.7
	 */
	protected function getOptions()
	{
		$options = array();

		// Get the parent
		$parent_id = $this->form->getValue('parent_id', 0);
		
		if (empty($parent_id)&&($parent_id!=1))
		{
			return false;
		}
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.id AS value, a.title AS text')
			->from('#__mapfrance_areas AS a')
			->where('a.parent_id =' . (int) $parent_id);
		if ($map = $this->form->getValue('map'))
		{
			$query->where('a.map = ' . $db->quote($map));
		}
		else
		{
			$query->where('a.map != ' . $db->quote(''));
		}

		$query->order('a.lft ASC');

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

		$options = array_merge(
			array(array('value' => '-1', 'text' => JText::_('COM_MAPFRANCE_AREA_FIELD_ORDERING_VALUE_FIRST'))),
			$options,
			array(array('value' => '-2', 'text' => JText::_('COM_MAPFRANCE_AREA_FIELD_ORDERING_VALUE_LAST')))
		);

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}

	/**
	 * Method to get the field input markup
	 *
	 * @return  string  The field input markup.
	 * @since   1.7
	 */
	protected function getInput()
	{
		if ($this->form->getValue('id', 0) == 0)
		{
			return '<span class="readonly">' . JText::_('COM_MAPFRANCE_AREA_FIELD_ORDERING_TEXT') . '</span>';
		}
		else
		{
			return parent::getInput();
		}
	}
}
