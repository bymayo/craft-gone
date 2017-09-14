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

class GoneRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return 'gone';
    }

    /**
     * @access protected
     * @return array
     */
   protected function defineAttributes()
    {
        return array(
	    	'elementId' => array(AttributeType::String),
			'elementTypeOriginal' => array(AttributeType::String),
			'elementTitle'=> array(AttributeType::String), 
			'elementSlug' => array(AttributeType::String),
			'elementUri' => array(AttributeType::String),
			'redirectType' => array(AttributeType::String)
        );
    }
}