<?php

/**
 * motivo actions.
 *
 * @package    asistencia
 * @subpackage motivo
 * @author     Juan Casseus
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class motivoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->motivos = Doctrine_Core::getTable('motivo')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new motivoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new motivoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($motivo = Doctrine_Core::getTable('motivo')->find(array($request->getParameter('idmotivo'))), sprintf('Object motivo does not exist (%s).', $request->getParameter('idmotivo')));
    $this->form = new motivoForm($motivo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($motivo = Doctrine_Core::getTable('motivo')->find(array($request->getParameter('idmotivo'))), sprintf('Object motivo does not exist (%s).', $request->getParameter('idmotivo')));
    $this->form = new motivoForm($motivo);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($motivo = Doctrine_Core::getTable('motivo')->find(array($request->getParameter('idmotivo'))), sprintf('Object motivo does not exist (%s).', $request->getParameter('idmotivo')));
    $motivo->delete();

    $this->redirect('motivo/index');
  }

  public function executeLista(sfWebRequest $request){
      $resultado = Doctrine_Core::getTable('motivo')->buscarMotivoJson($request);
        return $this->renderText(json_encode(array(
                "sEcho"=> intval($request->getParameter('sEcho')),
                "iTotalRecords" =>count($resultado), //total de resultados
                "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
        )));
  }

    
  public function executeGuardar(sfWebRequest $request){
      $datos =  $request->getParameter("motivos");
      foreach($datos as $name => $value):
        $request->setParameter($name, $value);
      endforeach;
      
      if($request->getParameter("idmotivo") && !$request->getParameter("eliminar")){
            $motivo = Doctrine_Core::getTable('Motivo')->findOneByIdmotivo(array($request->getParameter("idmotivo")));
           // $motivo->setIdusuario($this->getUser()->getDatosBasicos()->getIdusuario());
            $this->form = new MotivoForm($motivo);
      }else if($request->getParameter("idmotivo") && $request->getParameter("eliminar")){ 
            $motivo = Doctrine_Core::getTable('Motivo')->findOneByIdmotivo(array($request->getParameter("idmotivo")));
            $motivo->setActivo(false);
            $motivo->save();
            return $this->renderText(json_encode("Motivo eliminado")); 
      }else{
            $motivo = new Motivo();
            //$motivo->setIdusuario($this->getUser()->getDatosBasicos()->getIdusuario());
            $this->form = new MotivoForm($motivo);
      }
      return $this->renderText(json_encode($this->processForm($request, $this->form)));
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form){
        $resultado = "no fue posible guardar el motivo";//array("valido"=>false,"mensaje"=>"no fue posible guardar el motivo "); 
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()){
            $form->save();     
            $resultado = "Motivo Guardada";//array("valido"=>true,"mensaje"=>"Motivo Guardada"); 
        }
        return $resultado;
  }
}
