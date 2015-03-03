<?php

/**
 * TipoUsuario form base class.
 *
 * @method TipoUsuario getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTipoUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idtipousuario' => new sfWidgetFormInputHidden(),
      'tipousuario'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idtipousuario' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idtipousuario')), 'empty_value' => $this->getObject()->get('idtipousuario'), 'required' => false)),
      'tipousuario'   => new sfValidatorString(array('max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('tipo_usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TipoUsuario';
  }

}
