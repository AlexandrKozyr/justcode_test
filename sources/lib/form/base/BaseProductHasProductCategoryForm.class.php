<?php

/**
 * ProductHasProductCategory form base class.
 *
 * @method ProductHasProductCategory getObject() Returns the current form's model object
 *
 * @package    armenian.loc
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProductHasProductCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id'          => new sfWidgetFormInputHidden(),
      'product_category_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'product_id'          => new sfValidatorPropelChoice(array('model' => 'Product', 'column' => 'id', 'required' => false)),
      'product_category_id' => new sfValidatorPropelChoice(array('model' => 'ProductCategory', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_has_product_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductHasProductCategory';
  }


}
