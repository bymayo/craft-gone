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
            	'elementTypeOriginal' => $postAttributes['elementTypeOriginal'],
				'elementTitle' => $postAttributes['elementTitle'],
				'elementSlug' => $postAttributes['elementSlug'],
				'elementUri' => $postAttributes['elementUri'],
				'redirectType' => $postAttributes['redirectType']
			)
		);
		
		$redirect->getContent()->title =  $postAttributes['elementTitle'];

        if (craft()->gone->saveRedirect($redirect)) {
            craft()->userSession->setNotice(Craft::t('Redirect saved.'));
            $this->redirectToPostedUrl($redirect);
        }
        else {
            craft()->userSession->setError(Craft::t('Couldn’t save redirect.'));
        }
    }
	
}