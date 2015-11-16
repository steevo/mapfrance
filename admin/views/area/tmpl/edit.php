<?php
/**
 * Joomla! 3.0 component MapFrance
 *
 * @package 	MapFrance
 * @copyright   Copyright (C) 2015 Philippe Ousset. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

// no direct access

defined('_JEXEC') or die('Restricted access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JForm::addFieldPath(JPATH_COMPONENT . '/models/fields');

// Load the tooltip behavior.
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');
?>

<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'area.cancel' || document.formvalidator.isValid(document.id('item-form')))
		{
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_mapfrance&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-horizontal" >
	<fieldset>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'basic')); ?>

			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'basic', empty($this->item->id) ? JText::_('COM_MAPFRANCE_NEW_AREA', true) : JText::sprintf('COM_MAPFRANCE_EDIT_AREA', $this->item->id, true)); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('map'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('map'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('parent_id'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('parent_id'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('listordering'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('listordering'); ?></div>
				</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'styling', JText::_('COM_MAPFRANCE_AREA_STYLING', true)); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('areacolor'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('areacolor'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('bordercolor'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('bordercolor'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('borderwidth'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('borderwidth'); ?></div>
				</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</fieldset>
</form>
