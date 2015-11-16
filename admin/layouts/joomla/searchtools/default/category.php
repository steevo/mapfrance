<?php
/**
 * Joomla! 3.0 component Collector
 *
 * @package 	Collector
 * @copyright   Copyright (C) 2010 - 2015 Philippe Ousset. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * Collector is a Multi Purpose Listing Tool.
 * Originaly developped to list Collections
 * it can be used for several purpose.
 */

defined('JPATH_BASE') or die;

$data = $displayData;

if ($data['view']->getName() == 'areas') {
// We will get the defined filter & remove it from the form filters
	$mapField = $data['view']->filterForm->getField('map');
	?>
	<div class="js-stools-field-filter js-stools-map">
		<?php echo $mapField->input; ?>
	</div>
	<?php
}