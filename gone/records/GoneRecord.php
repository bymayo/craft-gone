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
            'elementId' => array(AttributeType::Number),
            'title' => array(AttributeType::String),
            'slug' => array(AttributeType::String),
            'uri' => array(AttributeType::String),
            'type' => array(AttributeType::String)
        );
    }
}