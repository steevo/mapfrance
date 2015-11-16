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
 * Areas Model
 */
class MapFranceModelAreas extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'map', 'a.map',
				'level', 'a.level',
				'path', 'a.path',
				'title', 'a.title',
				'lft', 'a.lft',
				'rgt', 'a.rgt',
			);
		}

		parent::__construct($config);
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		$path = $this->getUserStateFromRequest($this->context . '.filter.path', 'filter_path');
		$this->setState('filter.path', $path);
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$level = $this->getUserStateFromRequest($this->context . '.filter.level', 'filter_level', 0, 'int');
		$this->setState('filter.level', $level);
		
		$map = $this->getMap();
		
		if ($map)
		{
			if ($map != $app->getUserState($this->context.'.map'))
			{
				$app->setUserState($this->context.'.map', $map);
				$app->input->set('limitstart', 0);
			}
		}
		else
		{
			$app->redirect('index.php?option=com_mapfrance&view=maps');
		}
		
		$this->setState('filter.map', $map);

		// List state information.
		parent::populateState('a.lft', 'asc');
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 */
	protected function getMap()
	{
		$app = JFactory::getApplication();
		$map = $app->input->getString('map', null);
			
		if (!$map)
		{
			$query = 'SELECT id';
			$query .= ' FROM `#__mapfrance_maps`';
			$query .= ' LIMIT 1';
			
			$row = $this->_getList( $query );
			
			if ( $row == null )
			{
				return false;
			}
			else
			{
				return $row[0]->id;
			}
		}
		return $map;
	}
	
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 */
	protected function getListQuery()
	{
		$map = $this->getState('filter.map');
		
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.map, a.path, a.parent_id, a.level, a.title, a.lft, a.rgt'
			)
		);
		$query->from('#__mapfrance_areas AS a');
		
		$query->where('a.map = '.$map);
		
		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('a.title LIKE '.$search);
			}
		}
		
		// Filter on the level maximum.
		if ($level = $this->getState('filter.level'))
		{
			$query->where('a.level <= ' . (int) $level);
		}
		
		// Filter on the path.
		if ($path = $this->getState('filter.path'))
		{
			if ( $this->checkLevelPath($path,$level) )
			{
				$query->where('a.path != ' . $db->Quote($db->escape($path, true)));
				$path = $db->Quote('%'.$db->escape($path, true).'%');
				$query->where('a.path LIKE ' . $path);
			}	
		}
		
		// Add the list ordering clause.
		$query->order($db->escape($this->getState('list.ordering', 'a.lft')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
		
		return $query;
	}
	
	public function checkLevelPath($path,$level)
	{
		if ( $level == '' )
		{
			return true;
		}
		
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select('level');
		$query->from('#__mapfrance_areas');
		$query->where('path = '.$db->Quote($db->escape($path, true)));
		
		$db->setQuery( $query );
		
		$levelPath = $db->loadResult();
		
		if ( $level > $levelPath )
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Method to delete defined items
	 *
	 * @access	public
	 * @return	string	Message to display
	 */
	function delete($cid)
	{
		$row = $this->getTable('areas');
		
		foreach ($cid as $id)
		{
			if (!($row->delete($id)))
			{
				JError::raiseError( 500, $row->getError() );
				return false;
			}
		}
		
		return true;
	}
}
