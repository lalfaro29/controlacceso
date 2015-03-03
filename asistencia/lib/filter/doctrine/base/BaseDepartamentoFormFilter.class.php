<?php

/**
 * Departamento filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDepartamentoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'departamento'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'departamento'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('departamento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Departamento';
  }

  public function getFields()
  {
    return array(
      'iddepartamento' => 'Number',
      'departamento'   => 'Text',
    );
  }
}
