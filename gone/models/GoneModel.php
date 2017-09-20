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

class GoneModel extends BaseElementModel
{
	
	protected $elementType = 'Gone';
	
    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(
        	parent::defineAttributes(), 
        	array(
		    	'elementId' => array(AttributeType::String),
				'type' => array(AttributeType::String),
				'title'=> array(AttributeType::String), 
				'slug' => array(AttributeType::String),
				'uri' => array(AttributeType::String),
				'redirect' => array(AttributeType::String)
			)
		);
    }

}