<?php

/**
 * feriado actions.
 *
 * @package    asistencia
 * @subpackage feriado
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class feriadoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->feriados = Doctrine_Core::getTable('Feriado')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->feriado = Doctrine_Core::getTable('Feriado')->find(array($request->getParameter('idferiado'),
                                                   $request->getParameter('feriado')));
    $this->forward404Unless($this->feriado);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new FeriadoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FeriadoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($feriado = Doctrine_Core::getTable('Feriado')->find(array($request->getParameter('idferiado'),
                             $request->getParameter('feriado'))), sprintf('Object feriado does not exist (%s).', $request->getParameter('idferiado'),
                             $request->getParameter('feriado')));
    $this->form = new FeriadoForm($feriado);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($feriado = Doctrine_Core::getTable('Feriado')->find(array($request->getParameter('idferiado'),
                             $request->getParameter('feriado'))), sprintf('Object feriado does not exist (%s).', $request->getParameter('idferiado'),
                             $request->getParameter('feriado')));
    $this->form = new FeriadoForm($feriado);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($feriado = Doctrine_Core::getTable('Feriado')->find(array($request->getParameter('idferiado'),
                             $request->getParameter('feriado'))), sprintf('Object feriado does not exist (%s).', $request->getParameter('idferiado'),
                             $request->getParameter('feriado')));
    $feriado->delete();

    $this->redirect('feriado/index');
  }
  
  public function executeGuardar(sfWebRequest $request){
      $datos = $request->getParameter("feriados");
            foreach($datos as $name => $value):
                 $request->setParameter($name, $value);
            endforeach;
      if($request->getParameter("idferiado")){
            $feriado = Doctrine_Core::getTable('Feriado')->findOneByIdferiado(array($request->getParameter('idferiado')));
            $this->form = new FeriadoForm($feriado);
      }else{
            $this->form = new FeriadoForm();
      }
      return $this->renderText(json_encode($this->processForm($request, $this->form)));   
  }
  
  public function executeLista(sfWebRequest $request){
        $resultado = Doctrine_Core::getTable('feriado')->buscarFeriadoJson($request,true);
        return $this->renderText(json_encode(array(
                "sEcho"=> intval($request->getParameter('sEcho')),
                "iTotalRecords" =>count($resultado), //total de resultados
                "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
        )));
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form){
    $resultado = array("valido"=>false,"mensaje"=>"no fue posible guardar el dia feriado");
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
      $form->save();
      $resultado = array("valido"=>true,"mensaje"=>"Feriado Guardado");
    }
    return $resultado;
  }
}
