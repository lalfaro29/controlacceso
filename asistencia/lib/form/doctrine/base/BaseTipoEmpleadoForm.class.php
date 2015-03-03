<?php

/**
 * TipoEmpleado form base class.
 *
 * @method TipoEmpleado getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTipoEmpleadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idtipoempleado' => new sfWidgetFormInputHidden(),
      'empleado'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idtipoempleado' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idtipoempleado')), 'empty_value' => $this->getObject()->get('idtipoempleado'), 'required' => false)),
      'empleado'       => new sfValidatorString(array('max_length' => 45)),
    ));

    $this->widgetSchema->setNameFormat('tipo_empleado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoEmpleado';
  }

}
