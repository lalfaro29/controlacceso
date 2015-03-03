<?php

/**
 * TipoUsuario form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TipoUsuarioForm extends BaseTipoUsuarioForm
{
  public function configure(){
      $tipoUsuario = Doctrine_Core::getTable('TipoUsuario')->listarTipoUsuarioSelect();
      $this->widgetSchema['idtipousuario'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Tipo de Usuario ---"),$tipoUsuario)));
      $this->validatorSchema['idtipousuario'] = new sfValidatorChoice(array('choices' => array_keys($tipoUsuario)));
  }
}
