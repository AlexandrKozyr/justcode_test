<?php

/**
 * Sale form base class.
 *
 * @method Sale getObject() Returns the current form's model object
 *
 * @package    armenian.loc
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSaleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'title'                 => new sfWidgetFormInputText(),
      'content'               => new sfWidgetFormInputText(),
      'product_has_sale_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Product')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'title'                 => new sfValidatorString(array('max_length' => 255)),
      'content'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'product_has_sale_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Product', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Sale', 'column' => array('id'))),
        new sfValidatorPropelUnique(array('model' => 'Sale', 'column' => array('title'))),
      ))
    );

    $this->widgetSchema->setNameFormat('sale[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sale';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['product_has_sale_list']))
    {
      $values = array();
      foreach ($this->object->getProductHasSales() as $obj)
      {
        $values[] = $obj->getProductId();
      }

      $this->setDefault('product_has_sale_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProductHasSaleList($con);
  }

  public function saveProductHasSaleList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['product_has_sale_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProductHasSalePeer::SALE_ID, $this->object->getPrimaryKey());
    ProductHasSalePeer::doDelete($c, $con);

    $values = $this->getValue('product_has_sale_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductHasSale();
        $obj->setSaleId($this->object->getPrimaryKey());
        $obj->setProductId($value);
        $obj->save();
      }
    }
  }

}
