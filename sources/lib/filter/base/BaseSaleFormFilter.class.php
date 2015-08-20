<?php

/**
 * Sale filter form base class.
 *
 * @package    armenian.loc
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSaleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content'               => new sfWidgetFormFilterInput(),
      'product_has_sale_list' => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'                 => new sfValidatorPass(array('required' => false)),
      'content'               => new sfValidatorPass(array('required' => false)),
      'product_has_sale_list' => new sfValidatorPropelChoice(array('model' => 'Product', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sale_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(ProductHasSalePeer::SALE_ID, SalePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductHasSalePeer::PRODUCT_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductHasSalePeer::PRODUCT_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Sale';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'title'                 => 'Text',
      'content'               => 'Text',
      'product_has_sale_list' => 'ManyKey',
    );
  }
}
