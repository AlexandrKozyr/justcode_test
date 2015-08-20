<?php

/**
 * Photo form base class.
 *
 * @method Photo getObject() Returns the current form's model object
 *
 * @package    armenian.loc
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePhotoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'title'                  => new sfWidgetFormInputText(),
      'content'                => new sfWidgetFormInputText(),
      'product_has_photo_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Product')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'title'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'content'                => new sfValidatorPass(),
      'product_has_photo_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Product', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('photo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Photo';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['product_has_photo_list']))
    {
      $values = array();
      foreach ($this->object->getProductHasPhotos() as $obj)
      {
        $values[] = $obj->getProductId();
      }

      $this->setDefault('product_has_photo_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProductHasPhotoList($con);
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
    $c->add(ProductHasPhotoPeer::PHOTO_ID, $this->object->getPrimaryKey());
    ProductHasPhotoPeer::doDelete($c, $con);

    $values = $this->getValue('product_has_photo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProductHasPhoto();
        $obj->setPhotoId($this->object->getPrimaryKey());
        $obj->setProductId($value);
        $obj->save();
      }
    }
  }

}
