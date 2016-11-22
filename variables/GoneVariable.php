<?php

namespace Craft;

class GoneVariable
{
    
    public function elementId($elementId)
    {
	    return craft()->gone->elementId($elementId);
    }
    
}