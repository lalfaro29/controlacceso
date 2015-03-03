<?php

/**
 * RelacionConfigFeriadoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class RelacionConfigFeriadoTable extends PluginRelacionConfigFeriadoTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object RelacionConfigFeriadoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('RelacionConfigFeriado');
    }
    
    
    public function getRelacionFeriado($feriado,$configuracion){
	return    Doctrine_Query::create()
			->from('RelacionConfigFeriado u')
                        ->where("u.idferiado = ? ", $feriado)
                        ->andWhere("u.idconfiguracion = ? ", $configuracion)
			->fetchOne();
    }
}