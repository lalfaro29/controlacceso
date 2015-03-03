<?php

class myUser extends sfBasicSecurityUser{

	public function agregarDatosBasicos($usuario){
		$this->setAttribute('datos_basicos', $usuario);
	}
	public function getDatosBasicos(){
		return $this->getAttribute('datos_basicos', array());
	}

	public function eliminarDatosBasicos(){
		    $this->getAttributeHolder()->remove('datos_basicos');
	}

	public function registrar_variable($nombre,$valor){
		$this->setAttribute($nombre, $valor);
	}

	public function get_variable($nombre,$defecto=""){
		return $this->getAttribute($nombre,$defecto);
	}
        
        public function setClave($clave){
            //$datos = $this->getDatosBasicos();
            //getPsw
           /* foreach($datos->getUsuarioSistema() as &$campos):
                $campos->setPsw($clave);
            endforeach;
            return ($datos->getUsuarioSistema()->getFirst()->getPsw() == md5($clave))?true: false;*/
            $this->getDatosBasicos()->getUsuarioSistema()->getFirst()->getPsw(md5($clave));
            return ($this->getDatosBasicos()->getUsuarioSistema()->getFirst()->getPsw() == md5($clave))?true: false;
        }
}
