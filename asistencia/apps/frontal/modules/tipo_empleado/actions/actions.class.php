<?php

/**
 * tipo_empleado actions.
 *
 * @package    asistencia
 * @subpackage tipo_empleado
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tipo_empleadoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->tipo_empleados = Doctrine_Core::getTable('TipoEmpleado')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->tipo_empleado = Doctrine_Core::getTable('TipoEmpleado')->find(array($request->getParameter('idtipoempleado')));
    $this->forward404Unless($this->tipo_empleado);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TipoEmpleadoForm();
    $this->tipo_empleados = Doctrine_Core::getTable('TipoEmpleado')
      ->createQuery('a')
      ->execute();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TipoEmpleadoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tipo_empleado = Doctrine_Core::getTable('TipoEmpleado')->find(array($request->getParameter('idtipoempleado'))), sprintf('Object tipo_empleado does not exist (%s).', $request->getParameter('idtipoempleado')));
    $this->form = new TipoEmpleadoForm($tipo_empleado);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($tipo_empleado = Doctrine_Core::getTable('TipoEmpleado')->find(array($request->getParameter('idtipoempleado'))), sprintf('Object tipo_empleado does not exist (%s).', $request->getParameter('idtipoempleado')));
    $this->form = new TipoEmpleadoForm($tipo_empleado);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tipo_empleado = Doctrine_Core::getTable('TipoEmpleado')->find(array($request->getParameter('idtipoempleado'))), sprintf('Object tipo_empleado does not exist (%s).', $request->getParameter('idtipoempleado')));
    $tipo_empleado->delete();

    $this->redirect('tipo_empleado/index');
  }

    public function executeCrear(sfWebRequest $request){
        $datos = $request->getParameter("tipo_empleado");
        if(is_numeric($datos["idtipoempleado"])){
            foreach($datos as $name => $value):
                $request->setParameter($name, $value);
            endforeach;
            $tipoempleado = Doctrine_Core::getTable('TipoEmpleado')->findOneByIdtipoempleado(array($request->getParameter('idtipoempleado')));
            $this->form = new  TipoEmpleadoForm($tipoempleado);
        }else{
            $this->form = new TipoEmpleadoForm();
        }
            return $this->renderText(json_encode($this->processForm($request, $this->form)));
    }  
    
    public function executeLista(sfWebRequest $request){
            $resultado = Doctrine_Core::getTable('TipoEmpleado')->buscarTipoEmpleadoJson($request->getParameter("sSearch"));
            return $this->renderText(json_encode(array(
                    "sEcho"=> intval($request->getParameter('sEcho')),
                    "iTotalRecords" =>count($resultado), //total de resultados
                    "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                    "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
            )));
    }
    public function executeEliminar(sfWebRequest $request){
        $empleado = Doctrine_Core::getTable('TipoEmpleado')->findOneByIdtipoempleado(array($request->getParameter('empleado')));
        if($empleado->count() && $request->getParameter('empleado')){
            $empleado->delete(); 
            return $this->renderText(json_encode("Tipo de empleado eliminado"));
        }else{
            return $this->renderText(json_encode("Error intentando eliminar tiepo de empleado"));
        }
    }
    protected function processForm(sfWebRequest $request, sfForm $form){
            $respuesta = "Error intentando guardar el tipo de empleado";
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
            if ($form->isValid()){
                    $form->save();
                    $respuesta = "Tipo empleado Guardado";
            }
            return $respuesta;
    }  
}
