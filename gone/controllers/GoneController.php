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
	
	public function actionGoneIndex()
	{
		$this->renderTemplate('gone/_index');
	}
	
	public function actionRemove()
	{
		
        $id = craft()->request->getParam('id');
		craft()->gone->remove($id);
		return $this->redirect(craft()->request->getUrlReferrer());
		
	}
	
}