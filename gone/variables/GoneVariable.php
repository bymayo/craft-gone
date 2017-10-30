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
	
	public function pluginFolder()
	{
		return 'gone';
	}

	public function pluginName()
	{
		return craft()->plugins->getPlugin($this->pluginFolder())->getName();
	}
	
	public function getById($id)
	{
		return craft()->gone->getById($id);
	}

    public function check($uri = null)
    {
	    return craft()->gone->check($uri);
    }
    
}