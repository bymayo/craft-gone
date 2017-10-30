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
	
	public function saveRedirect(GoneModel $redirect)
	{
		
		$attributes = [
			'elementId',
		    'type',
		    'title',
		    'slug',
		    'uri',
		    'redirect'
	    ];

        if ($redirect->id) {
            $record = GoneRecord::model()->findById($redirect->id);
        }
        
	    foreach ($attributes as $attribute) {
		    $record->$attribute = $redirect->$attribute;
	    }

        $record->validate();
        
        $redirect->addErrors($record->getErrors());
        
        if (!$redirect->hasErrors()) {
            return $record->save();
        }
        return false;
		
	}
	
	public function isNew($element)
	{
		$this->removeByUri($element->uri);
	}
	
	public function isUpdated($element)
	{
		
		$session = $_SESSION['gone_element_' . $element->id];
		$elementSession = unserialize($session);
		
		if ($element->uri !== $elementSession->uri) {
			$this->removeByUri($element->uri);			
			$this->createRedirect($elementSession, 301);
		}
		
		// Remove session to ensure no performance issues
		unset($session);
		
	}
	
	public function isDeleted($element){
		
		$this->createRedirect($element, 410);
		$this->updateRedirectType($element, 410);

	}
	
	public function isElementDeleted($element)
	{
		
		$this->removeByUri($element->uri);
	}
	
	public function removeByUri($uri)
	{
	    
	    $record = GoneRecord::model()->findAllByAttributes(
	    	array(
	    		'uri' => $uri
	    	)
	    );
	    
	    if ($record)
	    {
		    foreach ($record as $recordElement) {
			    craft()->elements->deleteElementById($recordElement->id);
			    $recordElement->delete();		
		    }
	    }
		
	}
	
	public function updateRedirectType($element, $redirectType)
	{
		
		$record = GoneRecord::model()->updateAll(
			array(
				'redirect' => $redirectType
			),
			'elementId = '. $element->id
		);
		
	}
	
	public function createRedirect($element, $redirectType)
	{
		
		$attributes = [
			'elementId',
		    'type',
		    'title',
		    'slug',
		    'uri',
		    'redirect'
	    ];
	    
	    // Create Element
	    $model = new GoneModel();
	    
	    // Set Element Values
	    $model->elementId = $element->id;
	    $model->type = $element->elementType;
	    $model->title = $element->title;
	    $model->slug = $element->slug;
	    $model->uri = $element->uri;
	    $model->redirect = $redirectType;
	    
	    // Set Element Title
	    $model->getContent()->title = $element->title;
	    
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
				// Create ID and relate to ID in element table
			    $record->id = $model->id;  
				$record->save();
				return true;
				
			}
		}
	    
	    return false;
		
	}
	
	public function check($uri = null)
	{
		
	 	if (!$uri) {
	 		$uri = trim(craft()->request->getPath(), '/');
	 	}

	    $model = new GoneModel;
	    $record = GoneRecord::model()->findByAttributes(array('uri' => $uri));
	    
	    if ($record)
	    {
		    $model = GoneModel::populateModel($record);
		    return $model;
	    }
		
	}
	
	public function getById($id)
	{
		
	    $model = new GoneModel;
	    $record = GoneRecord::model()->findByAttributes(array('id' => $id));
	    
	    if ($record)
	    {
		    $model = GoneModel::populateModel($record);
		    return $model;
	    }
		
		return true;
		
	}

}