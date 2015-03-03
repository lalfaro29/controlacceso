<?php

/**
 * Feriado filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFeriadoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'feriado'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'feriadofechdesde'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'feriadofechhasta'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'feriadohoradesde'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'feriadohorahasta'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'porcentajeferiado'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'porcentajenocturno' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'un_dia'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tomar_anio'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'feriado'            => new sfValidatorPass(array('required' => false)),
      'feriadofechdesde'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'feriadofechhasta'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'feriadohoradesde'   => new sfValidatorPass(array('required' => false)),
      'feriadohorahasta'   => new sfValidatorPass(array('required' => false)),
      'porcentajeferiado'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'porcentajenocturno' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'un_dia'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tomar_anio'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('feriado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Feriado';
  }

  public function getFields()
  {
    return array(
      'idferiado'          => 'Number',
      'feriado'            => 'Text',
      'feriadofechdesde'   => 'Date',
      'feriadofechhasta'   => 'Date',
      'feriadohoradesde'   => 'Text',
      'feriadohorahasta'   => 'Text',
      'porcentajeferiado'  => 'Number',
      'porcentajenocturno' => 'Number',
      'un_dia'             => 'Boolean',
      'tomar_anio'         => 'Boolean',
    );
  }
}
