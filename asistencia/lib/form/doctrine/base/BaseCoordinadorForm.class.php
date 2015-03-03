<?php

/**
 * Coordinador form base class.
 *
 * @method Coordinador getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCoordinadorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_coordinador'  => new sfWidgetFormInputHidden(),
      'usuario_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => false)),
      'departamento_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departamento'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_coordinador'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_coordinador')), 'empty_value' => $this->getObject()->get('id_coordinador'), 'required' => false)),
      'usuario_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'))),
      'departamento_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Departamento'))),
    ));

    $this->widgetSchema->setNameFormat('coordinador[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Coordinador';
  }

}
