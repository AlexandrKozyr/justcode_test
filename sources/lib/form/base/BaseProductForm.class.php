<?php

/**
 * Product form base class.
 *
 * @method Product getObject() Returns the current form's model object
 *
 * @package    armenian.loc
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProductForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                => new sfWidgetFormInputHidden(),
      'title'                             => new sfWidgetFormInputText(),
      'description'                       => new sfWidgetFormTextarea(),
      'product_has_photo_list'            => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Photo')),
      'product_has_product_category_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'ProductCategory')),
      'product_has_sale_list'             => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Sale')),
    ));

    $this->setValidators(array(
      'id'                                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'title'                             => new sfValidatorString(array('max_length' => 255)),
      'description'                       => new sfValidatorString(array('required' => false)),
      'product_has_photo_list'            => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Photo', 'required' => false)),
      'product_has_product_category_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'ProductCategory', 'required' => false)),
      'product_has_sale_list'             => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Sale', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Product';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['product_has_photo_list']))
    {
      $values = array();
      foreach ($this->object->getProductHasPhotos() as $obj)
      {
        $values[] = $obj->getPhotoId();
      }

      $this->setDefault('product_has_photo_list', $values);
    }

    if (isset($this->widgetSchema['product_has_product_category_list']))
    {
      $values = array();
      foreach ($this->object->getProductHasProductCategorys() as $obj)
      {
        $values[] = $obj->getProductCategoryId();
      }

      $this->setDefault('product_has_product_category_list', $values);
    }

    if (isset($this->widgetSchema['product_has_sale_list']))
    {
      $values = array();
      foreach ($this->object->getProductHasSales() as $obj)
      {
        $values[] = $obj->getSaleId();
      }

      $this->setDefault('product_has_sale_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProductHasPhotoList($con);
    $this->saveProductHasProductCategoryList($con);
    $this->saveProductHasSaleList($con);
  }

  public function saveProductHasPhotoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['product_has_photo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProductHasPhotoPeer::PRODUCT_ID, $this->object->getPrimaryKey());
    ProductHasPhotoPeer::doDelete($c, $con);

    $values = $this->getValue('product_has_photo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductHasPhoto();
        $obj->setProductId($this->object->getPrimaryKey());
        $obj->setPhotoId($value);
        $obj->save();
      }
    }
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
    $c->add(ProductHasProductCategoryPeer::PRODUCT_ID, $this->object->getPrimaryKey());
    ProductHasProductCategoryPeer::doDelete($c, $con);

    $values = $this->getValue('product_has_product_category_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductHasProductCategory();
        $obj->setProductId($this->object->getPrimaryKey());
        $obj->setProductCategoryId($value);
        $obj->save();
      }
    }
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
    $c->add(ProductHasSalePeer::PRODUCT_ID, $this->object->getPrimaryKey());
    ProductHasSalePeer::doDelete($c, $con);

    $values = $this->getValue('product_has_sale_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductHasSale();
        $obj->setProductId($this->object->getPrimaryKey());
        $obj->setSaleId($value);
        $obj->save();
      }
    }
  }

}
