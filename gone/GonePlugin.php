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

class GonePlugin extends BasePlugin
{

    public function getName()
    {
         return Craft::t('Gone');
    }

    public function getDescription()
    {
        return Craft::t('Tracks updated & deleted elements by creating automatic 404, 410, 301 or 302 errors.');
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/madebyshape/gone/blob/master/README.md';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/madebyshape/gone/master/releases.json';
    }

    public function getVersion()
    {
        return '2.0.2';
    }

    public function getSchemaVersion()
    {
        return '2.0.2';
    }

    public function getDeveloper()
    {
        return 'Jason Mayo';
    }

    public function getDeveloperUrl()
    {
        return 'bymayo.co.uk';
    }

    public function hasCpSection()
    {
        return true;
    }
    
	public function registerCpRoutes()
	{
		return array(
			'gone' => 'gone/index',
			'gone/edit/(?P<id>\d+)' => 'gone/edit'
		);
	}
    
    public function init()
    {
	    
    	global $elementTypes;
    	$elementTypes = array('Entry', 'Category', 'Commerce_Product');
	    
	    // Redirect
	    
	    if(!craft()->isConsole() && craft()->request->isSiteRequest()) {
    
	    	$gone = craft()->gone->check();
	    	
	    	if ($gone) {
		    	if ($gone->redirect === '410') {
			    	throw new HttpException(410, 'The requested element has been removed or gone and is no longer available.');	
		    	}
		    	else {
					$redirectElement = craft()->elements->getElementById($gone->elementId);
			    	craft()->request->redirect($redirectElement->url, true, $gone->redirect);
		    	}
	    	}
    	
    	}
    	
    	/*
	    		NOTE: Would be better if one of the Craft events worked for ALL
	    			  elements, instead of individually.
	    	*/
    	
    	// Delete - Entry

		craft()->on(
			'entries.deleteEntry', 
			function(Event $event) {
				craft()->gone->isDeleted($event->params['entry']);
			}
		);
		
		craft()->on(
			'entries.onSaveEntry', 
			function(Event $event) {
				
				global $elementTypes;
				$element = $event->params['entry'];
				
				if (in_array($element->elementType, $elementTypes)) {
					if ($event->params['isNewEntry']) {
						craft()->gone->isNew($element);
					}
					else {
						craft()->gone->isUpdated($element);
					}
				}
			}
		);
		
		// Delete - Category
		
		craft()->on(
			'categories.deleteCategory', 
			function(Event $event) {
				craft()->gone->isDeleted($event->params['category']);
			}
		);
		
		craft()->on(
			'categories.onSaveCategory', 
			function(Event $event) {
				
				global $elementTypes;
				$element = $event->params['category'];
				
				if (in_array($element->elementType, $elementTypes)) {
					if ($event->params['isNewCategory']) {
						craft()->gone->isNew($element);
					}
					else {
						craft()->gone->isUpdated($element);
					}
				}
			}
		);
		
		// Delete - Commerce
		
		craft()->on(
			'commerce_products.onDeleteProduct', 
			function(Event $event) {
				craft()->gone->isDeleted($event->params['product']);
			}
		);
		
		craft()->on(
			'commerce_products.onSaveProduct', 
			function(Event $event) {
				
				global $elementTypes;
				$element = $event->params['product'];
				
				if (in_array($element->elementType, $elementTypes)) {
					if ($event->params['isNewProduct']) {
						craft()->gone->isNew($element);
					}
					else {
						craft()->gone->isUpdated($element);
					}
				}
			}
		);
		
		// Get previous element before saved
		
		craft()->on(
			'elements.onBeforeSaveElement', 
			function(Event $event) {
				
				global $elementTypes;
				$element = $event->params['element'];
				
				if (in_array($element->elementType, $elementTypes)) {
					// Create session to store previous element (Before save) 
					$_SESSION['gone_element_' . $element->id] = serialize($element);
				}
				
			}
		);
		
		// Delete Bulk - All
		
		craft()->on(
			'elements.onBeforePerformAction',
			function(Event $event) {
				
				global $elementTypes;
				$action = $event->params['action']->classHandle;
				$elements = $event->params['criteria']->find();
				
				if ($action == 'Delete') {
					foreach ($elements as $element) {
						if (in_array($element->elementType, $elementTypes) && $element->title) {
							// Check to see if element deleted is not a 'Gone' element
							craft()->gone->isDeleted($element);
						}
						else {
							craft()->gone->isElementDeleted($element);
						}
					}
				}
				
			}
		);
		
		parent::init();
	    
    }
    
}