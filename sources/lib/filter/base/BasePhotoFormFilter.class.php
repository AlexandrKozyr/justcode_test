<?php

/**
 * Photo filter form base class.
 *
 * @package    armenian.loc
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePhotoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'                  => new sfWidgetFormFilterInput(),
      'content'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'product_has_photo_list' => new sfWidgetFormPropelChoice(array('model' => 'Product', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'                  => new sfValidatorPass(array('required' => false)),
      'content'                => new sfValidatorPass(array('required' => false)),
      'product_has_photo_list' => new sfValidatorPropelChoice(array('model' => 'Product', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('photo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addProductHasPhotoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ProductHasPhotoPeer::PHOTO_ID, PhotoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ProductHasPhotoPeer::PRODUCT_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ProductHasPhotoPeer::PRODUCT_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Photo';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'title'                  => 'Text',
      'content'                => 'Text',
      'product_has_photo_list' => 'ManyKey',
    );
  }
}
