<?php

/**
 * Permiso form base class.
 *
 * @method Permiso getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePermisoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idpermiso'    => new sfWidgetFormInputHidden(),
      'usuario_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => true)),
      'fecha'        => new sfWidgetFormDateTime(),
      'fechadesde'   => new sfWidgetFormDateTime(),
      'fechahasta'   => new sfWidgetFormDateTime(),
      'horas'        => new sfWidgetFormInputText(),
      'tipopermiso'  => new sfWidgetFormInputText(),
      'idmotivo'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Motivo'), 'add_empty' => false)),
      'archivo'      => new sfWidgetFormInputText(),
      'id_usuario_r' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idpermiso'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idpermiso')), 'empty_value' => $this->getObject()->get('idpermiso'), 'required' => false)),
      'usuario_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'required' => false)),
      'fecha'        => new sfValidatorDateTime(),
      'fechadesde'   => new sfValidatorDateTime(),
      'fechahasta'   => new sfValidatorDateTime(),
      'horas'        => new sfValidatorInteger(array('required' => false)),
      'tipopermiso'  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'idmotivo'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Motivo'))),
      'archivo'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'id_usuario_r' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('permiso[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Permiso';
  }

}
