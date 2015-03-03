<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Movimiento', 'doctrine');

/**
 * BaseMovimiento
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idmovimiento
 * @property integer $idusuario
 * @property timestamp $fecha
 * @property string $movimiento
 * @property string $estado
 * @property string $registro
 * @property string $ipsede
 * @property string $ipusuario
 * @property integer $idconfiguracion
 * @property integer $idmotivo
 * @property Usuario $Usuario
 * @property Configuracion $Configuracion
 * @property Motivo $Motivo
 * 
 * @method integer       getIdmovimiento()    Returns the current record's "idmovimiento" value
 * @method integer       getIdusuario()       Returns the current record's "idusuario" value
 * @method timestamp     getFecha()           Returns the current record's "fecha" value
 * @method string        getMovimiento()      Returns the current record's "movimiento" value
 * @method string        getEstado()          Returns the current record's "estado" value
 * @method string        getRegistro()        Returns the current record's "registro" value
 * @method string        getIpsede()          Returns the current record's "ipsede" value
 * @method string        getIpusuario()       Returns the current record's "ipusuario" value
 * @method integer       getIdconfiguracion() Returns the current record's "idconfiguracion" value
 * @method integer       getIdmotivo()        Returns the current record's "idmotivo" value
 * @method Usuario       getUsuario()         Returns the current record's "Usuario" value
 * @method Configuracion getConfiguracion()   Returns the current record's "Configuracion" value
 * @method Motivo        getMotivo()          Returns the current record's "Motivo" value
 * @method Movimiento    setIdmovimiento()    Sets the current record's "idmovimiento" value
 * @method Movimiento    setIdusuario()       Sets the current record's "idusuario" value
 * @method Movimiento    setFecha()           Sets the current record's "fecha" value
 * @method Movimiento    setMovimiento()      Sets the current record's "movimiento" value
 * @method Movimiento    setEstado()          Sets the current record's "estado" value
 * @method Movimiento    setRegistro()        Sets the current record's "registro" value
 * @method Movimiento    setIpsede()          Sets the current record's "ipsede" value
 * @method Movimiento    setIpusuario()       Sets the current record's "ipusuario" value
 * @method Movimiento    setIdconfiguracion() Sets the current record's "idconfiguracion" value
 * @method Movimiento    setIdmotivo()        Sets the current record's "idmotivo" value
 * @method Movimiento    setUsuario()         Sets the current record's "Usuario" value
 * @method Movimiento    setConfiguracion()   Sets the current record's "Configuracion" value
 * @method Movimiento    setMotivo()          Sets the current record's "Motivo" value
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMovimiento extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asistencia.Movimiento');
        $this->hasColumn('idmovimiento', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('idusuario', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('fecha', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('movimiento', 'string', 1, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('estado', 'string', 10, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => 'PUNTUAL',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 10,
             ));
        $this->hasColumn('registro', 'string', 15, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 15,
             ));
        $this->hasColumn('ipsede', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '------',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('ipusuario', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '------',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('idconfiguracion', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('idmotivo', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Usuario', array(
             'local' => 'idusuario',
             'foreign' => 'idusuario',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Configuracion', array(
             'local' => 'idconfiguracion',
             'foreign' => 'idconfiguracion',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Motivo', array(
             'local' => 'idmotivo',
             'foreign' => 'idmotivo',
             'onDelete' => 'CASCADE'));
    }
}