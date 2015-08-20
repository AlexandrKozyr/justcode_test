<?php

/**
 * ProductHasProductCategory filter form base class.
 *
 * @package    armenian.loc
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseProductHasProductCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('product_has_product_category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductHasProductCategory';
  }

  public function getFields()
  {
    return array(
      'product_id'          => 'ForeignKey',
      'product_category_id' => 'ForeignKey',
    );
  }
}
