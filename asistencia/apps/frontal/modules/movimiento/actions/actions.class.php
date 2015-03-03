<?php

/**
 * movimiento actions.
 *
 * @package    asistencia
 * @subpackage movimiento
 * @author     Juan Casseus
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class movimientoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->movimientos = Doctrine_Core::getTable('movimiento')
      ->createQuery('a')
      ->execute();
  }
/*
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new movimientoForm();
  }
*/
  public function executeRegistro_manual(sfWebRequest $request){
    $this->form = new movimientoForm();
    $this->motivos = Doctrine_Core::getTable('Motivo')->listar();
    $this->setTemplate('new');
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new movimientoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($movimiento = Doctrine_Core::getTable('movimiento')->find(array($request->getParameter('idmovimiento'))), sprintf('Object movimiento does not exist (%s).', $request->getParameter('idmovimiento')));
    $this->form = new movimientoForm($movimiento);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($movimiento = Doctrine_Core::getTable('movimiento')->find(array($request->getParameter('idmovimiento'))), sprintf('Object movimiento does not exist (%s).', $request->getParameter('idmovimiento')));
    $this->form = new movimientoForm($movimiento);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($movimiento = Doctrine_Core::getTable('movimiento')->find(array($request->getParameter('idmovimiento'))), sprintf('Object movimiento does not exist (%s).', $request->getParameter('idmovimiento')));
    $movimiento->delete();

    $this->redirect('movimiento/index');
  }

  public function executeValidar_fecha(sfWebRequest $request){
      if($request->getParameter("movimiento","null") != "null"){
        $movimiento = Doctrine_Core::getTable('Movimiento')->MovimientoUsuarioFecha($request->getParameter("idusuario"),Asistencia::cambiarFormatoFecha($request->getParameter("fecha"),"/"));
        
        if(count($movimiento)){
            $datos = array(
                "valido"=>true,  
                "entrada"=>$movimiento[0]["fechaentrada"]?date("h:i a",(strtotime($movimiento[0]["fechaentrada"]))):"",
                "salida"=>$movimiento[0]["fechasalida"]?date("h:i a",(strtotime($movimiento[0]["fechasalida"]))):"",
                "entrada_id"=>$movimiento[0]["entrada_id"],
                "salida_id"=>$movimiento[0]["salida_id"],
                "data"=>true
            );
        }else{
            $datos = array(
                "valido"=>true,
                "data"=>false
            );
        }
      }else{
            $datos = array(
                "valido"=>true,
                "data"=>false
            );
      }
      return $this->renderText(json_encode($datos));
  }
  
  public function executeGuardar_movimiento(sfWebRequest $request){
        $ip=        @$_SERVER['REMOTE_ADDR'];
        $servidor=  @$_SERVER['SERVER_ADDR'];
      if((!$request->getParameter("hora_entrada") || $request->getParameter("hora_entrada")=="") && (!$request->getParameter("hora_salida") || $request->getParameter("hora_salida")=="")){
        return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"debe ingresar una hora valida")));
      }else if($request->getParameter("movimiento")=="entrada"){
          $usuario = Doctrine_Core::getTable("Usuario")->buscarUsuarios(null,null,null,$request->getParameter("idusuario"))->getFirst();
          $finSemana = date("D",(strtotime(Asistencia::cambiarFormatoFecha_a_MDA($request->getParameter("fecha"),"/",'/'))));
	  $finSemana = ($finSemana=="Sat" || $finSemana=="Sun")?true: false;
          if($finSemana){
              $registro = "FIN DE SEMANA";
          }else{
		$feriado = $usuario->configuracion()->feriados($request->getParameter("fecha"));
		$feriado = ($feriado->count())?true: false;
                if($feriado){
                    $registro = "DIA FERIADO";
                }else{
                    $horas = Asistencia::comparar_horas(Asistencia::modificar_hora($usuario->getConfiguracion()->getHoraentrada(),(INT)$usuario->getConfiguracion()->getHoramaxentrada()),date("H:i:s",(strtotime($request->getParameter("hora_entrada")))));
                    $registro = ($horas < 0)?"RETRASADO":"PUNTUAL";
                }	 
          }
          if($request->getParameter("entrada_id")){
              $movimiento = Doctrine_Core::getTable('Movimiento')->findOneByIdmovimiento(array($request->getParameter("entrada_id")));
              if($movimiento->count()){
                  $movimiento->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_entrada")))));
                  $movimiento->setEstado("REGISTRADO");
                  $movimiento->setIpsede($servidor);
                  $movimiento->setIpusuario($ip);
                  $movimiento->setRegistro($registro);
                  if($request->getParameter("motivo")){
                      $movimiento->setIdmotivo($request->getParameter("motivo"));
                  }
                  $movimiento->save();
                  return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"movimiento guardado.")));
              }else{
                return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"el movimiento que intenta guardar no es valido")));
              }
          }else{
                  $movimiento = new Movimiento();
                  $movimiento->setIdusuario($request->getParameter("idusuario"));
                  $movimiento->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_entrada")))));
                  $movimiento->setEstado("REGISTRADO");
                  $movimiento->setMovimiento("E");
                  $movimiento->setIpsede($servidor);
                  $movimiento->setIpusuario($ip);
                  $movimiento->setIdconfiguracion($usuario->getConfiguracion()->getIdconfiguracion());
                  $movimiento->setRegistro($registro);
                  if($request->getParameter("motivo")){
                      $movimiento->setIdmotivo($request->getParameter("motivo"));
                  }
                  $movimiento->save();
                  return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"movimiento guardado.")));
          }
      }else if($request->getParameter("movimiento")=="salida"){
          $usuario = Doctrine_Core::getTable("Usuario")->buscarUsuarios(null,null,null,$request->getParameter("idusuario"))->getFirst();
          $movimiento = Doctrine_Core::getTable("Movimiento")->movimientosUsuario($request->getParameter("idusuario"),Asistencia::cambiarFormatoFecha($request->getParameter("fecha"),'/','-'),"E")->execute()->getFirst();
          if($movimiento->count()){
                $finSemana = date("D",(strtotime(Asistencia::cambiarFormatoFecha_a_MDA($request->getParameter("fecha"),"/",'/'))));
                $finSemana = ($finSemana=="Sat" || $finSemana=="Sun")?true: false;
                if($finSemana){
                    $registro = "FIN DE SEMANA";
                }else{
                        $feriado = $usuario->configuracion()->feriados($request->getParameter("fecha"));
                        $feriado = ($feriado->count())?true: false;
                        if($feriado){
                            $registro = "DIA FERIADO";
                        }else{
                            $horas= (Asistencia::contarHoras(date("H:i:s",(strtotime($usuario->getConfiguracion()->getHoraentrada()))),date("H:i:s",(strtotime($usuario->getConfiguracion()->getHorasalida()))))/60);
                            $horas_usuario = (Asistencia::contarHoras(date("H:i:s",(strtotime($movimiento->getFecha()))),date("H:i:s",(strtotime($request->getParameter("hora_salida")))))/60);
                            $registro = ($horas_usuario < $horas)?"ADELANTADO":"PUNTUAL";
                        }	 
                }
              if($request->getParameter("salida_id")){
                    $movimiento = Doctrine_Core::getTable('Movimiento')->findOneByIdmovimiento(array($request->getParameter("salida_id")));
                    if($movimiento->count()){
                        $movimiento->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_salida")))));
                        $movimiento->setEstado("REGISTRADO");
                        $movimiento->setIpsede($servidor);
                        $movimiento->setIpusuario($ip);
                        $movimiento->setRegistro($registro);
                        if($request->getParameter("motivo")){
                            $movimiento->setIdmotivo($request->getParameter("motivo"));
                        }
                        $movimiento->save();
                        return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"movimiento guardado !")));
                    }else{
                        return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"el movimiento que intenta guardar no es valido")));
                    }
              }else{
                  $movimiento = new Movimiento();
                  $movimiento->setIdusuario($request->getParameter("idusuario"));
                  $movimiento->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_salida")))));
                  $movimiento->setEstado("REGISTRADO");
                  $movimiento->setMovimiento("S");
                  $movimiento->setIpsede($servidor);
                  $movimiento->setIpusuario($ip);
                  $movimiento->setIdconfiguracion($usuario->getConfiguracion()->getIdconfiguracion());
                  $movimiento->setRegistro($registro);
                  if($request->getParameter("motivo")){
                      $movimiento->setIdmotivo($request->getParameter("motivo"));
                  }
                  $movimiento->save();
                  return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"movimiento guardado.")));
              }
          }else{
            return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"no puede registrar una salida sin entrada")));
          }       
      }else if($request->getParameter("movimiento")=="dia"){
          $usuario = Doctrine_Core::getTable("Usuario")->buscarUsuarios(null,null,null,$request->getParameter("idusuario"))->getFirst();
          $movimiento = Doctrine_Core::getTable('Movimiento')->movimientosUsuario($request->getParameter("idusuario"), Asistencia::cambiarFormatoFecha($request->getParameter("fecha"),"/"),null,"ASC");
          if($movimiento->count()){
              foreach($movimiento->execute() as $i => $registro ):
                  if($i<=1){
                      if($registro->getMovimiento()=="E"){
                            $finSemana = date("D",(strtotime(Asistencia::cambiarFormatoFecha_a_MDA($request->getParameter("fecha"),"/",'/'))));
                            $finSemana = ($finSemana=="Sat" || $finSemana=="Sun")?true: false;
                            if($finSemana){
                                $rg = "FIN DE SEMANA";
                            }else{
                                    $feriado = $usuario->configuracion()->feriados($request->getParameter("fecha"));
                                    $feriado = ($feriado->count())?true: false;
                                    if($feriado){
                                        $rg = "DIA FERIADO";
                                    }else{
                                        $horas = Asistencia::comparar_horas(Asistencia::modificar_hora($usuario->getConfiguracion()->getHoraentrada(),(INT)$usuario->getConfiguracion()->getHoramaxentrada()),date("H:i:s",(strtotime($request->getParameter("hora_entrada")))));
                                        $rg = ($horas < 0)?"RETRASADO":"PUNTUAL";
                                    }	 
                            }
                            $registro->setIdusuario($request->getParameter("idusuario"));
                            $registro->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_entrada")))));
                            $registro->setEstado("REGISTRADO");
                            $registro->setIpsede($servidor);
                            $registro->setIpusuario($ip);
                            $registro->setIdconfiguracion($usuario->getConfiguracion()->getIdconfiguracion());
                            $registro->setRegistro($rg);
                            if($request->getParameter("motivo")){
                                $registro->setIdmotivo($request->getParameter("motivo"));
                            }
                            $registro->save(); 
                      }else if($registro->getMovimiento()=="S"){
                            $finSemana = date("D",(strtotime(Asistencia::cambiarFormatoFecha_a_MDA($request->getParameter("fecha"),"/",'/'))));
                            $finSemana = ($finSemana=="Sat" || $finSemana=="Sun")?true: false;
                            if($finSemana){
                                $rg = "FIN DE SEMANA";
                            }else{
                                    $feriado = $usuario->configuracion()->feriados($request->getParameter("fecha"));
                                    $feriado = ($feriado->count())?true: false;
                                    if($feriado){
                                        $rg = "DIA FERIADO";
                                    }else{
                                        $horas= (Asistencia::contarHoras(date("H:i:s",(strtotime($usuario->getConfiguracion()->getHoraentrada()))),date("H:i:s",(strtotime($usuario->getConfiguracion()->getHorasalida()))))/60);
                                        $horas_usuario = (Asistencia::contarHoras(date("H:i:s",(strtotime($request->getParameter("hora_entrada")))),date("H:i:s",(strtotime($request->getParameter("hora_salida")))))/60);
                                        $rg = ($horas_usuario < $horas)?"ADELANTADO":"PUNTUAL";
                                    }	 
                            }
                            $registro->setIdusuario($request->getParameter("idusuario"));
                            $registro->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_salida")))));
                            $registro->setEstado("REGISTRADO");
                            $registro->setIpsede($servidor);
                            $registro->setIpusuario($ip);
                            $registro->setIdconfiguracion($usuario->getConfiguracion()->getIdconfiguracion());
                            $registro->setRegistro($rg);
                            if($request->getParameter("motivo")){
                                $registro->setIdmotivo($request->getParameter("motivo"));
                            }
                            $registro->save(); 
                      }
                  }else{
                      $registro->delete();
                  }
              endforeach;
              return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"movimiento guardado.")));
          }else{
                $finSemana = date("D",(strtotime(Asistencia::cambiarFormatoFecha_a_MDA($request->getParameter("fecha"),"/",'/'))));
                $finSemana = ($finSemana=="Sat" || $finSemana=="Sun")?true: false;
                if($finSemana){
                    $rg = "FIN DE SEMANA";
                }else{
                        $feriado = $usuario->configuracion()->feriados($request->getParameter("fecha"));
                        $feriado = ($feriado->count())?true: false;
                        if($feriado){
                            $rg = "DIA FERIADO";
                        }else{
                            $horas = Asistencia::comparar_horas(Asistencia::modificar_hora($usuario->getConfiguracion()->getHoraentrada(),(INT)$usuario->getConfiguracion()->getHoramaxentrada()),date("H:i:s",(strtotime($request->getParameter("hora_entrada")))));
                            $rg = ($horas < 0)?"RETRASADO":"PUNTUAL";
                        }	 
                }
                
                $entrada = new Movimiento();
                $entrada->setIdusuario($request->getParameter("idusuario"));
                $entrada->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_entrada")))));
                $entrada->setEstado("REGISTRADO");
                $entrada->setIpsede($servidor);
                $entrada->setIpusuario($ip);
                $entrada->setMovimiento("E");
                $entrada->setIdconfiguracion($usuario->getConfiguracion()->getIdconfiguracion());
                $entrada->setRegistro($rg);
                if($request->getParameter("motivo")){
                    $entrada->setIdmotivo($request->getParameter("motivo"));
                }
                $entrada->save();
                
                $horas= (Asistencia::contarHoras(date("H:i:s",(strtotime($usuario->getConfiguracion()->getHoraentrada()))),date("H:i:s",(strtotime($usuario->getConfiguracion()->getHorasalida()))))/60);
                $horas_usuario = (Asistencia::contarHoras(date("H:i:s",(strtotime($request->getParameter("hora_entrada")))),date("H:i:s",(strtotime($request->getParameter("hora_salida")))))/60);
                $salida = new Movimiento();
                $salida->setIdusuario($request->getParameter("idusuario"));
                $salida->setFecha($request->getParameter("fecha")." ".date("H:i:s",(strtotime($request->getParameter("hora_salida")))));
                $salida->setEstado("REGISTRADO");
                $salida->setIpsede($servidor);
                $salida->setIpusuario($ip);
                $salida->setMovimiento("S");
                $salida->setIdconfiguracion($usuario->getConfiguracion()->getIdconfiguracion());
                $salida->setRegistro(($rg == "RETRASADO")?"ADELANTADO":$rg);
                if($request->getParameter("motivo")){
                    $salida->setIdmotivo($request->getParameter("motivo"));
                }
                $salida->save(); 
                return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"movimiento guardado!")));
          }
        return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"registro no valido")));
      }else{
        return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"registro no valido")));
      }
   return $this->renderText(json_encode(array("valido"=>false,"mensaje"=>"No fue posible registrar el movimiento")));
  }
  



  public function executeReporte(sfWebRequest $request){
      switch ($request->getParameter("reporte")):
          case "general":
              $this->setTemplate("general");
          break; 
          case "especifico":
              $this->form = new MovimientoForm();
              $this->ls_tipo_personal = Doctrine_Core::getTable("TipoEmpleado")->listarTipoEmpleadoSelect();
              $this->setTemplate("especifico");
          break; 
          case "permisos":
              $this->form = new MovimientoForm();
              $this->setTemplate("permisos");
          break; 
          case "horas_extras":
              $this->ls_departamento = Doctrine_Core::getTable("Departamento")->buscarDepartamentoPorCoordinador($request->getParameter("id"));
              $this->ls_tipo_personal = Doctrine_Core::getTable("TipoEmpleado")->listarTipoEmpleadoSelect();
              $this->ls_turno = Doctrine_Core::getTable("Configuracion")->listarConfiguracionSelect();
              $this->setTemplate("horas_extras");
          break;    
      endswitch;
  }
  
  
  public function executeRpp_especifico(sfWebRequest $request){
//      foreach($request->getParameter("movimiento") as $variable => $valor):
//         /* if($variable == "fecha_desde" || $variable == "fecha_hasta" ){
//              $valor = Asistencia::cambiarFormatoFechaMDA($valor,"/");
//          }*/
//          $request->setParameter($variable,($variable)?$valor:null);
//      endforeach;
  
    sfTCPDFPluginConfigHandler::loadConfig('asistencia');
    sfTCPDFPluginConfigHandler::includeLangFile($this->getUser()->getCulture());
    $pdf = new sfTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

    // Informacion del ducumento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(PDF_AUTHOR);
    $pdf->SetTitle("Reporte especifico de personal");
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

    //Asignacion de margenes
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    //asignacion de fin de pagina
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //Factor de imagen 
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  
       //Inicializacion de documento
    $pdf->AliasNbPages();
            if($request->getParameter("empleados") == 0){
                $usuarios = Doctrine_Core::getTable("Usuario")->traerUsuarioPorTipo($request->getParameter("comboDepartamentos"),$request->getParameter("tipo_personal"));
                foreach($usuarios as $usuario):
                    $movimientos = Doctrine_Core::getTable("Movimiento")->movimientoUsuario($usuario->getIdusuario(),$request->getParameter("departamentos"),null,null,$request->getParameter("fecha_desde"),$request->getParameter("fecha_hasta"));
            //       print $movimientos->getSqlQuery()."<br>";
                    $movimientos_cantidad  = $movimientos->count();
                    if($movimientos_cantidad){
                        if(is_numeric($usuario->getIdusuario())){
                                    $pdf->AddPage();
                                    $pdf->writeHTML($this->getPartial("reporte/especifico",
                                        array("movimiento"=>$movimientos->fetchArray(),
                                            "fecha_desde"=>$request->getParameter("fecha_desde"),
                                            "fecha_hasta"=>$request->getParameter("fecha_hasta")/*,"sql"=>$movimientos->getSqlQuery()*/)), true, 0, true, 0);
                        }else{
                                $cedula = "";//fetchArray
                                foreach($movimientos->fetchArray() as $indice => $registro):
                                    if($registro["Usuario"]["cedula"] != $cedula){
                                        if($indice){
                                            $pdf->AddPage();
                                            $pdf->writeHTML($this->getPartial("reporte/especifico",
                                                    array("movimiento"=>$data,
                                                        "fecha_desde"=>$request->getParameter("fecha_desde"),
                                                        "fecha_hasta"=>$request->getParameter("fecha_hasta"))), true, 0, true, 0);
                                            $data = null;
                                            $data[] =$registro;
                                        }else{
                                            $data[] =$registro;
                                        }
                                    }else{
                                            $data[] =$registro;
                                    }
                                        $cedula = $registro["Usuario"]["cedula"];
                                endforeach;
                                if(!is_null($data)):
                                    $pdf->AddPage();
                                    $pdf->writeHTML($this->getPartial("reporte/especifico",
                                        array("movimiento"=>$data,
                                            "fecha_desde"=>$request->getParameter("fecha_desde"),
                                            "fecha_hasta"=>$request->getParameter("fecha_hasta")
                                            )
                                        ), true, 0, true, 0);
                                endif;
                        }
                            
                    }
                endforeach;
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->Output("reporte especifico.pdf");
            }else{
                $movimientos = Doctrine_Core::getTable("Movimiento")->movimientoUsuario($request->getParameter("empleados"),$request->getParameter("departamentos"),null,null,$request->getParameter("fecha_desde"),$request->getParameter("fecha_hasta"));
        //       print $movimientos->getSqlQuery()."<br>";
                $movimientos_cantidad  = $movimientos->count();
                if($movimientos_cantidad){
                    if(is_numeric($request->getParameter("empleados"))){
                                $pdf->AddPage();
                                $pdf->writeHTML($this->getPartial("reporte/especifico",
                                    array("movimiento"=>$movimientos->fetchArray(),
                                        "fecha_desde"=>$request->getParameter("fecha_desde"),
                                        "fecha_hasta"=>$request->getParameter("fecha_hasta")/*,"sql"=>$movimientos->getSqlQuery()*/)), true, 0, true, 0);
                    }else{
                            $cedula = "";//fetchArray
                            foreach($movimientos->fetchArray() as $indice => $registro):
                                if($registro["Usuario"]["cedula"] != $cedula){
                                    if($indice){
                                        $pdf->AddPage();
                                        $pdf->writeHTML($this->getPartial("reporte/especifico",
                                                array("movimiento"=>$data,
                                                    "fecha_desde"=>$request->getParameter("fecha_desde"),
                                                    "fecha_hasta"=>$request->getParameter("fecha_hasta"))), true, 0, true, 0);
                                        $data = null;
                                        $data[] =$registro;
                                    }else{
                                        $data[] =$registro;
                                    }
                                }else{
                                        $data[] =$registro;
                                }
                                    $cedula = $registro["Usuario"]["cedula"];
                            endforeach;
                            if(!is_null($data)):
                                $pdf->AddPage();
                                $pdf->writeHTML($this->getPartial("reporte/especifico",
                                    array("movimiento"=>$data,
                                        "fecha_desde"=>$request->getParameter("fecha_desde"),
                                        "fecha_hasta"=>$request->getParameter("fecha_hasta")
                                        )
                                    ), true, 0, true, 0);
                            endif; 
                    }
                        $pdf->setPrintHeader(false);
                        $pdf->setPrintFooter(false);
                        $pdf->Output("reporte especifico.pdf");
                } else{
                        return $this->renderText("<script type='text/javascript'>
                                            alert('no hay datos para el reporte seleccionado');
                                            history.back()
                                            </script>");
                }
            }
  }
  
  public function executeRpp_he(sfWebRequest $request){
        sfTCPDFPluginConfigHandler::loadConfig('asistencia');
        sfTCPDFPluginConfigHandler::includeLangFile($this->getUser()->getCulture());
        $pdf = new sfTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

        // Informacion del ducumento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(PDF_AUTHOR);
        $pdf->SetTitle("Reporte especifico de personal");
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

        //Asignacion de margenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        //asignacion de fin de pagina
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //Factor de imagen 
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        //Inicializacion de documento
        $pdf->AliasNbPages();
      /*  $this->ls_departamento = Doctrine_Core::getTable("Departamento")->listarDepartamentosSelect();
        $this->ls_tipo_personal = Doctrine_Core::getTable("TipoEmpleado")->listarTipoEmpleadoSelect();
        $this->ls_turno = Doctrine_Core::getTable("Configuracion")->listarConfiguracionSelect();
        $this->setTemplate("horas_extras");*/
          $movimientos = Doctrine_Core::getTable("Movimiento")->movimientoUsuario(null,$request->getParameter("departamento"),$request->getParameter("tipo_personal"),$request->getParameter("turno"),$request->getParameter("fecha_desde"),$request->getParameter("fecha_hasta"));
          $movimientos_cantidad  = $movimientos->count();
          if($movimientos_cantidad){
               $cedula = "";//fetchArray
               foreach($movimientos->fetchArray() as $indice => $registro):  
                    if($registro["Usuario"]["cedula"] != $cedula){
                         if($indice){
                              $pdf->AddPage();
                              $pdf->writeHTML($this->getPartial("reporte/horas_extras",array(
                                        "movimiento"=>$data,"sql"=>$movimientos->getSqlQuery(),
                                        "fecha_desde"=>$request->getParameter("fecha_desde"),
                                        "fecha_hasta"=>$request->getParameter("fecha_hasta")
                                      //  ,"sql"=>$movimientos->getSqlQuery()
                                        )));
                              $data = null;
                              $data[] =$registro;
                         }else{
                              $data[] =$registro;
                         }
                    }else{
                              $data[] =$registro;
                    }
                         $cedula = $registro["Usuario"]["cedula"];
               endforeach;
                    if(!is_null($data)):
                              $pdf->AddPage();
                              $pdf->writeHTML($this->getPartial("reporte/horas_extras",array(
                                        "movimiento"=>$data, ///*,"sql"=>$movimientos->getSqlQuery()*/
                                        "fecha_desde"=>$request->getParameter("fecha_desde"),
                                        "fecha_hasta"=>$request->getParameter("fecha_hasta"),
                                       // "sql"=>$movimientos->getSqlQuery()
                                        )));
                    endif; 
                 $pdf->setPrintHeader(false);
                 $pdf->setPrintFooter(false);
                 $pdf->Output("reporte de horas extras.pdf");
          } else{
                 return $this->renderText("<script type='text/javascript'>
                                     alert('no hay datos para el reporte seleccionado');
                                     history.back()
                                     </script>");
          }


  }
  
  
  public function executeEliminar_movimiento(sfWebRequest $request){
         $resultado = array("valido"=>false,"mensaje"=>"No fue posible registrar el movimiento");
               if($request->getParameter("entrada_id") && $request->getParameter("movimiento")=="entrada"){
                    $movimiento = Doctrine_Core::getTable('Movimiento')->findOneByIdmovimiento(array($request->getParameter("entrada_id")));
                    if($movimiento->count()){
                         $movimiento_entrada = Doctrine_Core::getTable('Movimiento')->movimientosUsuario($movimiento->getIdusuario(),Asistencia::cambiarFormatoFecha($request->getParameter("fecha"),"/"),"S");
                         if($movimiento_entrada->count()){
                              $movimiento_entrada->delete();
                              $movimiento->delete();
                              $resultado = array("valido"=>true,"mensaje"=>"La entrada fue eliminada satisfactoriamente");
                         }else{
                              $movimiento->delete();
                              $resultado = array("valido"=>true,"mensaje"=>"La entrada fue eliminada satisfactoriamente");   
                         }
                    }else{
                              $resultado = array("valido"=>false,"mensaje"=>"El movimiento de entrada no fue encontrado"); 
                    }
               }else if($request->getParameter("salida_id") && $request->getParameter("movimiento")=="salida"){
                    $movimiento = Doctrine_Core::getTable('Movimiento')->findOneByIdmovimiento(array($request->getParameter("salida_id")));
                    if($movimiento->count()){
                              $movimiento->delete();
                              $resultado = array("valido"=>true,"mensaje"=>"La salida fue eliminada satisfactoriamente");
                    }else{
                              $resultado = array("valido"=>false,"mensaje"=>"El movimiento de salida no fue encontrado"); 
                    }    
               }
    return $this->renderText(json_encode($resultado));
  }
  
  public function executeSelect_departamento(sfWebRequest $request){
      return $this->renderText(json_encode(Doctrine_Core::getTable("Usuario")->listaUsuariosSelect($request->getParameter("departamento"),array("null"=>"--- TODOS ---"))));
  }
  public function executeSelect_departamento2(sfWebRequest $request){
      return $this->renderText(json_encode(Doctrine_Core::getTable("Usuario")->listaUsuariosSelect1($request->getParameter("departamento"),array("null"=>"--- TODOS ---"))));
  }
  public function executeAsignar_turno(){
      $this->ls_turnos = Doctrine_Core::getTable("Configuracion")->listarConfiguracionSelect();
      $this->ls_departamento = Doctrine_Core::getTable("Departamento")->listarDepartamentosSelect();
      
  }
  
  public function executeGuardar_turno(sfWebRequest $request){
      $empleados = $request->getParameter("check_empleado");
      if($empleados){
          $actualizar = Doctrine_Core::getTable("Usuario")->actualizarTurno($empleados,$request->getParameter("turno"));
          if($actualizar){
            return $this->renderText(json_encode("Actualizacion de turno exitosa"));
          }
      }
      return $this->renderText(json_encode("Error intentando Actualizar el turno"));
  }
  
  
   public function executeRpp_permisos(sfWebRequest $request){

  
  sfTCPDFPluginConfigHandler::loadConfig('asistencia');
  sfTCPDFPluginConfigHandler::includeLangFile($this->getUser()->getCulture());
  $pdf = new sfTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
 
  // Informacion del ducumento
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor(PDF_AUTHOR);
  $pdf->SetTitle("Reporte Permisos Cargados al  personal");
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
 
  //Asignacion de margenes
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
 
  //asignacion de fin de pagina
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //Factor de imagen 
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  
       //Inicializacion de documento
       $pdf->AliasNbPages();
          $movimientos = Doctrine_Core::getTable("Permiso")->getPermisoSecretaria($request->getParameter("secretaria"),$request->getParameter("fecha_desde"),$request->getParameter("fecha_hasta"));
          //print $movimientos->getSqlQuery()."<br>";
          $movimientos_cantidad  = $movimientos->count();
          if($movimientos_cantidad){
               if(is_numeric($request->getParameter("secretaria"))){
                         $pdf->AddPage();
                         $pdf->writeHTML($this->getPartial("reporte/permisos",
                              array("movimiento"=>$movimientos->fetchArray(),
                                   "fecha_desde"=>$request->getParameter("fecha_desde"),
                                   "fecha_hasta"=>$request->getParameter("fecha_hasta"))), true, 0, true, 0);
               }else{
                    $cedula = "";//fetchArray
                    foreach($movimientos->fetchArray() as $indice => $registro):
                         if($registro["Usuario"]["cedula"] != $cedula){
                              if($indice){
                                   $pdf->AddPage();
                                   $pdf->writeHTML($this->getPartial("reporte/permisos",
                                        array("movimiento"=>$data,
                                           //array("movimiento"=>$fetchArray(),
                                             "fecha_desde"=>$request->getParameter("fecha_desde"),
                                             "fecha_hasta"=>$request->getParameter("fecha_hasta"))), true, 0, true, 0);
                                   $data = null;
                                   $data[] =$registro;
                                   //$movimiento[]=$registro;
                              }else{
                                  //$movimiento[]=$registro;
                                   $data[] =$registro;
                              }
                         }else{
                             //$movimiento[]=$registro;
                                   $data[] =$registro;
                         }
                              $cedula = $registro["Usuario"]["cedula"];
                                //$cedula[]=$registro["Usuario"]["cedula"]; 
                    endforeach;
                    if(!is_null($data)):
                       //if(!is_null($movimiento)):
                         $pdf->AddPage();
                         $pdf->writeHTML($this->getPartial("reporte/permisos",
                              array("movimiento"=>$data,
                                          // array("movimiento"=>$fetchArray(),
                                   "fecha_desde"=>$request->getParameter("fecha_desde"),
                                   "fecha_hasta"=>$request->getParameter("fecha_hasta")
                                   )
                              ), true, 0, true, 0);
                    endif; 
               }
                 $pdf->setPrintHeader(false);
                 $pdf->setPrintFooter(false);
                 $pdf->Output("reporte permisos.pdf");
          } else{
                 return $this->renderText("<script type='text/javascript'>
                                     alert('no hay datos para el reporte seleccionado');
                                     history.back()
                                     </script>");
          }






  }
  
  
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $movimiento = $form->save();
      $this->redirect('movimiento/edit?idmovimiento='.$movimiento->getIdmovimiento());
    }
  }
}
