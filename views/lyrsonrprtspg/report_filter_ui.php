<?php defined('SYSPATH') or die('No direct script access.');
/*
 * report_filter_ui.php
 *      
 * Copyright 2012 Etherton Technologies
 * Written by: John Etherton <john@ethertontech.com>
 * File started on: 03.02.2012 16:12:18 MST
 *      
 * The work is written on behalf of Arc Finance for the ARD-SWSS 
 * infrastructure investments in Afghanistan.
 * 
 * This is the file that renders the UI for the user to pick what
 * layer they want to view.
 */
 ?>
<h3 onclick="lyrsonrprtspgCheckMap(); return false;">
	<a href="#" id="lyrsonrprtspgClearAll" class="small-link-button f-clear reset" onclick="lyrsonrprtspgClearLayers();">
		<?php echo Kohana::lang('ui_main.clear'); ?>
	</a>
	<a class="f-title" id="lyrsonrprtspgTitle" href="#"><?php echo Kohana::lang('lyrsonrprtspg.layers'); ?></a>
</h3>
<div class="f-lyrsonrprtspg-box" >
	<ul class="filter-list fl-lyrsonrprtspg">
		<?php foreach( $layers as $layer)
		{ 
			$layer_url = $layer->layer_url;
			$layer_file = $layer->layer_file;
			$layer_link = (!$layer_url) ? url::base().Kohana::config('upload.relative_directory').'/'.$layer_file : $layer_url;
			?>
		<li>
			<a href="#" id="Layer_<?php echo $layer->id; ?>" onclick="lyrsonrprtsprgToggleLayer(<?php echo $layer->id; ?>, '<?php echo $layer_link; ?>', '<?php echo $layer->layer_color; ?>'); return false;" class="lyrsonrprtspg_lyr_lnk" style="color:#<?php echo $layer->layer_color; ?>">
				<?php echo $layer->layer_name; ?>
			</a>
		</li>
		<?php } ?>
	</ul>
</div>
