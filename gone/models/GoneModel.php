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
				'elementTypeOriginal' => array(AttributeType::String),
				'elementTitle'=> array(AttributeType::String), 
				'elementSlug' => array(AttributeType::String),
				'elementUri' => array(AttributeType::String),
				'redirectType' => array(AttributeType::String)
			)
		);
    }

}