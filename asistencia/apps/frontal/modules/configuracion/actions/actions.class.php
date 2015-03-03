<?php

/**
 * configuracion actions.
 *
 * @package    asistencia
 * @subpackage configuracion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class configuracionActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->configuracions = Doctrine_Core::getTable('Configuracion')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request){
    $this->configuracion = Doctrine_Core::getTable('Configuracion')->find(array($request->getParameter('idconfiguracion')));
    $this->forward404Unless($this->configuracion);
  }

  public function executeNew(sfWebRequest $request){
    $this->form = new ConfiguracionForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ConfiguracionForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($configuracion = Doctrine_Core::getTable('Configuracion')->find(array($request->getParameter('idconfiguracion'))), sprintf('Object configuracion does not exist (%s).', $request->getParameter('idconfiguracion')));
    $this->form = new ConfiguracionForm($configuracion);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($configuracion = Doctrine_Core::getTable('Configuracion')->find(array($request->getParameter('idconfiguracion'))), sprintf('Object configuracion does not exist (%s).', $request->getParameter('idconfiguracion')));
    $this->form = new ConfiguracionForm($configuracion);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($configuracion = Doctrine_Core::getTable('Configuracion')->find(array($request->getParameter('idconfiguracion'))), sprintf('Object configuracion does not exist (%s).', $request->getParameter('idconfiguracion')));
    $configuracion->delete();

    $this->redirect('configuracion/index');
  }

  
  public function executeListado1(sfWebRequest $request){
      //listado de configuraciones cargadas en el sistma
      $resultado = Doctrine_Core::getTable('Configuracion')->buscarConfiguracionJson($request);
        return $this->renderText(json_encode(array(
                "sEcho"=> intval($request->getParameter('sEcho')),
                "iTotalRecords" =>count($resultado), //total de resultados
                "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
        )));
  }
  
    public function executeListado2(sfWebRequest $request){
        //listado de los dias feriados cargados a una configuracion especifica
      $resultado = Doctrine_Core::getTable('feriado')->buscarFeriadoJson($request);
        return $this->renderText(json_encode(array(
                "sEcho"=> intval($request->getParameter('sEcho')),
                "iTotalRecords" =>count($resultado), //total de resultados
                "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
        )));
  }
  
  
  public function executeRegistrar(sfWebRequest $request){
      $datos =  $request->getParameter("configuracion");
      foreach($datos as $name => $value):
        $request->setParameter($name, $value);
      endforeach;
      
      if($request->getParameter("idconfiguracion")){
            $configuracion = Doctrine_Core::getTable('Configuracion')->findOneByIdconfiguracion(array($request->getParameter("idconfiguracion")));
            $configuracion->setIdusuario($this->getUser()->getDatosBasicos()->getIdusuario());
            $this->form = new ConfiguracionForm($configuracion);
      }else{
            $configuracion = new Configuracion();
            $configuracion->setIdusuario($this->getUser()->getDatosBasicos()->getIdusuario());
            $this->form = new ConfiguracionForm($configuracion);
      }
      return $this->renderText(json_encode($this->processForm($request, $this->form)));
  }
  
  
  public function executeLista_feriados(){
      return $this->renderPartial("feriado/listado",array("botones"=>true));
  }
  
  public function executeGuardar_feriado(sfWebRequest $request){
      if($request->getParameter("idconfiguracion")){
        foreach($request->getParameter("check_feriado") as $idFeriado):
            if($idFeriado && is_numeric($idFeriado)){
                $relacionConfiguracionFeriado = new RelacionConfigFeriado();
                $relacionConfiguracionFeriado->setIdconfiguracion($request->getParameter("idconfiguracion"));
                $relacionConfiguracionFeriado->setIdferiado($idFeriado);
                $relacionConfiguracionFeriado->save();
            }else{
                return $this->renderText(json_encode("Error intentando guardar el feriado "));
                break;
            }
        endforeach;
        return $this->renderText(json_encode("los dias feriados han sido guardados"));
      }else{
        return $this->renderText(json_encode("Error intentando guardar el feriado "));
      }
  }
  
  public function executeEliminar_feriado(sfWebRequest $request){
      $feriado = Doctrine_Core::getTable('RelacionConfigFeriado')->getRelacionFeriado($request->getParameter("feriado_id"),$request->getParameter("configuracion"));
      if($feriado->count()){
          $feriado->delete();
          return $this->renderText(json_encode(array("Feriado eliminado")));
      }else{
          return $this->renderText(json_encode(array("no se pudo eliminar el feriado asignado a la configuracion")));
      }
  }
  
  public function executeEliminar(sfWebRequest $request){
      $configuracion = Doctrine_Core::getTable('Configuracion')->findOneByIdconfiguracion(array($request->getParameter("configuracion")));
      if($configuracion->count()){
        $feriado = Doctrine_Core::getTable('RelacionConfigFeriado')->findOneByIdconfiguracion(array($request->getParameter("configuracion")));
        $feriado->delete();
        $configuracion->delete();
          return $this->renderText(json_encode("Configuracion eliminada"));
      }else{
          return $this->renderText(json_encode("La configuracion que intenta eliminar no es valida"));
      }
      return $this->renderText(json_encode(123));
  }
  
  
  protected function processForm(sfWebRequest $request, sfForm $form){
    $resultado = array("valido"=>false,"mensaje"=>"no fue posible guardar la configuracion "); 
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
        $form->save();     
        $resultado = array("valido"=>true,"mensaje"=>"Configuracion Guardada"); 
    }
    return $resultado;
  }
}
