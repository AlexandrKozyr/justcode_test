<?php

/**
 * ProductHasSale form base class.
 *
 * @method ProductHasSale getObject() Returns the current form's model object
 *
 * @package    armenian.loc
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProductHasSaleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id' => new sfWidgetFormInputHidden(),
      'sale_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'product_id' => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id', 'required' => false)),
      'sale_id'    => new sfValidatorPropelChoice(array('model' => 'Sale', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_has_sale[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductHasSale';
  }


}
