<?php

/**
 * Movimiento form base class.
 *
 * @method Movimiento getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMovimientoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmovimiento'    => new sfWidgetFormInputHidden(),
      'idusuario'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => false)),
      'fecha'           => new sfWidgetFormDateTime(),
      'movimiento'      => new sfWidgetFormInputText(),
      'estado'          => new sfWidgetFormInputText(),
      'registro'        => new sfWidgetFormInputText(),
      'ipsede'          => new sfWidgetFormInputText(),
      'ipusuario'       => new sfWidgetFormInputText(),
      'idconfiguracion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Configuracion'), 'add_empty' => true)),
      'idmotivo'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Motivo'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idmovimiento'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idmovimiento')), 'empty_value' => $this->getObject()->get('idmovimiento'), 'required' => false)),
      'idusuario'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'))),
      'fecha'           => new sfValidatorDateTime(),
      'movimiento'      => new sfValidatorString(array('max_length' => 1)),
      'estado'          => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'registro'        => new sfValidatorString(array('max_length' => 15)),
      'ipsede'          => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'ipusuario'       => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'idconfiguracion' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Configuracion'), 'required' => false)),
      'idmotivo'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Motivo'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('movimiento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Movimiento';
  }

}
