<?php

/**
 * ProductCategory filter form base class.
 *
 * @package    armenian.loc
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseProductCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id'                         => new sfWidgetFormPropelChoice(array('model' => 'ProductCategory', 'add_empty' => true)),
      'title'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'product_has_product_category_list' => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'parent_id'                         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ProductCategory', 'column' => 'id')),
      'title'                             => new sfValidatorPass(array('required' => false)),
      'product_has_product_category_list' => new sfValidatorPropelChoice(array('model' => 'Product', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(ProductHasProductCategoryPeer::PRODUCT_CATEGORY_ID, ProductCategoryPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductHasProductCategoryPeer::PRODUCT_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductHasProductCategoryPeer::PRODUCT_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'ProductCategory';
  }

  public function getFields()
  {
    return array(
      'id'                                => 'Number',
      'parent_id'                         => 'ForeignKey',
      'title'                             => 'Text',
      'product_has_product_category_list' => 'ManyKey',
    );
  }
}
