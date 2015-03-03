<?php

/**
 * Usuario
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Usuario extends PluginUsuario{

	public function save(Doctrine_Connection $conn = null){
		$this->setNombre(strtoupper($this->getNombre()));
		$this->setApellido(strtoupper($this->getApellido()));
		/*if ($this->isNew() && !$this->getFechaingreso()){
			$now =  time();
			$this->setFechaingreso(date('Y-m-d H:i:s', $now));
		}*/
	return parent::save($conn);
	}
 
	public function configuracion(){ 
		return Doctrine_Core::getTable('Configuracion')->configuracion($this->getIdconfiguracion());
	}

        public function UsuarioSistema(){
		$q = Doctrine_Query::create()
			->from("UsuarioSistema us")
			->andWhere("us.idusuario = ?",$this->getIdusuario());
		return $q->fetchOne();
        }
        public function registroMovimientos($inicio=null,$fin=null,$formatear=true){
            if(!is_null($inicio) && $formatear){
                $inicio = Asistencia::cambiarFormatoFechaMDA_2($inicio,"/");
            }
            if(!is_null($fin) && $formatear){
                $fin = Asistencia::cambiarFormatoFechaMDA_2($fin,"/");
            }
	return Doctrine_Core::getTable("Movimiento")->MovimientoUsuarioFecha($this->getIdusuario(),null,$inicio,$fin);
        }
        
        public function listadoPermisos($desde=null,$hasta=null){
            if((!is_null($desde) || !is_null($hasta)) && (($desde && $desde !="") || ($hasta && $hasta !=""))){
                $fecha = array(
                    "desde"=>$desde,
                    "hasta"=>$hasta
                );
            }else{
                $fecha = null;
            }
            /*return Doctrine_Query::create()
                    ->from("Permiso")
                    ->where("usuario_id = ?",$this->getIdusuario())
                    ->orderby("fechadesde ASC");
            */
         /*   print Doctrine_Core::getTable("Permiso")
                    ->getPermisoUsuario($this->getIdusuario(),$fecha,"p.fechadesde,p.fechahasta")
                    ->getSqlQuery();*/
            return Doctrine_Core::getTable("Permiso")->getPermisoUsuario($this->getIdusuario(),$fecha,"p.fechadesde,p.fechahasta");
        }
        

        
}
