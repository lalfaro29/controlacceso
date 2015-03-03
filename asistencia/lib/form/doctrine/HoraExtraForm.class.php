<?php

/**
 * HoraExtra form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HoraExtraForm extends BaseHoraExtraForm
{
  public function configure(){
      
    /*  $this->widgetSchema['horadesdedi']= new sfWidgetFormDateJQueryUI();
      $this->widgetSchema['horahastadi']= new sfWidgetFormDateJQueryUI();
      $this->widgetSchema['horadesdeno']= new sfWidgetFormDateJQueryUI();
      $this->widgetSchema['horahastano']= new sfWidgetFormDateJQueryUI();*/
      
      
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
