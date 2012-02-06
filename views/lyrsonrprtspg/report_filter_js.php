<?php defined('SYSPATH') or die('No direct script access.');
/*
 * report_filter_js.php
 *      
 * Copyright 2012 Etherton Technologies
 * Written by: John Etherton <john@ethertontech.com>
 * File started on: 03.02.2012 16:28:21 MST
 *      
 * The work is written on behalf of Arc Finance for the ARD-SWSS 
 * infrastructure investments in Afghanistan.
 * 
 * This is the file that renders the JavaScript for the user to pick what
 * layer they want to view.
 */
 ?>
 
<script type="text/javascript">

var select =[];

/**
* Remove all the selected layers
*/
function lyrsonrprtspgClearLayers()
{
	//remove the UI selection
	$(".lyrsonrprtspg_lyr_lnk").removeClass("selected");
	//remove the layers
	$(".lyrsonrprtspg_lyr_lnk").each(function(){
		removeLayerByLayerId($(this).attr("id"));
	});
}

//make sure the map gets initialized before they click on a layer
function lyrsonrprtspgCheckMap()
{
	//if the map hasn't been intialized yet, initialize it.
	if(map == null)
	{
		switchViews($("#reports-box .report-list-toggle a.map"));
	}
}

/**
* Toggle the layers
*/
function lyrsonrprtsprgToggleLayer(layerId, layerLink, layerColor)
{

	//I know we already check for this, but just in case.s
	if(map == null)
	{
		switchViews($("#reports-box .report-list-toggle a.map"));
	}

	//Is there a layer already with that name?
	new_layer = map.getLayersByName("Layer_"+layerId);
	//if so remove it
	if (new_layer.length != 0)
	{
		removeLayerByLayerId("Layer_"+layerId);
	}
	//otherwise add it
	else
	{		
		var kmlLayer = new OpenLayers.Layer.Vector("Layer_"+layerId, {
            strategies: [new OpenLayers.Strategy.Fixed()],
            protocol: new OpenLayers.Protocol.HTTP({
                url: layerLink,
                format: new OpenLayers.Format.KML({
                    extractStyles: true, 
                    extractAttributes: true,
                    maxDepth: 2
                })
            })
        });
        map.addLayer(kmlLayer);
        
        kmlLayer.events.on({
                "featureselected": onKMLSelect,
                "featureunselected": onKMLUnselect
            });
        
        select["Layer_"+layerId] = new OpenLayers.Control.SelectFeature(kmlLayer);
        map.addControl(select["Layer_"+layerId]);
        select["Layer_"+layerId].activate();  
        
     
	}
}

function onKMLPopupClose(evt) {
	for(s in select)
	{
		select[s].unselectAll();
	}
}
function onKMLSelect(event) {
	var feature = event.feature;

	var content = "<h2>"+feature.attributes.name + "</h2>" + feature.attributes.description;
	popup = new OpenLayers.Popup.FramedCloud("chicken", 
							 feature.geometry.getBounds().getCenterLonLat(),
							 new OpenLayers.Size(100,100),
							 content,
							 null, true, onKMLPopupClose);
	feature.popup = popup;
	map.addPopup(popup);
}
function onKMLUnselect(event) {
	var feature = event.feature;
	if(feature.popup) {
		map.removePopup(feature.popup);
		feature.popup.destroy();
		delete feature.popup;
	}
}


/**
 * Remove layers
 */
function removeLayerByLayerId(layerId)
{
	new_layer = map.getLayersByName(layerId);
	for (var i = 0; i < new_layer.length; i++)
	{
		map.removeLayer(new_layer[i]);
	}					
}



</script>
