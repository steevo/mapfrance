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
 
// Require helper file
JLoader::register('MapFranceHelper', JPATH_COMPONENT . '/helpers/mapfrance.php');

// Get an instance of the controller prefixed by MapFrance
$controller = JControllerLegacy::getInstance('MapFrance');
 
// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));
 
// Redirect if set by the controller
$controller->redirect();