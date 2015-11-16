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

$data = $displayData;

if ($data['view']->getName() == 'areas') {
	// Receive overridable options
	$data['options'] = !empty($data['options']) ? $data['options'] : array();

	$doc = JFactory::getDocument();

	$doc->addStyleDeclaration("
		/* Fixed filter field in search bar */
		.js-stools .js-stools-map {
			float: left;
			margin-right: 10px;
		}
		html[dir=rtl] .js-stools .js-stools-map {
			float: right;
			margin-left: 10px
			margin-right: 0;
		}
		.js-stools .js-stools-container-bar .js-stools-field-filter .chzn-container {
			padding: 3px 0;
		}
	");

	// defined filter doesn't have to activate the filter bar
	unset($data['view']->activeFilters['map']);
}
?>
<div class="js-stools clearfix">
	<div class="clearfix">
		<div class="js-stools-container-bar">
			<?php echo JLayoutHelper::render('joomla.searchtools.default.category', $data); ?>
		</div>
	</div>
</div>

<?php
// Display the main joomla layout
echo JLayoutHelper::render('joomla.searchtools.default', $data, null, array('component' => 'none'));
