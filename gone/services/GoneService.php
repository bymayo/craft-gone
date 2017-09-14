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
		    'elementTypeOriginal',
		    'elementTitle',
		    'elementSlug',
		    'elementUri',
		    'redirectType'
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
		
		$elementSession = unserialize($_SESSION['gone_element_' . $element->id]);
		
		if ($element->uri !== $elementSession->uri) {
			$this->removeByUri($element->uri);			
			$this->createRedirect($elementSession, 301);
		}
		
	}
	
	public function isDeleted($element){
		
		$this->createRedirect($element, 410);
		$this->updateRedirectType($element, 410);

	}
	
	public function isElementDeleted($element)
	{
		
		$this->removeByUri($element->elementUri);
	}
	
	public function removeByUri($uri)
	{
	    
	    $record = GoneRecord::model()->findAllByAttributes(
	    	array(
	    		'elementUri' => $uri
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
				'redirectType' => $redirectType
			),
			'elementId = '. $element->id
		);
		
	}
	
	public function createRedirect($element, $redirectType)
	{
		
		$attributes = [
			'elementId',
		    'elementTypeOriginal',
		    'elementTitle',
		    'elementSlug',
		    'elementUri',
		    'redirectType'
	    ];
	    
	    // Create Element
	    $model = new GoneModel();
	    
	    // Set Element Values
	    $model->elementId = $element->id;
	    $model->elementTypeOriginal = $element->elementTypeOriginal;
	    $model->elementTitle = $element->title;
	    $model->elementSlug = $element->slug;
	    $model->elementUri = $element->uri;
	    $model->redirectType = $redirectType;
	    
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
	    $record = GoneRecord::model()->findByAttributes(array('elementUri' => $uri));
	    
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