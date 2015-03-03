<?php

/**
 * Permiso filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePermisoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => true)),
      'fecha'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fechadesde'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fechahasta'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'horas'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipopermiso' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'idmotivo'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Motivo'), 'add_empty' => true)),
      'archivo'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'usuario_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Usuario'), 'column' => 'idusuario')),
      'fecha'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fechadesde'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fechahasta'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'horas'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipopermiso' => new sfValidatorPass(array('required' => false)),
      'idmotivo'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Motivo'), 'column' => 'idmotivo')),
      'archivo'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('permiso_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Permiso';
  }

  public function getFields()
  {
    return array(
      'idpermiso'   => 'Number',
      'usuario_id'  => 'ForeignKey',
      'fecha'       => 'Date',
      'fechadesde'  => 'Date',
      'fechahasta'  => 'Date',
      'horas'       => 'Number',
      'tipopermiso' => 'Text',
      'idmotivo'    => 'ForeignKey',
      'archivo'     => 'Text',
    );
  }
}
