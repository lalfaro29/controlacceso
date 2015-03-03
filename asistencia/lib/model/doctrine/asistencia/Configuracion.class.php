<?php

/**
 * Configuracion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Configuracion extends PluginConfiguracion{
    
	public function save(Doctrine_Connection $conn = null){
		$this->setFecha(date("d-m-Y H:i:s"));
	return parent::save($conn);
	}
        
    
	public function feriados($fecha=false){
		$q = Doctrine_Query::create()
			->from("Feriado fe")
			->leftJoin("fe.RelacionConfigFeriado rcf")
			->andWhere("rcf.idConfiguracion = ?",$this->getIdconfiguracion());
			if(!is_null($fecha)){
				$q->andWhere("(to_char(feriadofechdesde,'mm-dd') >= ?", $fecha);
				$q->andWhere("to_char(feriadofechhasta,'mm-dd') <= ?)", $fecha);
				$q->orWhere("(to_char(feriadofechdesde,'mm-dd') = ?", $fecha);
				$q->andWhere("to_char(feriadofechhasta,'mm-dd') = null)");
			}
		return $q->execute();
	}
}
