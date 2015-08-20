<?php

/**
 * ProductHasSale filter form base class.
 *
 * @package    armenian.loc
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseProductHasSaleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('product_has_sale_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductHasSale';
  }

  public function getFields()
  {
    return array(
      'product_id' => 'ForeignKey',
      'sale_id'    => 'ForeignKey',
    );
  }
}
