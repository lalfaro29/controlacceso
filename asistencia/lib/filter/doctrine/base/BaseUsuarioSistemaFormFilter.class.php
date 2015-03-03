<?php

/**
 * UsuarioSistema filter form base class.
 *
 * @package    asistencia
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUsuarioSistemaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idtipousuario'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TipoUsuario'), 'add_empty' => true)),
      'idusuario'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => true)),
      'psw'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'idtipousuario'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TipoUsuario'), 'column' => 'idtipousuario')),
      'idusuario'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Usuario'), 'column' => 'idusuario')),
      'psw'              => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_sistema_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioSistema';
  }

  public function getFields()
  {
    return array(
      'idusuariosistema' => 'Number',
      'idtipousuario'    => 'ForeignKey',
      'idusuario'        => 'ForeignKey',
      'psw'              => 'Text',
    );
  }
}
