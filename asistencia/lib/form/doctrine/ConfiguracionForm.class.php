<?php

/**
 * Configuracion form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Juan Casseus
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ConfiguracionForm extends BaseConfiguracionForm
{
  public function configure(){
      unset(
              $this["fecha"],
              $this["idusuario"]
      );
      $sede = Doctrine_Core::getTable('Sede')->listarSedeSelect();
      //$this->widgetSchema['fecha']= new sfWidgetFormDateJQueryUI();
      //$this->widgetSchema['horaentrada']= new sfWidgetFormDateJQueryUI();
      //$this->widgetSchema['horasalida']= new sfWidgetFormDateJQueryUI();
      
      $this->widgetSchema['horaentrada'] = new sfWidgetFormInput();
      $this->widgetSchema['horaentrada']->setAttributes(array('size' => 7));
      $this->widgetSchema['horasalida'] = new sfWidgetFormInput();
      $this->widgetSchema['horasalida']->setAttributes(array('size' => 7));
      
      //
      $this->widgetSchema['horamaxentrada'] = new sfWidgetFormChoice(array('choices' => Asistencia::minutos_select()),array("style"=>"width:auto"));
      $this->validatorSchema['horamaxentrada'] = new sfValidatorChoice(array('choices' => array_keys(Asistencia::minutos_select())));
      
      $this->widgetSchema['cestatique_x_jornada'] = new sfWidgetFormChoice(array('choices' => Asistencia::cuenta_select(1,10)),array("style"=>"width:auto"));
      $this->validatorSchema['cestatique_x_jornada'] = new sfValidatorChoice(array('choices' => array_keys(Asistencia::cuenta_select(1,10))));
      
      $this->widgetSchema['idsede'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Sede ---"),$sede)));
      $this->validatorSchema['idsede'] = new sfValidatorChoice(array('choices' => array_keys($sede)));
      
      
      $this->widgetSchema['horadesdedi'] = new sfWidgetFormInput();
      $this->widgetSchema['horadesdedi']->setAttributes(array('size' => 7));
      $this->widgetSchema['horahastadi'] = new sfWidgetFormInput();
      $this->widgetSchema['horahastadi']->setAttributes(array('size' => 7));
      $this->widgetSchema['horadesdeno'] = new sfWidgetFormInput();
      $this->widgetSchema['horadesdeno']->setAttributes(array('size' => 7));
      $this->widgetSchema['horahastano'] = new sfWidgetFormInput();
      $this->widgetSchema['horahastano']->setAttributes(array('size' => 7));
      
      $this->widgetSchema['porcentajedi']->setAttributes(array('size' => 10));
      $this->widgetSchema['porcentajeno']->setAttributes(array('size' => 10));
  }
}
