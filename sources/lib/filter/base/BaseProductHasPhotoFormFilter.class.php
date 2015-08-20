<?php

/**
 * ProductHasPhoto filter form base class.
 *
 * @package    armenian.loc
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseProductHasPhotoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('product_has_photo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductHasPhoto';
  }

  public function getFields()
  {
    return array(
      'product_id' => 'ForeignKey',
      'photo_id'   => 'ForeignKey',
    );
  }
}
