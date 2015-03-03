<?php

/**
 * departamento actions.
 *
 * @package    asistencia
 * @subpackage departamento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departamentoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->departamentos = Doctrine_Core::getTable('Departamento')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->departamento = Doctrine_Core::getTable('Departamento')->find(array($request->getParameter('iddepartamento')));
    $this->forward404Unless($this->departamento);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DepartamentoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DepartamentoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($departamento = Doctrine_Core::getTable('Departamento')->find(array($request->getParameter('iddepartamento'))), sprintf('Object departamento does not exist (%s).', $request->getParameter('iddepartamento')));
    $this->form = new DepartamentoForm($departamento);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($departamento = Doctrine_Core::getTable('Departamento')->find(array($request->getParameter('iddepartamento'))), sprintf('Object departamento does not exist (%s).', $request->getParameter('iddepartamento')));
    $this->form = new DepartamentoForm($departamento);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($departamento = Doctrine_Core::getTable('Departamento')->find(array($request->getParameter('iddepartamento'))), sprintf('Object departamento does not exist (%s).', $request->getParameter('iddepartamento')));
    $departamento->delete();

    $this->redirect('departamento/index');
  }
  
  
    public function executeCrear(sfWebRequest $request){
        $datos = $request->getParameter("departamentos");
        if(is_numeric($datos["iddepartamento"])){
            foreach($datos as $name => $value):
                $request->setParameter($name, $value);
            endforeach;
            $departamento = Doctrine_Core::getTable('Departamento')->findOneByIddepartamento(array($request->getParameter('iddepartamento')));
            $this->form = new DepartamentoForm($departamento);
        }else{
            $this->form = new DepartamentoForm();
        }
            return $this->renderText(json_encode($this->processForm($request, $this->form)));
    }  
  
    public function executeLista(sfWebRequest $request){
            $resultado = Doctrine_Core::getTable('Departamento')->buscarDepartamentoJson($request->getParameter("sSearch"));
            return $this->renderText(json_encode(array(
                    "sEcho"=> intval($request->getParameter('sEcho')),
                    "iTotalRecords" =>count($resultado), //total de resultados
                    "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                    "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
            )));
    }  
    public function executeEliminar(sfWebRequest $request){
        $empleado = Doctrine_Core::getTable('Departamento')->findOneByIddepartamento(array($request->getParameter('departamento')));
        if($empleado->count() && $request->getParameter('departamento')){
            $empleado->delete(); 
            return $this->renderText(json_encode("departamento eliminado"));
        }else{
            return $this->renderText(json_encode("Error intentando eliminar el departamento"));
        }
    }
    protected function processForm(sfWebRequest $request, sfForm $form){
            $respuesta = "Error intentando guardar el departamento";
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
            if ($form->isValid()){
                    $form->save();
                    $respuesta = "Departamento Guardado";
            }
            return $respuesta;
    }   
  
}
