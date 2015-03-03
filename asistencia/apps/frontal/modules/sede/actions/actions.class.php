<?php

/**
 * sede actions.
 *
 * @package    asistencia
 * @subpackage sede
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sedeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->sedes = Doctrine_Core::getTable('Sede')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->sede = Doctrine_Core::getTable('Sede')->find(array($request->getParameter('idsede')));
    $this->forward404Unless($this->sede);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SedeForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SedeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sede = Doctrine_Core::getTable('Sede')->find(array($request->getParameter('idsede'))), sprintf('Object sede does not exist (%s).', $request->getParameter('idsede')));
    $this->form = new SedeForm($sede);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sede = Doctrine_Core::getTable('Sede')->find(array($request->getParameter('idsede'))), sprintf('Object sede does not exist (%s).', $request->getParameter('idsede')));
    $this->form = new SedeForm($sede);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sede = Doctrine_Core::getTable('Sede')->find(array($request->getParameter('idsede'))), sprintf('Object sede does not exist (%s).', $request->getParameter('idsede')));
    $sede->delete();

    $this->redirect('sede/index');
  }

    public function executeCrear(sfWebRequest $request){
        $datos = $request->getParameter("sedes");
        if(is_numeric($datos["idsede"])){
            foreach($datos as $name => $value):
                $request->setParameter($name, $value);
            endforeach;
            $sede = Doctrine_Core::getTable('Sede')->findOneByIdsede(array($request->getParameter('idsede')));
            $this->form = new SedeForm($sede);
        }else{
            $this->form = new SedeForm();
        }
            return $this->renderText(json_encode($this->processForm($request, $this->form)));
    }  
  
    public function executeLista(sfWebRequest $request){
            $resultado = Doctrine_Core::getTable('Sede')->buscarSedeJson($request->getParameter("sSearch"));
            return $this->renderText(json_encode(array(
                    "sEcho"=> intval($request->getParameter('sEcho')),
                    "iTotalRecords" =>count($resultado), //total de resultados
                    "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                    "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
            )));
    }  
    public function executeEliminar(sfWebRequest $request){
        $sede = Doctrine_Core::getTable('Sede')->findOneByIdsede(array($request->getParameter('sede')));
        if($sede->count() && $request->getParameter('sede')){
            $sede->delete(); 
            return $this->renderText(json_encode("Sede eliminada"));
        }else{
            return $this->renderText(json_encode("Error intentando eliminar la sede"));
        }
    }
    protected function processForm(sfWebRequest $request, sfForm $form){
            $respuesta = "Error intentando guardar la sede";
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
            if ($form->isValid()){
                    $form->save();
                    $respuesta = "sede Guardada";
            }
            return $respuesta;
    }
}
