<?php defined('SYSPATH') or die('No direct script access.');
/*
 * lyrsonrprtspg.php
 *      
 * Copyright 2012 Etherton Technologies
 * Written by: John Etherton <john@ethertontech.com>
 * File started on: 03.02.2012 14:24:19 MST
 *      
 * The work is written on behalf of Arc Finance for the ARD-SWSS 
 * infrastructure investments in Afghanistan.
 * 
 * This is the hooks file that allows the plugin
 * to hook into what is happening in Ushahidi
 */

class lyrsonrprtspg {
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{	
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{

		if(Router::$controller == "reports")
		{
			//don't think we'll need this, but just in case, I'm going to leave it here for the
			//time being ETHERTON
			//Event::add('ushahidi_filter.fetch_incidents_set_params', array($this,'_add_incident_filter'));
			
			Event::add('ushahidi_action.report_filters_ui', array($this,'_add_report_filter_ui'));
			
			Event::add('ushahidi_action.header_scripts', array($this, '_add_report_filter_js'));
		}
	}
	
	/**
	 * This will add in the JavaScript needed for the user to pick what layer they want to see
	 */
	public function _add_report_filter_js()
	{
		$view = new View('lyrsonrprtspg/report_filter_js');
		$view->render(true);
	}
	
	/**
	 * This will add in the UI needed for the user to pick what layer they want to see
	 */
	public function _add_report_filter_ui()
	{
		//get the layers that we have
		$layers = ORM::factory('layer')->where('layer_visible', '1')->find_all();
		$view = new View('lyrsonrprtspg/report_filter_ui');
		$view->layers = $layers;
		$view->render(true);

	}
	
	/**
	 * This method will add in some Density Map specific filtering
	 */
	public function _add_incident_filter()
	{
		
	}
	
}//end class

new lyrsonrprtspg;
