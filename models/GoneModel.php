<?php
/**
 * Gone plugin for Craft CMS
 *
 * Gone Model
 *
 * @author    Jason Mayo
 * @copyright Copyright (c) 2016 Jason Mayo
 * @link      bymayo.co.uk
 * @package   Gone
 * @since     1.0.0
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
            'elementId' => array(AttributeType::Number),
            'title' => array(AttributeType::String),
            'slug' => array(AttributeType::String),
            'type' => array(AttributeType::String)
        ));
    }

}