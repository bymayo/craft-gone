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
	
	public function isNew() {}
	public function isUpdated() {}
	public function isDelete() {}
	
	public function getElementById($id){
		
		// Lookup in elements table for the type based on the ID, then pass the type to the criteria below
		
		$criteria = craft()->elements->getCriteria();
		$criteria->id = $id;
		
		$element = $criteria->find();
		
		return $element;
		
	}
	
    /*
	 * Add
     */
    public function add($element)
    {
	    
	    $attributes = [
		    'elementType',
		    'elementTitle',
		    'elementSlug',
		    'elementUri',
		    'redirectElementId',
		    'redirectType'
	    ];
	    
	    // Create Element
	    $model = new GoneModel();
	    
	    // Set Element Values
	    
	    $model->elementType = $element->elementType;
	    $model->elementTitle = $element->title;
	    $model->elementSlug = $element->slug;
	    $model->elementUri = $element->uri;
	    
	    $model->redirectElementId = 2;
	    $model->redirectType = "302";
	    
	    // Set Element Title
	    $model->getContent()->title = $element->title;
	    
	    if ($this->getById($element->id)) {
			GonePlugin::log('Exists, Updating Redirect Element ID');
	    }
	    else {
			// 
	    }
	    
	    // Check to see if entry exists or not
	    
	    // Create New Record
	    $record = new GoneRecord();
	    
	    // Set Element Values
	    foreach ($attributes as $attribute) {
		    $record->$attribute = $model->$attribute;
	    }
	    
	    // Validate Record
		$record->validate();
		
		if ($record) {
			if (craft()->elements->saveElement($model)) {
			    $record->id = $model->id;  
				$record->save();
				return true;
			}
		}
	    
	    return false;
	    
    }
    
    public function getBySlug($slug)
    {
	    
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