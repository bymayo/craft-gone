<?php
/**
 * Gone plugin for Craft CMS
 *
 * Gone Service
 *
 * @author    Jason Mayo
 * @copyright Copyright (c) 2016 Jason Mayo
 * @link      bymayo.co.uk
 * @package   Gone
 * @since     1.0.0
 */

namespace Craft;

class GoneService extends BaseApplicationComponent
{
    /*
	 * Add
     */
    public function add($element)
    {
	    
	    $attributes = [
		    'title',
		    'slug'
	    ];

		$record = new GoneRecord;
		$record->setAttribute('elementId', $element->id);
		$record->setAttribute('type', $element->elementType);
		
	    foreach ($attributes as $attribute) {
			$record->setAttribute($attribute, $element->$attribute);
	    }

		$record->save();
		
		return false;
	    
    }
    
    /*
	 * Get By Element ID
	*/
	public function elementId($elementId)
	{
		
	    $model = new GoneModel;
	    $record = GoneRecord::model()->findByAttributes(
	    	array(
	    		'elementId' => $elementId
	    	)
	    );
	    
	    if ($record)
	    {
		    $model = GoneModel::populateModel($record);
		    return $model;
	    }
	}
	
    /*
	 * Get By Slug
     */
	public function slug($slug)
	{
		
	    $model = new GoneModel;
	    $record = GoneRecord::model()->findByAttributes(
	    	array(
	    		'slug' => $slug
	    	)
	    );
	    
	    if ($record)
	    {
		    $model = GoneModel::populateModel($record);
		    return $model;
	    }
	}

}