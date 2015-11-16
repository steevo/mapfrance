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
 
/**
 * MapFrance component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
class MapFranceHelper
{
	public static $extension = 'com_mapfrance';
	
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */
 
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_MAPFRANCE_SUBMENU_MAPS'),
			'index.php?option=com_mapfrance',
			$submenu == 'maps'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('COM_MAPFRANCE_SUBMENU_AREAS'),
			'index.php?option=com_mapfrance&view=areas',
			$submenu == 'areas'
		);
 
		// Set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-helloworld ' .
										'{background-image: url(../media/com_helloworld/images/tux-48x48.png);}');
		if ($submenu == 'areas') 
		{
			$document->setTitle(JText::_('COM_MAPFRANCE_ADMINISTRATION_AREAS'));
		}
	}
}