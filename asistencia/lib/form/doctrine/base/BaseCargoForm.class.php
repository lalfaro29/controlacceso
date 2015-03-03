<?php

/**
 * Cargo form base class.
 *
 * @method Cargo getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCargoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcargo' => new sfWidgetFormInputHidden(),
      'cargo'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idcargo' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idcargo')), 'empty_value' => $this->getObject()->get('idcargo'), 'required' => false)),
      'cargo'   => new sfValidatorString(array('max_length' => 70)),
    ));

    $this->widgetSchema->setNameFormat('cargo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cargo';
  }

}
