<?php

/**
 * Feriado form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FeriadoForm extends BaseFeriadoForm
{
  public function configure(){
      $this->widgetSchema->setNameFormat('feriados[%s]');
      $this->widgetSchema['feriado']->setAttributes(array('size' => 40));
      $this->widgetSchema['feriadofechdesde'] = new sfWidgetFormInput();
      $this->widgetSchema['feriadofechdesde']->setAttributes(array('size' => 8));
      $this->widgetSchema['feriadofechhasta'] = new sfWidgetFormInput();
      $this->widgetSchema['feriadofechhasta']->setAttributes(array('size' => 8,"readOnly"=>"readOnly"));
      $this->widgetSchema['feriadohoradesde'] = new sfWidgetFormInput();
      $this->widgetSchema['feriadohoradesde']->setAttributes(array('size' => 8));
      $this->widgetSchema['feriadohorahasta'] = new sfWidgetFormInput();
      $this->widgetSchema['feriadohorahasta']->setAttributes(array('size' => 8));
      
      $this->widgetSchema['porcentajeferiado'] = new sfWidgetFormInput();
      $this->widgetSchema['porcentajeferiado']->setAttributes(array('size' => 8));
      
      $this->widgetSchema['porcentajenocturno'] = new sfWidgetFormInput();
      $this->widgetSchema['porcentajenocturno']->setAttributes(array('size' => 8));
      
      $this->widgetSchema['un_dia'] = new sfWidgetFormChoice(array('choices' => Feriado::getTiempoFeriado()));
      //$this->validatorSchema['tipoferiado'] = new sfValidatorChoice(array('choices' => array_keys(array(1=>1,0=>0))));
     
  }
}
