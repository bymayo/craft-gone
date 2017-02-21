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

class GoneService extends BaseApplicationComponent
{
    /*
	 * Add
     */
    public function add($element)
    {
	    
	    $siteUrl = craft()->config->get('siteUrl');

		$record = new GoneRecord;
		$record->setAttribute('elementId', $element->id);
		$record->setAttribute('type', $element->elementType);
		
	    $attributes = [
		    'title',
		    'slug',
		    'uri'
	    ];
		
	    foreach ($attributes as $attribute) {
			$record->setAttribute($attribute, $element->$attribute);
	    }

		$record->save();
		
		return false;
	    
    }
    
    /*
	 * Remove
     */
    public function remove($id)
    {
	    
	    $record = GoneRecord::model()->findByAttributes(
	    	array(
	    		'id' => $id
	    	)
	    );
	    
	    if ($record)
	    {
		    $record->delete();
	    }
	    
	    return false;
	    
    }
    
    /*
	 * Get All
     */
     public function getAll()
     {
	    
        $records = GoneRecord::model()->findAll();
        return GoneModel::populateModels($records);
	     
     }
     
    /*
	 * Get By URI
     */
	 public function getByUri($uri)
	 {

	 	if ($uri === null) {
	 		$uri = trim(craft()->request->getUrl(), '/');
	 	}

	    $model = new GoneModel;
	    $record = GoneRecord::model()->findByAttributes(
	    	array(
	    		'uri' => $uri
	    	)
	    );
	    
	    if ($record)
	    {
		    $model = GoneModel::populateModel($record);
		    return $model;
	    }
		 
	 }
	
    /*
	 * Check Element
     */
     public function checkElement($uri)
     {
	     
	     $criteria = craft()->elements->getCriteria(ElementType::Entry);
	     $criteria->uri = $uri;
	     $entries = $criteria->find();
	     
	     if ($entries) {
		     return $entries;
	     }
	     else {
		     return false;
	     }
	     
     }
	
    /*
	 * Check Segments
     */
     public function checkUri($uri)
     {

	    $element = craft()->gone->getByUri($uri);
	    
	    if (craft()->gone->checkElement($uri) && $element) {
		    craft()->gone->remove($element->id);
		    return false;   
	    }
	    else {
		    if ($element)
		    {
			    return $element;
		    }   
	    }
	    
	    return false;
	     
     }

}