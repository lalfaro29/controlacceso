<?php

/**
 * principal actions.
 *
 * @package    asistencia
 * @subpackage principal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class principalActions extends sfActions{



	public function executeIndex(sfWebRequest $request){
        /*  $movimientos = Doctrine_Core::getTable("Movimiento")->movimientoUsuario(null,86,10,12,"01/06/2012","13/06/2012");
          $cedula="";
          foreach($movimientos->fetchArray() as $indice => $registro):  
               if($registro["Usuario"]["cedula"] != $cedula){
                    if($indice){
                         print print_r($data)."<br><br>";
                         $data = null;
                    }else{
                         $data[] =$registro;
                    }
               }else{
                         $data[] =$registro;
               }
                    $cedula = $registro["Usuario"]["cedula"];
          endforeach;
*/
	  
	  
          $respuesta= array("valido"=>false,"mensaje"=>"Usuario invalido");
            if($request->getParameter("cedula") && $request->getParameter("cedula") !==""){
			  $ip = $_SERVER['REMOTE_ADDR'];
			  $arregloIp = explode(".",$ip);
//				
//			  if($arregloIp[2] == 20){
//			  	if (!in_array($ip, array('10.90.20.24'))){
//					return $this->renderText(json_encode(array("valido"=>true,"mensaje"=>"Debe registrarse en la maquina de la entrada")));
//				}
//			  }
                    $this->usuario = Doctrine_Core::getTable('Usuario')->registrar($request->getParameter("cedula"));
			if(isset($this->usuario->activo)){
				if($this->usuario->getIddepartamento()==274 && !in_array($ip, array('10.90.27.153'))){
					return $this->renderText(json_encode(array(
				    	"valido"=>true,
				    	"mensaje"=>"ingrese su entrada/salida en la máquina que está ubicada en la entrada de su oficina."
					)));
				}
			}
                    if(isset($this->usuario->activo)){
                            $respuesta = $this->registroMovimiento();
                    }
                    return $this->renderText(json_encode($respuesta));
            }
	}



	public function executeInicio_sesion(){}

	public function executeValidar_sesion(sfWebRequest $request){
		$usuario =  Doctrine_Core::getTable('Usuario')->validar_sesion($request->getParameter("usuario"),$request->getParameter("clave"));
	        $clave = md5($request->getParameter("clave"));
                if($usuario->count()){
			$this->getUser()->setAuthenticated(true);
    			$this->getUser()->agregarDatosBasicos($usuario->fetchOne());
			return $this->renderText(json_encode(array(
				"valido"=> true
			)));
		}else{
			return $this->renderText(json_encode(array(
				"valido"=> false,
                                "clave"=> $clave,
				"mensaje"=>"usuario/clave invalida"
			)));
		}
	}

	public function executeCerrar_sesion(sfWebRequest $request){    
		$this->getUser()->setAuthenticated(false);
		$this->getUser()->getAttributeHolder()->clear();
		return $this->renderText(json_encode(array("valido"=> true)));
	}

	public function executeMensajes(sfWebRequest $request){
		$this->tipo_mensaje = $request->getParameter("tipo_mensaje");
		$this->ventana = $request->getParameter("ventana");
		if($this->tipo_mensaje=="adelantado" || $this->tipo_mensaje=="retraso"){
			$this->motivos = Doctrine_Core::getTable('Motivo')->listar();
		}
	}

	public function executeRegistrar_salida(sfWebRequest $request){
		$this->usuario = Doctrine_Core::getTable('Usuario')->registrar($request->getParameter("cedula"));
		return $this->renderText(json_encode($this->registroMovimiento(true)));
	}

	public function executeRegistrar_retraso(sfWebRequest $request){
			if(is_numeric($this->getUser()->get_variable("movimiento_id")) && $request->getParameter("motivo_id")!=""){
				$movimiento = Doctrine_Core::getTable('Movimiento')->findOneByIdmovimiento($this->getUser()->get_variable("movimiento_id"));
                                if($movimiento->count()){
                                    $movimiento->setIdmotivo($request->getParameter("motivo_id"));
                                    $movimiento->save();
                                    return $this->renderText(json_encode(array("mensaje"=>"Entrada registrada")));
                                }else{
                                    return $this->renderText(json_encode(array("mensaje"=>"No se pudo registrar el motivo del retraso.")));  
                                }
			}else{
				return $this->renderText(json_encode(array("mensaje"=>"No se pudo registrar el motivo del retraso.")));
			}
	}

	public function executeRegistrar_adelanto(sfWebRequest $request){
			if(is_numeric($this->getUser()->get_variable("movimiento_id")) && $request->getParameter("motivo_id")!=""){
				$movimiento = Doctrine_Core::getTable('Movimiento')->findOneByIdmovimiento($this->getUser()->get_variable("movimiento_id"));
                                if($movimiento->count()){
                                    $movimiento->setIdmotivo($request->getParameter("motivo_id"));
                                    $movimiento->save();
                                    return $this->renderText(json_encode(array("mensaje"=>"Salida registrada")));
                                }else{
                                    return $this->renderText(json_encode(array("mensaje"=>"No se pudo registrar el motivo de la saida adelantada.")));  
                                }
			}else{
				return $this->renderText(json_encode(array("mensaje"=>"No se pudo registrar el motivo de la saida adelantada.")));
			}
	}

	protected function registroMovimiento($registrarSalida = false){
		//variable donde se va a dar respuesta
		$respuesta = array();
		//variable que contiene la consulta de los movimientos del usuario del dia 
		$movimiento = Doctrine_Core::getTable('Movimiento')->movimientosUsuario($this->usuario->getIdusuario(),date('d-m-Y'))->execute();
		//variable que contiene la cantidad de registros de la consulta de la linea anterior
		$cantidad_movimiento = $movimiento->count();
		//variable que contiene la lista de los dias feriados 
		$feriado = $this->usuario->configuracion()->feriados(date('m-d'));
		$feriado = ($feriado->count())?true: false;
		$finSemana = date("D");
		$finSemana = ($finSemana=="Sat" || $finSemana=="Sun")?true: false;
		if(!($cantidad_movimiento)){
                        //$this->cerrar_dia_anterior($movimiento,$cantidad_movimiento);
                        $this->finalizar_dia_anterior(date("d-m-Y"));
			$configuracion = $this->usuario->getConfiguracion();
			if($feriado){
				$mv = $this->registrar('E','MANUAL','DIA FERIADO',date('Y-m-d H:i:s'));
				$respuesta = array("valido"=>true,"mensaje"=>"Entrada registrada");
			}else if($finSemana){
				$mv = $this->registrar('E','MANUAL','FIN DE SEMANA',date('Y-m-d H:i:s'));
				$respuesta = array("valido"=>true,"mensaje"=>"Entrada registrada");
			}else{
				
				$permisos = 	Doctrine_Core::getTable('Permiso')->getPermisoUsuario($this->usuario->getIdusuario(),date('Y-m-d'));
				$cantidad_permisos = $permisos->count();
				$horas_permiso = ($cantidad_permisos)?$permisos->fetchOne()->getHoras():false;
				if($horas_permiso){
					$horas = Asistencia::comparar_horas(Asistencia::modificar_hora($configuracion->getHoraentrada(),((INT)$configuracion->getHoramaxentrada()+$horas_permiso)),date("H:i:s a"));
					if(($horas < 0)){
						$this->getUser()->registrar_variable("fecha_entrada",date('Y-m-d H:i:s'));
						$this->getUser()->registrar_variable("fecha_entrada_sistema",$configuracion->getHoraentrada());
						$mv = $this->registrar('E','MANUAL','RETRASADO',$this->getUser()->get_variable("fecha_entrada"));
						$this->getUser()->registrar_variable("movimiento_id",$mv->getIdmovimiento());
						$this->getUser()->registrar_variable("usuario_id",$mv->getIdusuario());
						$respuesta = array("valido"=>false,"tipo_dato"=>"retrasado");
					}else{
						$mv = $this->registrar('E','MANUAL','PUNTUAL',date('Y-m-d H:i:s'));
						$respuesta = array("valido"=>true,"mensaje"=>"Entrada registrada");
					}			
				}else if(!$horas_permiso && $cantidad_permisos){
						$mv = $this->registrar('E','MANUAL','PUNTUAL',date('Y-m-d H:i:s'));
						$respuesta = array("valido"=>true,"mensaje"=>"Entrada registrada");
				}else{
					$horas = Asistencia::comparar_horas(Asistencia::modificar_hora($configuracion->getHoraentrada(),(INT)$configuracion->getHoramaxentrada()),date("H:i:s"));		
					if(($horas < 0)){
						$this->getUser()->registrar_variable("fecha_entrada",date('Y-m-d H:i:s'));
						$this->getUser()->registrar_variable("fecha_entrada_sistema",$configuracion->getHoraentrada());
						$mv = $this->registrar('E','MANUAL','RETRASADO',$this->getUser()->get_variable("fecha_entrada"));
						$this->getUser()->registrar_variable("movimiento_id",$mv->getIdmovimiento());
						$this->getUser()->registrar_variable("usuario_id",$mv->getIdusuario());
						$respuesta = array("valido"=>false,"tipo_dato"=>"retrasado");
					}else{
						$mv = $this->registrar('E','MANUAL','PUNTUAL',date('Y-m-d H:i:s'));
						$respuesta = array("valido"=>true,"mensaje"=>"Entrada registrada");
					}
				}
			}
		}elseif($cantidad_movimiento===1){
			 if(!Asistencia::comparar_fechas($movimiento[0]->getFecha(),date("d-m-Y H:i:s"))){
				$configuracion = $this->usuario->getConfiguracion();
				$this->salida('S','--','');
				if($feriado){
					$mv = $this->registrar('S','MANUAL','DIA FERIADO');
				}else if($finSemana){
					$mv = $this->registrar('S','MANUAL',"FIN DE SEMANA");
				}else{
					if((($this->getUser()->get_variable("jornada_laboral") < 100) && $registrarSalida==false)){
						$respuesta = array("valido"=> false,"tipo_dato"=>"jornada_completa");		
					}elseif((($this->getUser()->get_variable("jornada_laboral") < 100) && $registrarSalida==true)){
						$this->getUser()->registrar_variable("apellido",$this->usuario->getApellido());
						$this->getUser()->registrar_variable("nombre",$this->usuario->getNombre());
						$mv = $this->registrar('S','MANUAL','ADELANTADO');
						$this->getUser()->registrar_variable("movimiento_id",$mv->getIdmovimiento());
						$respuesta = array("valido"=>false,"tipo_dato"=>"adelantado");
					}elseif($this->getUser()->get_variable("jornada_laboral") >= 100){
					     $mv = $this->registrar('S','MANUAL',"----------");
                              $salida_horas =  "\n Sr(a) ".$this->usuario->getApellido()." ".$this->usuario->getNombre();
                              $salida_horas .= "\nHora de entrada: ".date("h:i a",(strtotime($this->getUser()->get_variable("fecha_hora_entrada"))));
                              $salida_horas .= "\nHora de salida: ".date("h:i a",(strtotime($this->getUser()->get_variable("fecha_hora_salida"))));
                            //  $salida_horas .= "\nTotal de Horas: ".Asistencia::contarHoras(date("H:i:s",(strtotime($this->getUser()->get_variable("fecha_hora_entrada")))),date("H:i:s",(strtotime($this->getUser()->get_variable("fecha_hora_salida")))));
						$respuesta = array("valido"=>true,"mensaje"=>"Salida registrada".$salida_horas);
					}
				}			
			}
		}else if($cantidad_movimiento > 1){
			$respuesta = array('valido'=>true,'mensaje'=>'Ya registro la entrada y salida del dia');
		}
		return $respuesta;
	}

	protected function registrar($mov,$estado,$registro,$fecha=false){
		$ip=        @$_SERVER['REMOTE_ADDR'];
		$servidor=  @$_SERVER['SERVER_ADDR'];
		$fecha = ($fecha)?$fecha:date('Y-m-d H:i:s');
		$mv = new Movimiento();
		$mv->setIdusuario($this->usuario->getIdusuario());
		$mv->setFecha($fecha);
		$mv->setMovimiento($mov);
		$mv->setEstado($estado);
		$mv->setRegistro($registro);
		$mv->setIpsede($servidor);
		$mv->setIpusuario($ip);
		$mv->setIdconfiguracion($this->usuario->getIdConfiguracion());
		$mv->save();
		return $mv;
			//"Sr(a) ".$this->usuario->getApellido()." ".$this->usuario->getNombre()
	}

	protected function salida(){
		//toma los datos de los dos ultimos movimientos del usuario
		$movimiento = Doctrine_Core::getTable('Movimiento')->movimientosUsuario($this->usuario->getIdusuario(),date("d-m-Y"),"E")->execute();
		//registro la hora de salida en una variable de sesion
		$temp = date("Y-m-d H:i:s");
		$this->getUser()->registrar_variable("fecha_hora_salida",$temp);
		//registro la hora de entrada en una variable de sesion
		$this->getUser()->registrar_variable("fecha_hora_entrada",$movimiento[0]->getFecha());
		//toma la consulta de la configuracion del usuario 
		$configuracion = $this->usuario->getConfiguracion();
		//suma el total de horas trabajadas
	        $horas= (Asistencia::contarHoras(date("H:i:s",(strtotime($this->getUser()->get_variable("fecha_hora_entrada")))),date("H:i:s",(strtotime($this->getUser()->get_variable("fecha_hora_salida")))))/60);
		//total de la jornada laboral aplicable para el empleado
		$horas_jornada = (Asistencia::contarHoras($configuracion->getHoraentrada(),$configuracion->getHorasalida())/60);
		//registra en una variable de sesion el total de horas trabajadas en porcentajes y las guarda en una variable de sesion
		$this->getUser()->registrar_variable("jornada_laboral",  Asistencia::porcentajeTrabajado($horas,$horas_jornada));
	}

        protected function cerrar_dia_anterior($movimiento,$cantidad_movimiento){
                if(($cantidad_movimiento) == 1){
                    if(Asistencia::comparar_fechas($movimiento[0]->getFecha(),date("d-m-Y H:i:s")) && $movimiento[0]->getMovimiento() =="E"){
                        /* $m = */$this->registrar('S','AUTOMATICO','AUTOMATICO',$movimiento[0]->getFecha());
                    }
                }elseif(($cantidad_movimiento) == 2){
                    if((Asistencia::comparar_fechas($movimiento[0]->getFecha(),$movimiento[1]->getFecha())) && $movimiento[1]->getMovimiento() == "E"){
                        /* $m = */$this->registrar('S','AUTOMATICO','AUTOMATICO',$movimiento[1]->getFecha());
                    }
                }
        }
        
        protected function finalizar_dia_anterior($fecha){
            list($dia,$mes,$ano)=explode("-",$fecha);
            $dia= date("w",mktime(0, 0, 0, $mes, $dia, $ano));
            
            if($dia == 1){
                //aqui entro en caso de que sea lunes y resto 3 dias para pararme en la fecha del viernes
                $sol = (strtotime($fecha) - (3*3600));
            }else{
                //cualquier otro dia diferente de lunes y resto 1 dia para pararme en el dia anterior
                $sol = (strtotime($fecha) - 3600);
            }
            
            //convertimos la resta en una fecha
            $fecha = date('d-m-Y', $sol);
            
            //hacemos select de los movimientos del dia anterior
            $movimientoAnterior = Doctrine_Core::getTable('Movimiento')->movimientosUsuario($this->usuario->getIdusuario(),date('d-m-Y', $sol))->execute();
            //variable que contiene la cantidad de movimientos del dia anterior
            $cantidad_movimiento = $movimientoAnterior->count();
            
            //si tiene 1 solo movimiento quiere decir que solo ingreso la entrada asi que agregamos la salida de forma automatica
            if($movimientoAnterior->count() && $cantidad_movimiento == 1){
                //sumamos 1 minuto mas a la fecha/hora de entrada
                $sol2 = (strtotime($movimientoAnterior[0]->getFecha()) + 60);
                //convertimos la suma en una fecha
                $fecha2 = date('d-m-Y H:i:s', $sol2);
                //insertamos el registro de salida con 1 minuto mas a la hora de entrada
                $this->registrar('S','AUTOMATICO','AUTOMATICO',$fecha2);
            }
        }

}








