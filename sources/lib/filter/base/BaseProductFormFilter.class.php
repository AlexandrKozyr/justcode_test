<?php

/**
 * Product filter form base class.
 *
 * @package    armenian.loc
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseProductFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'                       => new sfWidgetFormFilterInput(),
      'product_has_photo_list'            => new sfWidgetFormPropelChoice(array('model' => 'Photo', 'add_empty' => true)),
      'product_has_product_category_list' => new sfWidgetFormPropelChoice(array('model' => 'ProductCategory', 'add_empty' => true)),
      'product_has_sale_list'             => new sfWidgetFormPropelChoice(array('model' => 'Sale', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'                             => new sfValidatorPass(array('required' => false)),
      'description'                       => new sfValidatorPass(array('required' => false)),
      'product_has_photo_list'            => new sfValidatorPropelChoice(array('model' => 'Photo', 'required' => false)),
      'product_has_product_category_list' => new sfValidatorPropelChoice(array('model' => 'ProductCategory', 'required' => false)),
      'product_has_sale_list'             => new sfValidatorPropelChoice(array('model' => 'Sale', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addProductHasPhotoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ProductHasPhotoPeer::PRODUCT_ID, ProductPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductHasPhotoPeer::PHOTO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductHasPhotoPeer::PHOTO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addProductHasProductCategoryListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ProductHasProductCategoryPeer::PRODUCT_ID, ProductPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductHasProductCategoryPeer::PRODUCT_CATEGORY_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductHasProductCategoryPeer::PRODUCT_CATEGORY_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addProductHasSaleListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ProductHasSalePeer::PRODUCT_ID, ProductPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductHasSalePeer::SALE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductHasSalePeer::SALE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Product';
  }

  public function getFields()
  {
    return array(
      'id'                                => 'Number',
      'title'                             => 'Text',
      'description'                       => 'Text',
      'product_has_photo_list'            => 'ManyKey',
      'product_has_product_category_list' => 'ManyKey',
      'product_has_sale_list'             => 'ManyKey',
    );
  }
}
