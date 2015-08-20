<?php

/**
 * ProductHasPhoto form base class.
 *
 * @method ProductHasPhoto getObject() Returns the current form's model object
 *
 * @package    armenian.loc
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProductHasPhotoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id' => new sfWidgetFormInputHidden(),
      'photo_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'product_id' => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id', 'required' => false)),
      'photo_id'   => new sfValidatorPropelChoice(array('model' => 'Photo', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_has_photo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductHasPhoto';
  }


}
