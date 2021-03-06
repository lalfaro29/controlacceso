<?php

/**
 * VDatosPersonalesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class VDatosPersonalesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object VDatosPersonalesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('VDatosPersonales');
    }
    
    public function validarDatosUsuarios($cedula)
    {
        $q = "SELECT cedula, codigo_nomina, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, id_unidad_funcional,dependencia, nombre, id_tipo_personal, nombre_uf 
            FROM v_datos_personales 
            WHERE ((nombre = 'COMISION DE SERVICIOS' OR nombre = 'CONTRATADO' OR nombre = 'CONTRATADO MPD' OR nombre = 'EMPLEADO FIJO' OR nombre = 'EMPLEADO FIJO MPD' OR nombre = 'FONDO VENEZUELA BELARUS' OR nombre = 'OBRERO QUINCENAL' OR nombre = 'OBRERO QUINCENAL MPD' OR nombre = 'SUPLENTE/ENCARGADO' OR nombre = 'SUPLENTES/ENCARGADOS MPD' ) 
            AND cedula = $cedula)";
        $con = Doctrine_Manager::getInstance()->connection();
        $st = $con->execute($q);
        return $st->fetchAll();
    }
}