<?php

/**
 * Departamento form base class.
 *
 * @method Departamento getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDepartamentoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'iddepartamento' => new sfWidgetFormInputHidden(),
      'departamento'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'iddepartamento' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('iddepartamento')), 'empty_value' => $this->getObject()->get('iddepartamento'), 'required' => false)),
      'departamento'   => new sfValidatorString(array('max_length' => 60)),
    ));

    $this->widgetSchema->setNameFormat('departamento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Departamento';
  }

}
