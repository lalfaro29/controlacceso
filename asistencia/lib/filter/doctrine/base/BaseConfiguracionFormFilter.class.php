<?php

/**
 * Configuracion filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseConfiguracionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idusuario'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => true)),
      'fecha'                        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'horaentrada'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'horasalida'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'horamaxentrada'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'central'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cestatique_x_jornada'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'precioticks'                  => new sfWidgetFormFilterInput(),
      'idsede'                       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sede'), 'add_empty' => true)),
      'horadesdedi'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'horahastadi'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'horadesdeno'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'horahastano'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'porcentajedi'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'porcentajeno'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'relacion_config_feriado_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Feriado')),
    ));

    $this->setValidators(array(
      'idusuario'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Usuario'), 'column' => 'idusuario')),
      'fecha'                        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'horaentrada'                  => new sfValidatorPass(array('required' => false)),
      'horasalida'                   => new sfValidatorPass(array('required' => false)),
      'horamaxentrada'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'central'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cestatique_x_jornada'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'precioticks'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'idsede'                       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sede'), 'column' => 'idsede')),
      'horadesdedi'                  => new sfValidatorPass(array('required' => false)),
      'horahastadi'                  => new sfValidatorPass(array('required' => false)),
      'horadesdeno'                  => new sfValidatorPass(array('required' => false)),
      'horahastano'                  => new sfValidatorPass(array('required' => false)),
      'porcentajedi'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'porcentajeno'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'relacion_config_feriado_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Feriado', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('configuracion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addRelacionConfigFeriadoListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.RelacionConfigFeriado RelacionConfigFeriado')
      ->andWhereIn('RelacionConfigFeriado.idferiado', $values)
    ;
  }

  public function getModelName()
  {
    return 'Configuracion';
  }

  public function getFields()
  {
    return array(
      'idconfiguracion'              => 'Number',
      'idusuario'                    => 'ForeignKey',
      'fecha'                        => 'Date',
      'horaentrada'                  => 'Text',
      'horasalida'                   => 'Text',
      'horamaxentrada'               => 'Number',
      'central'                      => 'Number',
      'cestatique_x_jornada'         => 'Number',
      'precioticks'                  => 'Number',
      'idsede'                       => 'ForeignKey',
      'horadesdedi'                  => 'Text',
      'horahastadi'                  => 'Text',
      'horadesdeno'                  => 'Text',
      'horahastano'                  => 'Text',
      'porcentajedi'                 => 'Number',
      'porcentajeno'                 => 'Number',
      'relacion_config_feriado_list' => 'ManyKey',
    );
  }
}
