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

class GoneModel extends BaseModel
{
    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
	        'id' => array(AttributeType::Number),
            'elementId' => array(AttributeType::Number),
            'title' => array(AttributeType::String),
            'slug' => array(AttributeType::String),
            'uri' => array(AttributeType::String),
            'type' => array(AttributeType::String),
            'dateCreated' => array(AttributeType::DateTime),
            'dateUpdated' => array(AttributeType::DateTime)
        ));
    }

}