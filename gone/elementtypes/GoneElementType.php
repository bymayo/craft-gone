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
		return true;
	}

	public function getSources($context = null)
	{
		$sources = array(
			'*' => array(
				'label'    => Craft::t('All'),
			)
		);

		return $sources;
	}

	public function defineTableAttributes($source = null)
	{
		return array(
			'elementSlug' => Craft::t('Slug'),
			'elementType' => Craft::t('Type'),
			'redirectElementId' => Craft::t('Redirect To'),
			'redirectType' => Craft::t('Redirect Type'),
			'dateCreated' =>  Craft::t('Date Created')
		);
	}

	public function getTableAttributeHtml(BaseElementModel $element, $attribute)
	{

		return parent::getTableAttributeHtml($element, $attribute);

	}

	public function defineCriteriaAttributes()
	{
		return array(
			'elementSlug' => AttributeType::Mixed,
			'elementType' => AttributeType::Mixed,
			'elementTitle' => AttributeType::Mixed,
			'dateCreated' => AttributeType::Mixed
		);
	}

	public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
	{
		
		$query
			->addSelect('gone.elementType, gone.elementTitle, gone.elementSlug, gone.elementUri, gone.redirectType, gone.dateCreated')
			->join('gone gone', 'gone.id = elements.id');

	}

	public function populateElementModel($row)
	{
		return GoneModel::populateModel($row);
	}

	public function getEditorHtml(BaseElementModel $element)
	{
	}
}
