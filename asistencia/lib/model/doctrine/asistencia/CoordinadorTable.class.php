<?php

/**
 * CoordinadorTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CoordinadorTable extends PluginCoordinadorTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object CoordinadorTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Coordinador');
    }
    
    public function buscarCoordinadores($usuario){
            $j = Doctrine_Query::create()
                ->from('Coordinador c')
                ->where("c.usuario_id=?", $usuario);
        
        return $j->execute();
    }
    
    public function buscarCoordinador($usuario,$departamento){
        $ret = Doctrine_Query::create()
        ->from("Coordinador c")
        ->where("c.usuario_id = ?", $usuario)
        ->andWhere("c.departamento_id = ?", $departamento)
        ->setHydrationMode(Doctrine::HYDRATE_RECORD);

        if ($ret->count() == 0) return null;
        else return $ret->execute()->getFirst();
    }
}