<?php

/**
 * Sede form base class.
 *
 * @method Sede getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSedeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idsede' => new sfWidgetFormInputHidden(),
      'sede'   => new sfWidgetFormInputText(),
      'activa' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idsede' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idsede')), 'empty_value' => $this->getObject()->get('idsede'), 'required' => false)),
      'sede'   => new sfValidatorString(array('max_length' => 50)),
      'activa' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sede[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sede';
  }

}
