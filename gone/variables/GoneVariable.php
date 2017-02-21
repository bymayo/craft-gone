<?php
/**
 * Gone
 *
 * @author    Jason Mayo
 * @twitter   @madebymayo
 * @package   Gone
 *
 */

namespace Craft;

class GoneVariable
{
    
	/*
	 * Plugin Folder
	*/
	public function pluginFolder()
	{
		return 'gone';
	}
	
	/*
	 * Plugin Name
	*/
	public function pluginName()
	{
		return craft()->plugins->getPlugin($this->pluginFolder())->getName();
	}
    
   	/*
	 * Get By URI
	*/
    public function getByUri($uri = null)
    {
	    return craft()->gone->getByUri($uri);
    }
    
   	/*
	 * Get All
	*/
    public function getAll()
    {
	    return craft()->gone->getAll();
    }
    
}