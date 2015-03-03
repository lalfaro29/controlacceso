<?php

/**
 * usuario actions.
 *
 * @package    asistencia
 * @subpackage usuario
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioActions extends sfActions
{
    public function executeIndex(sfWebRequest $request){
        $this->form = new UsuarioForm();
    }

    public function executeShow(sfWebRequest $request){
        $this->usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idusuario')));
        $this->forward404Unless($this->usuario);
    }

    public function executeNew(sfWebRequest $request){
        $this->form = new UsuarioForm();
    }
  
    public function executeEdit(sfWebRequest $request){
        $this->forward404Unless($usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idusuario'))), sprintf('Object usuario does not exist (%s).', $request->getParameter('idusuario')));
        $this->form = new UsuarioForm($usuario);
    }

    public function executeUpdate(sfWebRequest $request){
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idusuario'))), sprintf('Object usuario does not exist (%s).', $request->getParameter('idusuario')));
        $this->form = new UsuarioForm($usuario);

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request){
        $request->checkCSRFProtection();

        $this->forward404Unless($usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idusuario'))), sprintf('Object usuario does not exist (%s).', $request->getParameter('idusuario')));
        $usuario->delete();

        $this->redirect('usuario/index');
    }
  
    public function executeLista(sfWebRequest $request){
        $resultado = Doctrine_Core::getTable('Usuario')->buscarUsuarioJson2($request);
        return $this->renderText(json_encode(array(
                "sEcho"=> intval($request->getParameter('sEcho')),
                "iTotalRecords" =>count($resultado), //total de resultados
                "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
        )));
    }
  
    public function executeListado(sfWebRequest $request){
        $resultado = Doctrine_Core::getTable('Usuario')->buscarUsuarioJson2($request);
        
        return $this->renderText(json_encode(array(
                "sEcho"=> intval($request->getParameter('sEcho')),
                "iTotalRecords" =>count($resultado), //total de resultados
                "iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
                "aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
        )));
    }
    
    public function executeGuardar(sfWebRequest $request){
        $datos = $request->getParameter("usuario");
        if($datos["idusuario"]){
            
                foreach($datos as $name => $value):
                    $request->setParameter($name,$value);
                endforeach;
                $usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idusuario')));
                
                $usuarioSistema = Doctrine_Core::getTable('UsuarioSistema')->buscarUsuario($request->getParameter('idusuario'));
                
                if($usuarioSistema){
                    $buscarCoordinador = Doctrine_Core::getTable('Coordinador')->buscarCoordinadores($usuario->getIdusuario());

                    if(count($buscarCoordinador)){
                        foreach($buscarCoordinador as $coordinador):
                            $coordinador->delete();
                        endforeach;
                    }

                    $coordinadorNuevo = New Coordinador();
                    $coordinadorNuevo->setUsuarioId($usuario->getIdusuario());
                    $coordinadorNuevo->setDepartamentoId($datos["iddepartamento"]);
                    $coordinadorNuevo->save();
                }
                
                $this->form = new UsuarioForm($usuario);
        }else{
            $this->form = new UsuarioForm();
        }
        return $this->renderText(json_encode($this->processForm($request, $this->form)));

    }

    public function executeEliminar(sfWebRequest $request){
        $resultado= array("valido"=>false,"mensaje"=> "error intentando eliminar el usuario");
        if($request->getParameter("idusuario")){
            $usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idusuario')));
            $usuario->setActivo("N");
            $usuario->save();
            $resultado= array("valido"=>true,"mensaje"=> "Usuario eliminado");
        }
        return $this->renderText(json_encode($resultado));
    }
  
  
    public function executeUsuario(sfWebRequest $request){
        $this->form = new UsuarioForm();
        $this->formTipoUsuario = new TipoUsuarioForm();
    }
  
    public function executeEliminar_usuario(sfWebRequest $request){
        //  $resultado= array("valido"=>false,"mensaje"=>"el usuario no fue encontrado");
        if($usuarioSisetma = Doctrine_Core::getTable('UsuarioSistema')->findOneByIdusuario(array($request->getParameter('idusuario')))){
            $usuarioSisetma->delete();
            $resultado= array("valido"=>true,"mensaje"=>"usuario eliminado");
        }else{
        $resultado= array("valido"=>false,"mensaje"=>"el empleado no posee cuenta de usuario");
        }
        return $this->renderText(json_encode($resultado));
    }
  
    public function executeRegistrar_usuario(sfWebRequest $request){
        if($request->getParameter("clave") !="" && is_numeric($request->getParameter("idusuario"))){
            $usuarioSistema = Doctrine_Core::getTable('UsuarioSistema')->buscarUsuario($request->getParameter("idusuario"));
            if($usuarioSistema){
                $usuarioSistema->setIdtipousuario($request->getParameter("idtipousuario"));
                $usuarioSistema->setPsw($request->getParameter("clave"));
                $usuarioSistema->save();

                $user = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter("idusuario")));
                $buscarCoordinador = Doctrine_Core::getTable('Coordinador')->buscarCoordinadores($user->getIdusuario());

                if(count($buscarCoordinador)){
                    foreach($buscarCoordinador as $coordinador):
                        $coordinador->delete();
                    endforeach;
                }

                if($user){
                    $coordinadorNuevo = New Coordinador();
                    $coordinadorNuevo->setUsuarioId($user->getIdusuario());
                    $coordinadorNuevo->setDepartamentoId($user->getIddepartamento());
                    $coordinadorNuevo->save();
                }

                return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"Usuario Actualizado"))); 
            }else{
                    $usuarioSistema = new UsuarioSistema();
                    $usuarioSistema->setIdtipousuario($request->getParameter("idtipousuario"));
                    $usuarioSistema->setIdusuario($request->getParameter("idusuario"));
                    $usuarioSistema->setPsw($request->getParameter("clave"));
                    $usuarioSistema->save();
                    
                    $user = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter("idusuario")));
                    if($user){
                        $coordinadorNuevo = New Coordinador();
                        $coordinadorNuevo->setUsuarioId($user->getIdusuario());
                        $coordinadorNuevo->setDepartamentoId($user->getIddepartamento());
                        $coordinadorNuevo->save();
                    }
                    
                return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"Usuario registrado"))); 
            }
        }else{
            return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"los datos enviados son invalidos")));
        }

        return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"registro de usuario")));
    }
  
    public function executeConfirmar_clave(sfWebRequest $request){}
  
    public function executeCambiar_clave(sfWebRequest $request){
        if($usuarioSistema = Doctrine_Core::getTable('UsuarioSistema')->findOneByIdusuariosistema(array( $this->getUser()->getDatosBasicos()->getUsuarioSistema()->getFirst()->getIdusuariosistema()))){
                $usuarioSistema->setPsw($request->getParameter("clave"));
                $usuarioSistema->save();
                if($this->getUser()->setClave($request->getParameter("clave"))){
                    return $this->renderText(json_encode("Usuario Actualizado")); 
                }else{
                    return $this->renderText(json_encode("No fue posible actualizar el usuario"));
                }
        }else{
            return $this->renderText(json_encode("No fue posible actualizar el usuario"));
        }
    }
  
    public function executeCombo_usuario(sfWebRequest $request){
        return $this->renderText(json_encode(Doctrine_Core::getTable('Usuario')->listarUsuarioSelect($request->getParameter("departamento"))));
    }
    
    public function executeCombo_usuario_tipo(sfWebRequest $request){
        return $this->renderText(json_encode(Doctrine_Core::getTable('Usuario')->listarUsuarioSelectPorTipo($request->getParameter("departamento"),$request->getParameter("tipo"))));
    }
    
    public function executeBuscar_vista(sfWebRequest $request){
        $resultado = Doctrine_Core::getTable('VDatosPersonales')->validarDatosUsuarios($request->getParameter("usuario_cedula"));
        if($resultado!=NULL){
            $cedula=$resultado[0]['cedula'];
            $nombre=$resultado[0]['primer_nombre'];
            $nombre1=$resultado[0]['segundo_nombre'];
            $apellido=$resultado[0]['primer_apellido'];
            $apellido1=$resultado[0]['segundo_apellido'];
            $idtipop=$resultado[0]['id_tipo_personal'];
            $tipop=$resultado[0]['nombre'];
            $idunidadf=$resultado[0]['id_unidad_funcional'];
            $unidadf=$resultado[0]['nombre_uf'];
            return $this->renderText(json_encode(array(
                "valido"=>true,
                "cedula"=> $cedula,
                "nombre"=>$nombre,
                "nombre1"=>$nombre1,
                "apellido"=>$apellido,
                "apellido1"=>$apellido1,
                "idtipop"=>$idtipop,
                "tipop"=>$tipop,
                "idunidadf"=>$idunidadf,
                "unidadf"=>$unidadf                
                
            )));
        } else{
            return $this->renderText(json_encode(array(
                "valido"=>false,
                "mensaje"=>"Empleado no registrado en SIGEFIRRHH."                
                
            )));
        }
    }
    
    public function executeConfirmar_nomina(sfWebRequest $request){
    }
    
    public function executeActualizar(sfWebRequest $request){
        $buscarUsuarios = Doctrine_Core::getTable('Usuario')->traerUsuarios();

        if(count($buscarUsuarios)){
            foreach($buscarUsuarios as $usuario):
                $resultado = Doctrine_Core::getTable('VDatosPersonales')->validarDatosUsuarios($usuario->getCedula());
                if($resultado!=NULL){
                    $nomina = $resultado[0]['codigo_nomina'];
                    $actualizarCodigo = Doctrine_Core::getTable('Usuario')->actualizarCodigoNomina($usuario->getCedula(),$nomina);
                }
                
            endforeach;
        }
        
        return $this->renderText(json_encode(array(
            "mensaje"=> "Se han actualizado correctamente todos los codigos de nomina!"
        )));
    }
    
    public function executeDeshabilitar(sfWebRequest $request)
    {
        $usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idUsuario')));
        $usuario->setActivo('N');
        $usuario->save();
        return $this->renderText(json_encode(array(
                "mensaje"=> "Se ha deshabilitado correctamente."
        )));
    }

    public function executeHabilitar(sfWebRequest $request)
    {
        $usuario = Doctrine_Core::getTable('Usuario')->find(array($request->getParameter('idUsuario')));
        $usuario->setActivo('S');
        $usuario->save();
        return $this->renderText(json_encode(array(
                "mensaje"=> "Se ha habilitado correctamente."
        )));
    }
  
    protected function processForm(sfWebRequest $request, sfForm $form){
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        $resultado = array("valido"=>false,"mensaje"=>"no fue posible guardar el empleado");
        
        $datos = $request->getParameter("usuario");
        $usuario = Doctrine_Core::getTable('Usuario')->buscarPorCedula($datos["cedula"]);
        
        if ($usuario){
            $resultado = array("valido"=>false,"mensaje"=>"no fue posible guardar, ya hay un empleado asociado a ese nro de cedula.");
        }else{
            if ($form->isValid()){
                $form->save();

    //            $datos = $request->getParameter("usuario");
    //            $buscarUsuario = Doctrine_Core::getTable('Usuario')->buscarPorCedula($datos["cedula"]);
    //            
    //            if($datos["cedula"]){
    //                
    //            }
    //            $buscarCoordinador = Doctrine_Core::getTable('Coordinador')->buscarCoordinadores($buscarUsuario->getIdusuario());
    //
    //            if(count($buscarCoordinador)){
    //                foreach($buscarCoordinador as $coordinador):
    //                    $coordinador->delete();
    //                endforeach;
    //            }
    //            
    //            if(count($buscarCoordinador)){
    //                $coordinadorNuevo = New Coordinador();
    //                $coordinadorNuevo->setUsuarioId($buscarUsuario->getIdusuario());
    //                $coordinadorNuevo->setDepartamentoId($buscarUsuario->getIddepartamento());
    //                $coordinadorNuevo->save();
    //            }

                $resultado = array("valido"=>true,"mensaje"=>"Empleado Guardado");
            }else{
                foreach($form->getWidgetSchema()->getPositions() as $widgetName){
                    if($form[$widgetName]->renderError()){
                        echo $widgetName." = ".$form[$widgetName]->renderError()."\n";
                    }
                }

                //getGlobalErrors
            //$resultado = array("valido"=>false,"mensaje"=>($form->renderGlobalErrors()));
            }
        }
        
        return $resultado;
    }
}
