<?php

/**
 * UsuarioTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UsuarioTable extends PluginUsuarioTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object UsuarioTable
     */
	public static function getInstance(){
		return Doctrine_Core::getTable('Usuario');
	}

	public function registrar($cedula){
		return   Doctrine_Query::create()
			->from('Usuario u')
			->andWhere('u.cedula = ?',$cedula)
			->andWhere("u.activo = ?","S")
			->fetchOne();
	}

	public function validar_sesion($usuario,$clave){
		return Doctrine_Query::create()
                        ->from('Usuario u')
                        ->leftJoin("u.Cargo c")
                        ->leftJoin("u.Departamento d")
			->leftJoin("u.UsuarioSistema us")
			->leftJoin('us.TipoUsuario tu')
                        ->leftJoin("u.Sede s")
			->andWhere("u.cedula= ?",$usuario)
			->andWhere("us.psw= ?",md5($clave))
			->andWhere("us.idUsuario=u.idusuario")
			->andWhere("tu.idTipoUsuario=us.idTipoUsuario")
			->andWhere("s.idSede=u.idSede")
			->andWhere("u.activo = ?","S");
	}

        public function buscarUsuarios($buscar=null,$campo="u.nombre",$ordenar="ASC",$usuario_id=null,$departamento_id=null){
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->leftJoin("u.Cargo c")
                        ->leftJoin("u.Departamento d")
			->leftJoin("u.UsuarioSistema us")
			->leftJoin('us.TipoUsuario ti')
                        ->leftJoin("u.Sede s")
                        ->leftJoin("u.Configuracion co");
                if(!is_null($usuario_id) && $usuario_id && $usuario_id!="null"){
                     $q->andWhere("u.idusuario = ? ",$usuario_id);
                }
		if(!is_null($buscar) && $buscar){
			$buscar = explode(" ",$buscar);
                        if(is_array($buscar)){
                            foreach($buscar as $palabra){
                                    $palabra = strtoupper($palabra);
                                    $q->andWhere("( nombre LIKE '%".$palabra."%'");
                                    $q->orWhere("u.apellido LIKE '%".$palabra."%'");
                                    $q->orWhere("u.cedula LIKE '%".$palabra."%'");
                                    $q->orWhere("c.cargo LIKE '%".$palabra."%'");
                                    $q->orWhere("s.sede LIKE '%".$palabra."%'");
                                    $q->orWhere("d.departamento LIKE '%".$palabra."%' )");
                            } 
                        }
		}
                if(!is_null($departamento_id) && $departamento_id && $departamento_id !="null"){
                     $q->andWhere("u.iddepartamento = ? ",$departamento_id);
                }
                
		$q->andWhere("u.activo='S'");
                if($campo && $ordenar){
                    $q->orderBy("$campo $ordenar");
                }
		return $q->execute();
        }
    
	public function buscarUsuarioJson($data){
                $check=$data->getParameter("seleccion",false);
                $campo="u.apellido,u.nombre";
                $pos = ($check)?1:0;
                switch($data->getParameter("iSortCol_0")):
                     case $pos:
                         $campo="u.apellido,u.nombre";
                     break;
                     case $pos+1:
                         $campo="u.cedula";
                     break;
                     case $pos+2:
                         $campo="c.cargo";
                     break;
                     case $pos+3:
                         $campo="d.departamento";
                     break; 
                     case $pos+4:
                         $campo="s.sede";
                     break;   
                endswitch;
                $datos = $this->buscarUsuarios($data->getParameter("sSearch",false),$campo,$data->getParameter("sSortDir_0"),null,$data->getParameter("departamento_id",null));
		$resultados = array();
                $js_funcion=$data->getParameter("funcion",'empleado_seleccionar');
                $js_turno=$data->getParameter("turno",false);
		foreach($datos as $campo => $usuario):
			if($check){
                           $resultados [$campo][] = "<input type=\"checkbox\" name=\"check_empleado[]\" id=\"check_empleado[]\" value=\"".$usuario->getIdusuario()."\" >";
                           $resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getApellido()." ".$usuario->getNombre(),30);
                        }else{
                            $js_empleado = "\"".$usuario->getIdusuario()."\",".
                                        "\"".$usuario->getNombre()."\"".",\"".$usuario->getApellido()."\",".
                                        "\"".$usuario->getCedula()."\"".",\"".$usuario->getIdtipoempleado()."\",".
                                        "\"".$usuario->getIdcargo()."\"".",\"".$usuario->getIddepartamento()."\",".
                                        "\"".$usuario->getSueldo()."\"".",\"".$usuario->getIdsede()."\",".
                                        "\"".date("d/m/Y",(strtotime($usuario->getFechaingreso())))."\"".",\"".$usuario->getIdproyecto()."\",".
                                        "\"".$usuario->getIdconfiguracion()."\"".",\"".$usuario->getIpusuario()."\",".
                                        "\"".(($usuario->UsuarioSistema())?$usuario->UsuarioSistema()->getIdtipousuario().
                                        "\","."\"".$usuario->UsuarioSistema()->getIdusuariosistema():"null,null")."\"";
                           $resultados [$campo][] = "<div class='seleccion_campo' style='cursor:pointer' onclick='".$js_funcion."(".$js_empleado.")'>".Asistencia::limitar_caracteres($usuario->getApellido()." ".$usuario->getNombre(),30)."</div>"; 
                        }
                        
			$resultados [$campo][] =$usuario->getCedula();
			$resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getCargo()->getCargo(),30);
			$resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getDepartamento()->getdepartamento(),35);
			$resultados [$campo][] =Asistencia::limitar_caracteres((($js_turno)?date("h:i a",(strtotime($usuario->getConfiguracion()->getHoraentrada())))." a ".date("h:i a",(strtotime($usuario->getConfiguracion()->getHorasalida()))):$usuario->getSede()->getSede()),35).
                                                "<input type=\"hidden\" id=\"usuario_id\" name=\"usuario_id\" value=\"".$usuario->getIdUsuario()."\" >";
		endforeach;
		return $resultados;

	}

        public function actualizarTurno($empleado,$turno){
            $bandera = true;
            if(is_numeric($turno)){
                $update = Doctrine_Query::create()
                        ->update('Usuario u')
                        ->set('u.idconfiguracion', '?', $turno);
                if(is_array($empleado)){
                    $update->whereIn('u.idusuario',$empleado)->execute();
                }else if(is_numeric($empleado)){
                    $update->where('u.idusuario = ?',$empleado)->execute();
                }else{
                    return false;
                }
                return $bandera;
            }else{
                return false;
            }
        }
        
        public function filtro_usuarios($departamento=null,$tipo_personal=null,$turno=null){
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->Where("u.activo='S'");
                if(is_numeric($departamento)){
                    $q->andWhere("iddepartamento = ? ",$departamento);
                }
                if(is_numeric($tipo_personal)){
                    $q->andWhere("idtipoempleado = ? ",$tipo_personal);
                }
                if(is_numeric($turno)){
                    $q->andWhere("idconfiguracion = ? ",$turno);
                }
                $q->orderBy("nombre,apellido,cedula DESC");
                return $q;
        }
        
        static public function listaUsuariosSelect($departamento = null,$select = array()){
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->Where("u.activo='S'");
                if(!empty($departamento) && $departamento!="null"){
                    $q->andWhere("u.iddepartamento = ?",$departamento);
                }
                $q->orderBy("u.apellido,u.nombre ASC");
                //$select = array();
                foreach($q->execute() as $campo):
                    $select[$campo->getIdusuario()] = $campo->getApellido()." ".$campo->getNombre();
                endforeach;
                return $select;
        }
        
        static public function listaUsuariosSelect1($departamento = null,$select = array()){
            
               // $departamento = sfContext::getInstance()->getUser()->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento();
                
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->Where("u.activo='S'");
                if(!empty($departamento) && $departamento!="null"){
                    $q->andWhere("u.iddepartamento = ?",$departamento);
                }
                $q->orderBy("u.apellido,u.nombre ASC");
                //$select = array();
                foreach($q->execute() as $campo):
                    $select[$campo->getIdusuario()] = $campo->getApellido()." ".$campo->getNombre();
                endforeach;
                return $select;
        }
        
        public function buscarUsuarios1($buscar=null,$campo="u.nombre",$ordenar="ASC",$usuario_id=null,$departamento_id=null){
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->leftJoin("u.Cargo c")
                        ->leftJoin("u.Departamento d")
			->leftJoin("u.UsuarioSistema us")
			->leftJoin('us.TipoUsuario ti')
                        ->leftJoin("u.Sede s")
                        ->leftJoin("u.Configuracion co");
                if(!is_null($usuario_id) && $usuario_id && $usuario_id!="null"){
                     $q->andWhere("u.idusuario = ? ",$usuario_id);
                }
		if(!is_null($buscar) && $buscar){
			$buscar = explode(" ",$buscar);
                        if(is_array($buscar)){
                            foreach($buscar as $palabra){
                                    $palabra = strtoupper($palabra);
                                    $q->andWhere("( nombre LIKE '%".$palabra."%'");
                                    $q->orWhere("u.apellido LIKE '%".$palabra."%'");
                                    $q->orWhere("u.cedula LIKE '%".$palabra."%'");
                                    $q->orWhere("c.cargo LIKE '%".$palabra."%'");
                                    $q->orWhere("s.sede LIKE '%".$palabra."%'");
                                    $q->orWhere("d.departamento LIKE '%".$palabra."%' )");
                            } 
                        }
		}
                if(!is_null($departamento_id) && $departamento_id && $departamento_id !="null"){
                     $q->andWhere("u.iddepartamento = ? ",$departamento_id);
                }
                
		$q->andWhere("u.activo='S'");
                if($campo && $ordenar){
                    $q->orderBy("$campo $ordenar");
                }
		return $q->execute();
        }
        
        public function buscarUsuarios2($buscar=null,$campo="u.nombre",$ordenar="ASC",$usuario_id=null,$departamento_id=null){
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->leftJoin("u.Cargo c")
                        ->leftJoin("u.Departamento d")
			->leftJoin("u.UsuarioSistema us")
			->leftJoin('us.TipoUsuario ti')
                        ->leftJoin("u.Sede s")
                        ->leftJoin("u.Configuracion co");
                if(!is_null($usuario_id) && $usuario_id && $usuario_id!="null"){
                     $q->andWhere("u.idusuario = ? ",$usuario_id);
                }
		if(!is_null($buscar) && $buscar){
			$buscar = explode(" ",$buscar);
                        if(is_array($buscar)){
                            foreach($buscar as $palabra){
                                    $palabra = strtoupper($palabra);
                                    $q->andWhere("( nombre LIKE '%".$palabra."%'");
                                    $q->orWhere("u.apellido LIKE '%".$palabra."%'");
                                    $q->orWhere("u.cedula LIKE '%".$palabra."%'");
                                    $q->orWhere("c.cargo LIKE '%".$palabra."%'");
                                    $q->orWhere("s.sede LIKE '%".$palabra."%'");
                                    $q->orWhere("d.departamento LIKE '%".$palabra."%' )");
                            } 
                        }
		}
                if(!is_null($departamento_id) && $departamento_id && $departamento_id !="null"){
                     $q->andWhere("u.iddepartamento = ? ",$departamento_id);
                }
                if($campo && $ordenar){
                    $q->orderBy("$campo $ordenar");
                }
		return $q->execute();
        }
      
        public function buscarUsuarioJson1($data){
                $departamento = sfContext::getInstance()->getUser()->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento();
                $check=$data->getParameter("seleccion",false);
                $campo="u.apellido,u.nombre";
                $pos = ($check)?1:0;
                switch($data->getParameter("iSortCol_0")):
                     case $pos:
                         $campo="u.apellido,u.nombre";
                     break;
                     case $pos+1:
                         $campo="u.cedula";
                     break;
                     case $pos+2:
                         $campo="c.cargo";
                     break;
                     case $pos+3:
                         $campo="d.departamento";
                     break; 
                     case $pos+4:
                         $campo="s.sede";
                     break;   
                endswitch;
                $datos = $this->buscarUsuarios1($data->getParameter("sSearch",false),$campo,$data->getParameter("sSortDir_0"),null,$departamento);
		$resultados = array();
                $js_funcion=$data->getParameter("funcion",'empleado_seleccionar');
                $js_turno=$data->getParameter("turno",false);
		foreach($datos as $campo => $usuario):
			if($check){
                           $resultados [$campo][] = "<input type=\"checkbox\" name=\"check_empleado[]\" id=\"check_empleado[]\" value=\"".$usuario->getIdusuario()."\" >";
                           $resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getApellido()." ".$usuario->getNombre(),30);
                        }else{
                            $js_empleado = "\"".$usuario->getIdusuario()."\",".
                                        "\"".$usuario->getNombre()."\"".",\"".$usuario->getApellido()."\",".
                                        "\"".$usuario->getCedula()."\"".",\"".$usuario->getIdtipoempleado()."\",".
                                        "\"".$usuario->getIdcargo()."\"".",\"".$usuario->getIddepartamento()."\",".
                                        "\"".$usuario->getSueldo()."\"".",\"".$usuario->getIdsede()."\",".
                                        "\"".date("d/m/Y",(strtotime($usuario->getFechaingreso())))."\"".",\"".$usuario->getIdproyecto()."\",".
                                        "\"".$usuario->getIdconfiguracion()."\"".",\"".$usuario->getIpusuario()."\",".
                                        "\"".(($usuario->UsuarioSistema())?$usuario->UsuarioSistema()->getIdtipousuario().
                                        "\","."\"".$usuario->UsuarioSistema()->getIdusuariosistema():"null,null")."\"";
                           $resultados [$campo][] = "<div class='seleccion_campo' style='cursor:pointer' onclick='".$js_funcion."(".$js_empleado.")'>".Asistencia::limitar_caracteres($usuario->getApellido()." ".$usuario->getNombre(),30)."</div>"; 
                        }
                        
			$resultados [$campo][] =$usuario->getCedula();
			$resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getCargo()->getCargo(),30);
			$resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getDepartamento()->getdepartamento(),35);
			$resultados [$campo][] =Asistencia::limitar_caracteres((($js_turno)?date("h:i a",(strtotime($usuario->getConfiguracion()->getHoraentrada())))." a ".date("h:i a",(strtotime($usuario->getConfiguracion()->getHorasalida()))):$usuario->getSede()->getSede()),35).
                                                "<input type=\"hidden\" id=\"usuario_id\" name=\"usuario_id\" value=\"".$usuario->getIdUsuario()."\" >";
		endforeach;
		return $resultados;

	}
        
        public function buscarUsuarioJson2($data){
                $admin= sfContext::getInstance()->getUser()->getDatosBasicos()->getUsuarioSistema()->getFirst()->getTipoUsuario()->getIdtipousuario();
                
                $check=$data->getParameter("seleccion",false);
                $campo="u.apellido,u.nombre";
                $pos = ($check)?1:0;
                switch($data->getParameter("iSortCol_0")):
                     case $pos+1:
                         $campo="u.apellido,u.nombre";
                     break;
                     case $pos+2:
                         $campo="u.cedula";
                     break;
                     case $pos+3:
                         $campo="c.cargo";
                     break;
                     case $pos+4:
                         $campo="d.departamento";
                     break; 
                     case $pos+5:
                         $campo="s.sede";
                     break;   
                endswitch;
                
                if($admin==2){
                    $datos = $this->buscarUsuarios2($data->getParameter("sSearch",false),$campo,$data->getParameter("sSortDir_0"),null,null);
                }else{
                    $departamento = sfContext::getInstance()->getUser()->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento();
                    $datos = $this->buscarUsuarios2($data->getParameter("sSearch",false),$campo,$data->getParameter("sSortDir_0"),null,$departamento);
                }
                
		$resultados = array();
                $js_funcion=$data->getParameter("funcion",'empleado_seleccionar');
                $js_turno=$data->getParameter("turno",false);
		foreach($datos as $campo => $usuario):
			if($check){
                           $resultados [$campo][] = "<input type=\"checkbox\" name=\"check_empleado[]\" id=\"check_empleado[]\" value=\"".$usuario->getIdusuario()."\" >";
                           $resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getApellido()." ".$usuario->getNombre(),30);
                        }else{
                            $js_empleado = "\"".$usuario->getIdusuario()."\",".
                                        "\"".$usuario->getNombre()."\"".",\"".$usuario->getApellido()."\",".
                                        "\"".$usuario->getCodigoNomina()."\",".
                                        "\"".$usuario->getCedula()."\"".",\"".$usuario->getIdtipoempleado()."\",".
                                        "\"".$usuario->getIdcargo()."\"".",\"".$usuario->getIddepartamento()."\",".
                                        "\"".$usuario->getSueldo()."\"".",\"".$usuario->getIdsede()."\",".
                                        "\"".date("d/m/Y",(strtotime($usuario->getFechaingreso())))."\"".",\"".$usuario->getIdproyecto()."\",".
                                        "\"".$usuario->getIdconfiguracion()."\"".",\"".$usuario->getIpusuario()."\",".
                                        "\"".(($usuario->UsuarioSistema())?$usuario->UsuarioSistema()->getIdtipousuario().
                                        "\","."\"".$usuario->UsuarioSistema()->getIdusuariosistema():"null,null")."\"";
                            if($usuario->getActivo()=='S'){
                                $resultados [$campo][] = "<a href='javascript:eliminar_usuario(".$usuario->getIdUsuario().")' alt='Eliminar Usuario' title='Eliminar Usuario'><img title='Eliminar Usuario' style='margin-right: 50%;' src='/asistencia/web/images/eliminar.gif'><a/>";
                            }else{
                                $resultados [$campo][] = "<a href='javascript:habilitar_usuario(".$usuario->getIdUsuario().")' alt='Habilitar Usuario' title='Habilitar Usuario'><img title='Habilitar Usuario' style='margin-right: 50%;' src='/asistencia/web/images/mark.png'><a/>";
                            }
                            $resultados [$campo][] = "<div class='seleccion_campo' style='cursor:pointer' onclick='".$js_funcion."(".$js_empleado.")'>".Asistencia::limitar_caracteres($usuario->getApellido()." ".$usuario->getNombre(),30)."</div>"; 
                        }
                        
			$resultados [$campo][] =$usuario->getCedula();
			$resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getCargo()->getCargo(),30);
			$resultados [$campo][] =Asistencia::limitar_caracteres($usuario->getDepartamento()->getdepartamento(),35);
			$resultados [$campo][] =Asistencia::limitar_caracteres((($js_turno)?date("h:i a",(strtotime($usuario->getConfiguracion()->getHoraentrada())))." a ".date("h:i a",(strtotime($usuario->getConfiguracion()->getHorasalida()))):$usuario->getSede()->getSede()),35).
                                                "<input type=\"hidden\" id=\"usuario_id\" name=\"usuario_id\" value=\"".$usuario->getIdUsuario()."\" >";
		endforeach;
		return $resultados;
                //print $resultados;
	}
        
        public function buscarSecretaria($departamento=null,$id=null){
            
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->leftJoin("u.UsuarioSistema s")
                ->andWhere("s.idtipousuario=4")
                ->andWhere("u.idusuario=s.idusuario ");
                if(!is_null($departamento) && $departamento && is_numeric($departamento)){
                     $q->andWhere("u.iddepartamento = ? ",$departamento);
                }
                
                if(!is_null($id) && $id && is_numeric($id)){
                     $q->andWhere("u.idusuario = ? ",$id);
                }
		return $q->execute();
                //print $q->getSqlQuery();
        }
       
        public function buscarEmpleadoCombo($departamento=null,$campo="u.apellido",$ordenar="ASC"){
		$q = Doctrine_Query::create()
                        ->from('Usuario u')
                        ->leftJoin("u.Departamento d")
                       ->andWhere("u.iddepartamento =d.iddepartamento ");
                if(!is_null($departamento) && $departamento && is_numeric($departamento)){
                     $q->andWhere("u.iddepartamento = ? ",$departamento);
                }
                $q->andWhere("u.activo='S'");
                if($campo && $ordenar){
                    $q->orderBy("$campo $ordenar");
                }
		return $q->execute();
                
                //print $q->getSqlQuery();
		//return $q->execute();
        }
        
        public function buscarEmpleadosPorCoordinador($usuario){
            $coordinadores = Doctrine_Core::getTable("Coordinador")->buscarCoordinadores($usuario);
            
            $resultado = array();
            foreach($coordinadores as $campo => $coordinador):
			$resultado[] =$coordinador->getDepartamentoId();
            endforeach;
            
            $q = Doctrine_Query::create()
                    ->select("u.idusuario, u.nombre, u.apellido")
                    ->from('Usuario u')
                    ->whereIn("u.iddepartamento",$resultado)
                    ->orderBy("u.apellido");

            return $q->execute();

            //print $q->getSqlQuery();
            //return $q->execute();
        }
        
        public function traerUsuario($departamento){
            $q =  Doctrine_Query::create()
                    ->select("u.idusuario, u.nombre, u.apellido")
                    ->from('Usuario u')
                    ->where("u.iddepartamento=?",$departamento)
                    ->orderBy("u.apellido");

            return $q->execute();
        }
    
    public function listarUsuarioSelect($departamento=null){
        $select = array();
        
        if(is_numeric($departamento)){
            foreach($this->traerUsuario($departamento) as $dto):
                $select[$dto->getIdusuario()] = $dto->getApellido()." ".$dto->getNombre();
            endforeach;
        }else{
            $select[0] = 'Seleccione el empleado';
        }
        
        return $select;
    }
    
    public function traerUsuarioPorTipo($departamento,$tipo){
            $q =  Doctrine_Query::create()
                    ->select("u.idusuario, u.nombre, u.apellido")
                    ->from('Usuario u')
                    ->where("u.iddepartamento=?",$departamento)
                    ->andWhere("u.idtipoempleado=?",$tipo)
                    ->andWhere("u.activo='S'")
                    ->orderBy("u.apellido");

            return $q->execute();
        }
    
    public function listarUsuarioSelectPorTipo($departamento=null,$tipo=null){
        $select = array();
        
        if(is_numeric($departamento)){
            foreach($this->traerUsuarioPorTipo($departamento,$tipo) as $dto):
                $select[$dto->getIdusuario()] = $dto->getApellido()." ".$dto->getNombre();
            endforeach;
        }else{
            $select[0] = 'Seleccione el empleado';
        }
        
        return $select;
    }
    
    public function buscarPorCedula($cedula){
        $ret = Doctrine_Query::create()
            ->from('Usuario u')
            ->where('u.cedula = ?', $cedula)
            ->setHydrationMode(Doctrine::HYDRATE_RECORD);

        if ($ret->count() == 0) return null;
        else return $ret->execute()->getFirst();
    }
    
    public function traerUsuarios(){
        $q =  Doctrine_Query::create()
                ->from('Usuario u')
                ->where("u.codigo_nomina = 0")
                ->orWhere("u.codigo_nomina is null");

        return $q->execute();
    }
    
    public function actualizarCodigoNomina($cedula,$codigo)
    {
        $q = Doctrine_Query::create()
        ->update('Usuario u')
        ->set('u.codigo_nomina', '?', $codigo)
        ->where('u.cedula = ?', $cedula);
        $q->execute();
    }
}
