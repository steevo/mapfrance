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
 * Area View
 */
class MapFranceViewArea extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;
	
	/**
	 * display method of defined view
	 * @return void
	 */
	public function display($tpl = null)
	{
		// get the Data
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		// $canDo		= MapFranceHelper::getActions();
		
		JToolBarHelper::title($isNew ? JText::_('COM_MAPFRANCE_AREAS_MANAGER_AREA_NEW') : JText::_('COM_MAPFRANCE_AREAS_MANAGER_AREA_EDIT'));
		
		// Built the actions for new and existing records.
		if ($isNew) 
		{
			// For new records, check the create permission.
			// if ($canDo->get('core.create')) 
			// {
				JToolBarHelper::apply('area.apply');
				JToolBarHelper::save('area.save');
				JToolBarHelper::cancel('area.cancel');
			// }
		}
		else
		{
			// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
			// if ($canDo->get('core.edit')) {
				JToolBarHelper::apply('area.apply');
				JToolBarHelper::save('area.save');
			// }

			// If checked out, we can still save
			// if ($canDo->get('core.create')) {
				//JToolBarHelper::save2copy('area.save2copy');
			// }

			JToolBarHelper::cancel('area.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
?>