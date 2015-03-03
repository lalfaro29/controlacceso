<?php

/**
 * Usuario filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUsuarioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'apellido'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cedula'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'idtipoempleado'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TipoEmpleado'), 'add_empty' => true)),
      'idcargo'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cargo'), 'add_empty' => true)),
      'iddepartamento'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departamento'), 'add_empty' => true)),
      'idsede'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sede'), 'add_empty' => true)),
      'estado'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fechaingreso'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'sueldo'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'idproyecto'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proyecto'), 'add_empty' => true)),
      'idconfiguracion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Configuracion'), 'add_empty' => true)),
      'ipusuario'       => new sfWidgetFormFilterInput(),
      'activo'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nombre'          => new sfValidatorPass(array('required' => false)),
      'apellido'        => new sfValidatorPass(array('required' => false)),
      'cedula'          => new sfValidatorPass(array('required' => false)),
      'idtipoempleado'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TipoEmpleado'), 'column' => 'idtipoempleado')),
      'idcargo'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cargo'), 'column' => 'idcargo')),
      'iddepartamento'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Departamento'), 'column' => 'iddepartamento')),
      'idsede'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sede'), 'column' => 'idsede')),
      'estado'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fechaingreso'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'sueldo'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'idproyecto'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Proyecto'), 'column' => 'idproyecto')),
      'idconfiguracion' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Configuracion'), 'column' => 'idconfiguracion')),
      'ipusuario'       => new sfValidatorPass(array('required' => false)),
      'activo'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }

  public function getFields()
  {
    return array(
      'idusuario'       => 'Number',
      'nombre'          => 'Text',
      'apellido'        => 'Text',
      'cedula'          => 'Text',
      'idtipoempleado'  => 'ForeignKey',
      'idcargo'         => 'ForeignKey',
      'iddepartamento'  => 'ForeignKey',
      'idsede'          => 'ForeignKey',
      'estado'          => 'Number',
      'fechaingreso'    => 'Date',
      'sueldo'          => 'Number',
      'idproyecto'      => 'ForeignKey',
      'idconfiguracion' => 'ForeignKey',
      'ipusuario'       => 'Text',
      'activo'          => 'Text',
    );
  }
}
