<?php

/**
 * permiso actions.
 *
 * @package    asistencia
 * @subpackage permiso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class permisoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->permisos = Doctrine_Core::getTable('Permiso')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->permiso = Doctrine_Core::getTable('Permiso')->find(array($request->getParameter('idpermiso')));
    $this->forward404Unless($this->permiso);
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->form = new MotivoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PermisoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($permiso = Doctrine_Core::getTable('Permiso')->find(array($request->getParameter('idpermiso'))), sprintf('Object permiso does not exist (%s).', $request->getParameter('idpermiso')));
    $this->form = new PermisoForm($permiso);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($permiso = Doctrine_Core::getTable('Permiso')->find(array($request->getParameter('idpermiso'))), sprintf('Object permiso does not exist (%s).', $request->getParameter('idpermiso')));
    $this->form = new PermisoForm($permiso);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($permiso = Doctrine_Core::getTable('Permiso')->find(array($request->getParameter('idpermiso'))), sprintf('Object permiso does not exist (%s).', $request->getParameter('idpermiso')));
    $permiso->delete();

    $this->redirect('permiso/index');
  }

  public function executeAsignar(){}
  
  public function executeListado(sfWebRequest $request){
      $resultado = doctrine_Core::getTable("Permiso")->getPermisoUsuarioJson($request->getParameter("usuario"),$request);
        return $this->renderText(json_encode(array(
                "sEcho"=> intval($request->getParameter('sEcho')),
                "iTotalRecords" =>count($resultado), //total de resultados
                "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
        )));
  }
  
  public function executeAsignar_permiso(sfWebRequest $request){
        $usuario = Doctrine_Core::getTable("Usuario")->find(array($request->getParameter("usuario_id")));
        $motivos = Doctrine_Core::getTable("Motivo")->listar();
        return $this->renderPartial("cargar",array("usuario"=>$usuario,"motivos"=>$motivos));
        
  }
  
  public function executeGuardar_permiso(sfWebRequest $request){
      $resultado = "No se pudo guardar el permiso";
      if($request->getParameter("usuario")&& is_numeric($request->getParameter("usuario"))&& $request->getParameter("idregistrador")&& is_numeric($request->getParameter("idregistrador"))){
          $tiempo=array(
           "dias"=> ($request->getParameter("tiempo")=="dias")?$request->getParameter("tiempo"):$request->getParameter("dias"),
           "parcial"=> ($request->getParameter("tiempo")=="parcial")?$request->getParameter("tiempo"):$request->getParameter("parcial"));
          $fecha = array(
              "desde"=>Asistencia::cambiarFormatoFecha((($request->getParameter("tiempo") == "parcial")?$request->getParameter("fecha"):$request->getParameter("desde")),"/"),
              "hasta"=>Asistencia::cambiarFormatoFecha((($request->getParameter("tiempo") == "parcial")?$request->getParameter("fecha"):$request->getParameter("hasta")),"/")
          );
         // $existe=Doctrine_Core::getTable("Permiso")->getPermisoUsuario($request->getParameter("usuario"),$fecha,null,null,$request->getParameter("permiso"))->execute();
         $existe=Doctrine_Core::getTable("Permiso")->getVerificarPermiso($request->getParameter("usuario"),$fecha,$tiempo)->execute();
          if($existe->count()){
              $resultado = "La fecha seleccionada ya esta asignada a un permiso ";
          }else{
                if($request->getParameter("permiso") && is_numeric($request->getParameter("permiso"))){
                    $permiso = Doctrine_Core::getTable("Permiso")->findOneByIdpermiso(array($request->getParameter("permiso")));
                    if($permiso->count()){
                        $permiso->setUsuarioId($request->getParameter("usuario"));
                        $permiso->setTipopermiso($request->getParameter("tiempo"));
                        $permiso->setIdmotivo($request->getParameter("motivo"));
                        if($permiso->getTipopermiso() == "parcial"){
                            $permiso->setFechadesde($request->getParameter("fecha"));
                            $permiso->setFechahasta($request->getParameter("fecha"));
                            $permiso->setHoras($request->getParameter("horas"));
                        }else if($permiso->getTipopermiso() == "dias"){
                            $permiso->setFechadesde($request->getParameter("desde"));
                            $permiso->setFechahasta($request->getParameter("hasta"));
                            $permiso->setHoras(0);
                        }else{
                                return $this->renderText("debe seleccionar un tiempo valido");
                        }
                        $permiso->save();
                        $resultado = "Permiso modificado"; 
                    }else{
                        $resultado = "No se pudo modificar el permiso";
                    }
                }else{
                    $permiso = new Permiso();
                    $permiso->setUsuarioId($request->getParameter("usuario"));
                    $permiso->setIdUsuarioR ($request->getParameter("idregistrador"));
                    $permiso->setTipopermiso($request->getParameter("tiempo"));
                    $permiso->setIdmotivo($request->getParameter("motivo"));
                    if($request->getParameter("tiempo") == "parcial"){
                        $permiso->setFechadesde($request->getParameter("fecha"));
                        $permiso->setFechahasta($request->getParameter("fecha"));
                        $permiso->setHoras($request->getParameter("horas"));
                    }else if($request->getParameter("tiempo") == "dias"){
                        $permiso->setFechadesde($request->getParameter("desde"));
                        $permiso->setFechahasta($request->getParameter("hasta"));
                        $permiso->setHoras(0);
                    }else{
                        return $this->renderText("debe seleccionar un tiempo valido");
                    }
                    $permiso->save();
                    $resultado = "Permiso Guardado";  
                }
          }
      }
      return $this->renderText($resultado);
  }
  
  public function executeEliminar_permiso(sfWebRequest $request){
      $resultado = "Error intentando eliminar el permiso";
      if(is_numeric($request->getParameter("permiso"))){
          $permiso = Doctrine_Core::getTable("Permiso")->findOneByIdpermiso(array($request->getParameter("permiso")));
          if($permiso->count()){
              $permiso->delete();
              $resultado = "El permiso fue eliminado correctamente";
          }
      }
      return $this->renderText($resultado);
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $permiso = $form->save();

      $this->redirect('permiso/edit?idpermiso='.$permiso->getIdpermiso());
    }
  }
}
