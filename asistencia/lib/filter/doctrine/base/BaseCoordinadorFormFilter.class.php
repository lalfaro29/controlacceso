<?php

/**
 * Coordinador filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCoordinadorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => true)),
      'departamento_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departamento'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'usuario_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Usuario'), 'column' => 'idusuario')),
      'departamento_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Departamento'), 'column' => 'iddepartamento')),
    ));

    $this->widgetSchema->setNameFormat('coordinador_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Coordinador';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'usuario_id'      => 'ForeignKey',
      'departamento_id' => 'ForeignKey',
    );
  }
}
