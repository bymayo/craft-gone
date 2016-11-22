<?php
/**
 * Gone plugin for Craft CMS
 *
 * Gone Record
 *
 * @author    Jason Mayo
 * @copyright Copyright (c) 2016 Jason Mayo
 * @link      bymayo.co.uk
 * @package   Gone
 * @since     1.0.0
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
            'type' => array(AttributeType::String)
        );
    }

    /**
     * @return array
     */
    public function defineRelations()
    {
        return array(
        );
    }
}