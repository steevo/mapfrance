<?php
/**
 * Joomla! 3.0 component MapFrance
 *
 * @package 	MapFrance
 * @copyright   Copyright (C) 2015 Philippe Ousset. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
/**
 * Map Form Field class for the MapFrance component
 */
class JFormFieldMap extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Map';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,name');
		$query->from('#__mapfrance_maps');
		$db->setQuery((string) $query);
		$maps = $db->loadObjectList();
		$options  = array();
 
		if ($maps)
		{
			foreach ($maps as $map)
			{
				$options[] = JHtml::_('select.option', $map->id, $map->name);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}