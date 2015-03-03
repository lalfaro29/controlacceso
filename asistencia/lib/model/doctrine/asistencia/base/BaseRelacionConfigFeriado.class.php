<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('RelacionConfigFeriado', 'doctrine');

/**
 * BaseRelacionConfigFeriado
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idconfiguracion
 * @property integer $idferiado
 * @property Configuracion $Configuracion
 * @property Feriado $Feriado
 * 
 * @method integer               getIdconfiguracion() Returns the current record's "idconfiguracion" value
 * @method integer               getIdferiado()       Returns the current record's "idferiado" value
 * @method Configuracion         getConfiguracion()   Returns the current record's "Configuracion" value
 * @method Feriado               getFeriado()         Returns the current record's "Feriado" value
 * @method RelacionConfigFeriado setIdconfiguracion() Sets the current record's "idconfiguracion" value
 * @method RelacionConfigFeriado setIdferiado()       Sets the current record's "idferiado" value
 * @method RelacionConfigFeriado setConfiguracion()   Sets the current record's "Configuracion" value
 * @method RelacionConfigFeriado setFeriado()         Sets the current record's "Feriado" value
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRelacionConfigFeriado extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asistencia.RelacionConfigFeriado');
        $this->hasColumn('idconfiguracion', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'unique' => true,
             ));
        $this->hasColumn('idferiado', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'unique' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Configuracion', array(
             'local' => 'idconfiguracion',
             'foreign' => 'idconfiguracion',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Feriado', array(
             'local' => 'idferiado',
             'foreign' => 'idferiado',
             'onDelete' => 'CASCADE'));
    }
}