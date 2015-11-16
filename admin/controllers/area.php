<?php
/**
 * Joomla! 3.0 component MapFrance
 *
 * @package 	MapFrance
 * @copyright   Copyright (C) 2015 Philippe Ousset. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Area Controller
 */
class MapFranceControllerArea extends JControllerForm
{
	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param	array	An array of input data.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	protected function allowAdd($data = array())
	{
		// Initialise variables.
		$user	= JFactory::getUser();
		$allow	= $user->authorise('core.create', 'com_mapfrance');

		if ($allow === null) {
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd();
		}
		else {
			return $allow;
		}
	}
	
	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Initialise variables.
		$recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
		$user		= JFactory::getUser();
		$userId		= $user->get('id');

		// Check general edit permission first.
		if ($user->authorise('core.edit', 'com_mapfrance')) {
			return true;
		}

		// Fallback on edit.own.
		// First test if the permission is available.
		if ($user->authorise('core.edit.own', 'com_mapfrance')) {
			// Now test the owner is the user.
			$ownerId	= (int) isset($data['created_by']) ? $data['created_by'] : 0;
			if (empty($ownerId) && $recordId) {
				// Need to do a lookup from the model.
				$record		= $this->getModel()->getItem($recordId);

				if (empty($record)) {
					return false;
				}

				$ownerId = $record->created_by;
			}

			// If the owner matches 'me' then do the test.
			if ($ownerId == $userId) {
				return true;
			}
		}

		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}
	
	/**
	 * Gets the URL arguments to append to an item redirect.
	 *
	 * @param    int        $recordId    The primary key id for the item.
	 * @param    string    $urlVar        The name of the URL variable for the id.
	 *
	 * @return    string    The arguments to append to the redirect URL.
	 */
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$app = JFactory::getApplication();
		
		$append = parent::getRedirectToItemAppend($recordId, $urlVar);
		
		$map = $app->input->getVar('map');
		
		if (empty($map))
		{
			$form = $app->input->getVar('jform');
			
			$map = $form['map'];
		}
		
		$append .= '&map='.$map;
		
		return $append;
    }
	
	/**
	* Gets the URL arguments to append to a list redirect.
	*
	* @return    string    The arguments to append to the redirect URL.
	*/
	protected function getRedirectToListAppend()
	{
		$app = JFactory::getApplication();
		
		$append = parent::getRedirectToListAppend();
		
		$form = $app->input->getVar('jform');
		
		$append .= '&map='.$form['map'];
		
		return $append;
	}
}