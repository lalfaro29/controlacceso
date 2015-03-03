<?php

/**
 * cargo actions.
 *
 * @package    asistencia
 * @subpackage cargo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cargoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->cargos = Doctrine_Core::getTable('Cargo')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->cargo = Doctrine_Core::getTable('Cargo')->find(array($request->getParameter('idcargo')));
    $this->forward404Unless($this->cargo);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CargoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CargoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($cargo = Doctrine_Core::getTable('Cargo')->find(array($request->getParameter('idcargo'))), sprintf('Object cargo does not exist (%s).', $request->getParameter('idcargo')));
    $this->form = new CargoForm($cargo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($cargo = Doctrine_Core::getTable('Cargo')->find(array($request->getParameter('idcargo'))), sprintf('Object cargo does not exist (%s).', $request->getParameter('idcargo')));
    $this->form = new CargoForm($cargo);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($cargo = Doctrine_Core::getTable('Cargo')->find(array($request->getParameter('idcargo'))), sprintf('Object cargo does not exist (%s).', $request->getParameter('idcargo')));
    $cargo->delete();

    $this->redirect('cargo/index');
  }
    public function executeCrear(sfWebRequest $request){
        $datos = $request->getParameter("cargos");
        if(is_numeric($datos["idcargo"])){
            foreach($datos as $name => $value):
                $request->setParameter($name, $value);
            endforeach;
            $cargo = Doctrine_Core::getTable('Cargo')->findOneByIdcargo(array($request->getParameter('idcargo')));
            $this->form = new CargoForm($cargo);
        }else{
            $this->form = new CargoForm();
        }
            return $this->renderText(json_encode($this->processForm($request, $this->form)));
    }  
  
    public function executeLista(sfWebRequest $request){
            $resultado = Doctrine_Core::getTable('Cargo')->buscarCargoJson($request->getParameter("sSearch"));
            return $this->renderText(json_encode(array(
                    "sEcho"=> intval($request->getParameter('sEcho')),
                    "iTotalRecords" =>count($resultado), //total de resultados
                    "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                    "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
            )));
    }  
    public function executeEliminar(sfWebRequest $request){
        $empleado = Doctrine_Core::getTable('Cargo')->findOneByIdcargo(array($request->getParameter('cargo')));
        if($empleado->count() && $request->getParameter('cargo')){
            $empleado->delete(); 
            return $this->renderText(json_encode("cargo eliminado"));
        }else{
            return $this->renderText(json_encode("Error intentando eliminar el cargo"));
        }
    }
    protected function processForm(sfWebRequest $request, sfForm $form){
            $respuesta = "Error intentando guardar el cargo";
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
            if ($form->isValid()){
                    $form->save();
                    $respuesta = "cargo Guardado";
            }
            return $respuesta;
    } 
}
