<?php

/**
 * UsuarioSistema form base class.
 *
 * @method UsuarioSistema getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsuarioSistemaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idusuariosistema' => new sfWidgetFormInputHidden(),
      'idtipousuario'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TipoUsuario'), 'add_empty' => false)),
      'idusuario'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => false)),
      'psw'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idusuariosistema' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idusuariosistema')), 'empty_value' => $this->getObject()->get('idusuariosistema'), 'required' => false)),
      'idtipousuario'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TipoUsuario'), 'required' => false)),
      'idusuario'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'))),
      'psw'              => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('usuario_sistema[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioSistema';
  }

}
