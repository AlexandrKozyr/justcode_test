<?php

/**
 * ProductCategory form base class.
 *
 * @method ProductCategory getObject() Returns the current form's model object
 *
 * @package    armenian.loc
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProductCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                => new sfWidgetFormInputHidden(),
      'parent_id'                         => new sfWidgetFormPropelChoice(array('model' => 'ProductCategory', 'add_empty' => true)),
      'title'                             => new sfWidgetFormInputText(),
      'product_has_product_category_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Product')),
    ));

    $this->setValidators(array(
      'id'                                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'parent_id'                         => new sfValidatorPropelChoice(array('model' => 'ProductCategory', 'column' => 'id', 'required' => false)),
      'title'                             => new sfValidatorString(array('max_length' => 255)),
      'product_has_product_category_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Product', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductCategory';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['product_has_product_category_list']))
    {
      $values = array();
      foreach ($this->object->getProductHasProductCategorys() as $obj)
      {
        $values[] = $obj->getProductId();
      }

      $this->setDefault('product_has_product_category_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProductHasProductCategoryList($con);
  }

  public function saveProductHasProductCategoryList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['product_has_product_category_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProductHasProductCategoryPeer::PRODUCT_CATEGORY_ID, $this->object->getPrimaryKey());
    ProductHasProductCategoryPeer::doDelete($c, $con);

    $values = $this->getValue('product_has_product_category_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductHasProductCategory();
        $obj->setProductCategoryId($this->object->getPrimaryKey());
        $obj->setProductId($value);
        $obj->save();
      }
    }
  }

}
