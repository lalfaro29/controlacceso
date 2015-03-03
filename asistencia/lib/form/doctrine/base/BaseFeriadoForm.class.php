<?php

/**
 * Feriado form base class.
 *
 * @method Feriado getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFeriadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idferiado'          => new sfWidgetFormInputHidden(),
      'feriado'            => new sfWidgetFormInputText(),
      'feriadofechdesde'   => new sfWidgetFormDate(),
      'feriadofechhasta'   => new sfWidgetFormDate(),
      'feriadohoradesde'   => new sfWidgetFormTime(),
      'feriadohorahasta'   => new sfWidgetFormTime(),
      'porcentajeferiado'  => new sfWidgetFormInputText(),
      'porcentajenocturno' => new sfWidgetFormInputText(),
      'un_dia'             => new sfWidgetFormInputCheckbox(),
      'tomar_anio'         => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'idferiado'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idferiado')), 'empty_value' => $this->getObject()->get('idferiado'), 'required' => false)),
      'feriado'            => new sfValidatorString(array('max_length' => 200)),
      'feriadofechdesde'   => new sfValidatorDate(),
      'feriadofechhasta'   => new sfValidatorDate(array('required' => false)),
      'feriadohoradesde'   => new sfValidatorTime(),
      'feriadohorahasta'   => new sfValidatorTime(),
      'porcentajeferiado'  => new sfValidatorNumber(),
      'porcentajenocturno' => new sfValidatorNumber(),
      'un_dia'             => new sfValidatorBoolean(array('required' => false)),
      'tomar_anio'         => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('feriado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Feriado';
  }

}
