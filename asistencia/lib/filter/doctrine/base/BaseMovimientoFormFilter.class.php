<?php

/**
 * Movimiento filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMovimientoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idusuario'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => true)),
      'fecha'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'movimiento'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'estado'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'registro'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ipsede'          => new sfWidgetFormFilterInput(),
      'ipusuario'       => new sfWidgetFormFilterInput(),
      'idconfiguracion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Configuracion'), 'add_empty' => true)),
      'idmotivo'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Motivo'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idusuario'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Usuario'), 'column' => 'idusuario')),
      'fecha'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'movimiento'      => new sfValidatorPass(array('required' => false)),
      'estado'          => new sfValidatorPass(array('required' => false)),
      'registro'        => new sfValidatorPass(array('required' => false)),
      'ipsede'          => new sfValidatorPass(array('required' => false)),
      'ipusuario'       => new sfValidatorPass(array('required' => false)),
      'idconfiguracion' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Configuracion'), 'column' => 'idconfiguracion')),
      'idmotivo'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Motivo'), 'column' => 'idmotivo')),
    ));

    $this->widgetSchema->setNameFormat('movimiento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Movimiento';
  }

  public function getFields()
  {
    return array(
      'idmovimiento'    => 'Number',
      'idusuario'       => 'ForeignKey',
      'fecha'           => 'Date',
      'movimiento'      => 'Text',
      'estado'          => 'Text',
      'registro'        => 'Text',
      'ipsede'          => 'Text',
      'ipusuario'       => 'Text',
      'idconfiguracion' => 'ForeignKey',
      'idmotivo'        => 'ForeignKey',
    );
  }
}
