<?php

/**
 * Usuario form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UsuarioForm extends BaseUsuarioForm
{
  public function configure(){
      unset(
           $this["activo"],$this["estado"],$this["fechaingreso"],$this["idproyecto"],$this['codigo_nomina'] 
           );
      $tipoEmpleado = Doctrine_Core::getTable('TipoEmpleado')->listarTipoEmpleadoSelect();
      $cargo = Doctrine_Core::getTable('Cargo')->listarCargosSelect();
      $departamento = Doctrine_Core::getTable('Departamento')->listarDepartamentosSelect();
      $sede = Doctrine_Core::getTable('Sede')->listarSedeSelect();
      $proyecto = Doctrine_Core::getTable('Proyecto')->listarProyectoSelect();
      $configuracion = Doctrine_Core::getTable('Configuracion')->listarConfiguracionSelect();
      
      
      $this->widgetSchema['nombre']->setAttributes(array('size' => 30));
      $this->widgetSchema['apellido']->setAttributes(array('size' => 30));
      /*$this->widgetSchema['codigo_nomina']->setAttributes(array('size' => 10));*/
      /*$this->widgetSchema['fechaingreso']= new sfWidgetFormDateJQueryUI();
      $this->validatorSchema['fechaingreso'] = new sfValidatorString(array("required"=>false));
*/
      
      $this->widgetSchema['idtipoempleado'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Tipo de Empleado ---"),$tipoEmpleado)));
      $this->validatorSchema['idtipoempleado'] = new sfValidatorChoice(array('choices' => array_keys($tipoEmpleado)));
      
      $this->widgetSchema['idcargo'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Cargo ---"),$cargo)));
      $this->validatorSchema['idcargo'] = new sfValidatorChoice(array('choices' => array_keys($cargo)));
            
      $this->widgetSchema['iddepartamento'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Departamento ---"),$departamento)));
      $this->validatorSchema['iddepartamento'] = new sfValidatorChoice(array('choices' => array_keys($departamento)));
                  
      $this->widgetSchema['idsede'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Sede ---"),$sede)));
      $this->validatorSchema['idsede'] = new sfValidatorChoice(array('choices' => array_keys($sede)));
     /*             
      $this->widgetSchema['idproyecto'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Proyecto ---"),$proyecto)));
      $this->validatorSchema['idproyecto'] = new sfValidatorChoice(array('choices' => array_keys($proyecto),"required"=>false));
       */           
      $this->widgetSchema['idconfiguracion'] = new sfWidgetFormChoice(array('choices' => Asistencia::combinar_arreglos(array("null"=>"--- Configuracion ---"),$configuracion)));
      $this->validatorSchema['idconfiguracion'] = new sfValidatorChoice(array('choices' => array_keys($configuracion)));
  }
}
