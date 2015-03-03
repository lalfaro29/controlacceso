<?php

/**
 * Usuario form base class.
 *
 * @method Usuario getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idusuario'       => new sfWidgetFormInputHidden(),
      'nombre'          => new sfWidgetFormInputText(),
      'apellido'        => new sfWidgetFormInputText(),
      'cedula'          => new sfWidgetFormInputText(),
      'idtipoempleado'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TipoEmpleado'), 'add_empty' => false)),
      'idcargo'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cargo'), 'add_empty' => false)),
      'iddepartamento'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departamento'), 'add_empty' => false)),
      'idsede'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sede'), 'add_empty' => false)),
      'estado'          => new sfWidgetFormInputText(),
      'fechaingreso'    => new sfWidgetFormDateTime(),
      'sueldo'          => new sfWidgetFormInputText(),
      'idproyecto'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'), 'add_empty' => false)),
      'idconfiguracion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Configuracion'), 'add_empty' => false)),
      'ipusuario'       => new sfWidgetFormInputText(),
      'activo'          => new sfWidgetFormInputText(),
      'codigo_nomina'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idusuario'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idusuario')), 'empty_value' => $this->getObject()->get('idusuario'), 'required' => false)),
      'nombre'          => new sfValidatorString(array('max_length' => 50)),
      'apellido'        => new sfValidatorString(array('max_length' => 50)),
      'cedula'          => new sfValidatorString(array('max_length' => 15)),
      'idtipoempleado'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TipoEmpleado'))),
      'idcargo'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cargo'))),
      'iddepartamento'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Departamento'))),
      'idsede'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sede'))),
      'estado'          => new sfValidatorInteger(array('required' => false)),
      'fechaingreso'    => new sfValidatorDateTime(),
      'sueldo'          => new sfValidatorNumber(array('required' => false)),
      'idproyecto'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'))),
      'idconfiguracion' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Configuracion'))),
      'ipusuario'       => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'activo'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'codigo_nomina'   => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }

}
