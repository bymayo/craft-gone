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

class GoneController extends BaseController
{
	
	protected $allowAnonymous = true;

    public function actionSaveRedirect()
    {
        $this->requirePostRequest();

        $id = craft()->request->getPost('id');
		$redirect = craft()->gone->getById($id);

        $postAttributes = craft()->request->getPost();
        
        $redirect->setAttributes(
        	array(
            	'type' => $postAttributes['type'],
				'title' => $postAttributes['title'],
				'slug' => $postAttributes['slug'],
				'uri' => $postAttributes['uri'],
				'redirect' => $postAttributes['redirect']
			)
		);
		
		$redirect->getContent()->title =  $postAttributes['title'];

        if (craft()->gone->saveRedirect($redirect)) {
            craft()->userSession->setNotice(Craft::t('Redirect saved.'));
            $this->redirectToPostedUrl($redirect);
        }
        else {
            craft()->userSession->setError(Craft::t('Couldn’t save redirect.'));
        }
    }
	
}