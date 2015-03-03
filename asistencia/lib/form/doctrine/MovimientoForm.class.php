<?php

/**
 * Movimiento form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MovimientoForm extends BaseMovimientoForm
{
  public function configure()
  {
      
      $this->widgetSchema['departamentos'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- TODOS ---"),  DepartamentoTable::listaDepartamentosSelect())));
      $this->widgetSchema['empleados'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- TODOS ---"),UsuarioTable::listaUsuariosSelect1())));
      $this->widgetSchema['fecha_desde']= new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true));
      $this->widgetSchema['fecha_hasta']= new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true));
      $this->widgetSchema['fecha_desde']->setAttributes(array('size' => 8));
      $this->widgetSchema['fecha_hasta']->setAttributes(array('size' => 8));


 
  }
}
