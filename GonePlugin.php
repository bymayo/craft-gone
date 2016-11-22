<?php
/**
 * Gone plugin for Craft CMS
 *
 * When an element is deleted, it logs this as a element that existed and pushes 410 errors to Google etc.
 *
 * @author    Jason Mayo
 * @copyright Copyright (c) 2016 Jason Mayo
 * @link      bymayo.co.uk
 * @package   Gone
 * @since     1.0.0
 */

namespace Craft;

class GonePlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
	    
	    // Entries
	    
		craft()->on(
			'entries.deleteEntry', 
			function(Event $event) {
				$element = $event->params['entry'];
				craft()->gone->add($element);
			}
		);
		
		craft()->on(
			'elements.onBeforePerformAction',
			function(Event $event) {
				
				// Get 'Action' type
				$action = $event->params['action']->classHandle;
				
				// Get Elements within the action
				$elements = $event->params['criteria']->find();
				
				if ($action == 'Delete') {
					foreach ($elements as $element) {
						craft()->gone->add($element);
					}
				}
				
			}
		);
		
		// Categories, Users, Locales to be done
	    
    }

    public function getName()
    {
         return Craft::t('Gone');
    }

    public function getDescription()
    {
        return Craft::t('When an element is deleted, it logs this as a element that existed and pushes 410 errors to Google etc.');
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
        return '1.0.0';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
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
        return false;
    }

    public function onBeforeInstall()
    {
    }

    public function onAfterInstall()
    {
    }

    public function onBeforeUninstall()
    {
    }

    public function onAfterUninstall()
    {
    }
}