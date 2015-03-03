<?php

/**
 * Proyecto form base class.
 *
 * @method Proyecto getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProyectoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idproyecto' => new sfWidgetFormInputHidden(),
      'proyecto'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idproyecto' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idproyecto')), 'empty_value' => $this->getObject()->get('idproyecto'), 'required' => false)),
      'proyecto'   => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('proyecto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proyecto';
  }

}
