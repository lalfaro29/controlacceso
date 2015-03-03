<?php

/**
 * Motivo form base class.
 *
 * @method Motivo getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMotivoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmotivo'   => new sfWidgetFormInputHidden(),
      'motivo'     => new sfWidgetFormInputText(),
      'activo'     => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idmotivo'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idmotivo')), 'empty_value' => $this->getObject()->get('idmotivo'), 'required' => false)),
      'motivo'     => new sfValidatorString(array('max_length' => 100)),
      'activo'     => new sfValidatorBoolean(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('motivo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Motivo';
  }

}
