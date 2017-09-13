<?php
namespace Craft;

/**
 * Events - Event element type
 */
class GoneElementType extends BaseElementType
{

	public function getName()
	{
		return Craft::t('Gone');
	}

	public function hasContent()
	{
		return true;
	}

	public function hasTitles()
	{
		return false;
	}

	public function getSources($context = null)
	{
		$sources = array(
			'*' => array(
				'label' => Craft::t('All'),
                'defaultSort' => array('dateCreated', 'desc')
			),
			'gone:1' => array(
				'heading' => 'Redirect Type'
			),
			'gone:2' => array(
				'label' => Craft::t('301 - Permanent'),
                'criteria' => array('redirectType' => 301),
			),
			'gone:3' => array(
				'label' => Craft::t('302 - Temporary'),
                'criteria' => array('redirectType' => 302),
			),
			'gone:4' => array(
				'label' => Craft::t('410 - Removed'),
                'criteria' => array('redirectType' => 410),
			),
			'gone:5' => array(
				'heading' => 'Type'
			),
			'gone:6' => array(
				'label' => Craft::t('Entry'),
                'criteria' => array('elementType' => 'Entry'),
			),
			'gone:7' => array(
				'label' => Craft::t('Category'),
                'criteria' => array('elementType' => 'Category'),
			),
			'gone:8' => array(
				'label' => Craft::t('Product'),
                'criteria' => array('elementType' => 'Product'),
			)
		);

		return $sources;
	}
	
    public function getAvailableActions($source = null)
    {
        $actions = array();

        $deleteAction = craft()->elements->getAction('Delete');
        $deleteAction->setParams(
        	array(
            	'confirmationMessage' => Craft::t('Are you sure you want to delete the selected elements?'),
				'successMessage' => Craft::t('Elements deleted.'),
			)
		);
        
        $actions[] = $deleteAction;

        return $actions;
    }

	public function defineTableAttributes($source = null)
	{
		return array(
			'id' => Craft::t('ID'),
			'elementUri' => Craft::t('URI'),
			'elementId' => Craft::t('Redirect To'),
			'redirectType' => Craft::t('Redirect Type'),
			'elementType' => Craft::t('Type'),
			'dateCreated' =>  Craft::t('Date Created')
		);
	}

	public function getTableAttributeHtml(BaseElementModel $element, $attribute)
	{

        switch ($attribute) {
	        case 'elementUri': 
	        
	        	return '<a href="">' . $element->elementUri . "</a>";
	        	break;
	        
            case 'elementId':
            
                $redirectElement = craft()->db->createCommand()
                        ->select('uri')
                        ->from('elements_i18n')
                        ->where('elementId=:elementId', array(':elementId' => $element->elementId))
                        ->queryScalar();

                return $redirectElement;
                break;

            default:
                return parent::getTableAttributeHtml($element, $attribute);
                break;
        }

	}
	
    public function defineSortableAttributes()
    {
        return array(
            'id'    => Craft::t('ID'),
            'elementUri' => Craft::t('URI'),
            'dateCreated' => Craft::t('Date Created')
        );
    }

	public function defineCriteriaAttributes()
	{
		return array(
			'elementUri' => AttributeType::Mixed,
			'elementType' => AttributeType::Mixed,
			'elementTitle' => AttributeType::Mixed,
			'redirectType' => AttributeType::Mixed,
			'dateCreated' => AttributeType::Mixed,
			'order'      => array(AttributeType::String, 'default' => 'gone.dateCreated asc')
		);
	}

	public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
	{
		
		$query
			->addSelect('gone.elementId, gone.elementType, gone.elementTitle, gone.elementSlug, gone.elementUri, gone.redirectType, gone.dateCreated')
			->join('gone gone', 'gone.id = elements.id');
			
		if ($criteria->redirectType)
		{
			$query->andWhere(DbHelper::parseParam('gone.redirectType', $criteria->redirectType, $query->params));
		}
		
		if ($criteria->elementType)
		{
			$query->andWhere(DbHelper::parseParam('gone.elementType', $criteria->elementType, $query->params));
		}
		
		if ($criteria->dateCreated)
		{
			$query->andWhere(DbHelper::parseDateParam('gone.dateCreated', $criteria->dateCreated, $query->params));
		}

	}

	public function populateElementModel($row)
	{
		return GoneModel::populateModel($row);
	}
	
}
