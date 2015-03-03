<?php

/**
 * RelacionConfigFeriado form base class.
 *
 * @method RelacionConfigFeriado getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRelacionConfigFeriadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idconfiguracion' => new sfWidgetFormInputHidden(),
      'idferiado'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idconfiguracion' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idconfiguracion')), 'empty_value' => $this->getObject()->get('idconfiguracion'), 'required' => false)),
      'idferiado'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idferiado')), 'empty_value' => $this->getObject()->get('idferiado'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'RelacionConfigFeriado', 'column' => array('idconfiguracion'))),
        new sfValidatorDoctrineUnique(array('model' => 'RelacionConfigFeriado', 'column' => array('idferiado'))),
      ))
    );

    $this->widgetSchema->setNameFormat('relacion_config_feriado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RelacionConfigFeriado';
  }

}
