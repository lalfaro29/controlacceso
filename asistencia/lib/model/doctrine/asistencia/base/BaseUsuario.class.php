<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Usuario', 'doctrine');

/**
 * BaseUsuario
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idusuario
 * @property string $nombre
 * @property string $apellido
 * @property string $cedula
 * @property integer $idtipoempleado
 * @property integer $idcargo
 * @property integer $iddepartamento
 * @property integer $idsede
 * @property integer $estado
 * @property timestamp $fechaingreso
 * @property float $sueldo
 * @property integer $idproyecto
 * @property integer $idconfiguracion
 * @property string $ipusuario
 * @property string $activo
 * @property integer $codigo_nomina
 * @property TipoEmpleado $TipoEmpleado
 * @property Cargo $Cargo
 * @property Departamento $Departamento
 * @property Sede $Sede
 * @property Proyecto $Proyecto
 * @property Configuracion $Configuracion
 * @property Doctrine_Collection $Coordinador
 * @property Doctrine_Collection $JefeUnidad
 * @property Doctrine_Collection $Movimiento
 * @property Doctrine_Collection $Permiso
 * @property Doctrine_Collection $UsuarioSistema
 * 
 * @method integer             getIdusuario()       Returns the current record's "idusuario" value
 * @method string              getNombre()          Returns the current record's "nombre" value
 * @method string              getApellido()        Returns the current record's "apellido" value
 * @method string              getCedula()          Returns the current record's "cedula" value
 * @method integer             getIdtipoempleado()  Returns the current record's "idtipoempleado" value
 * @method integer             getIdcargo()         Returns the current record's "idcargo" value
 * @method integer             getIddepartamento()  Returns the current record's "iddepartamento" value
 * @method integer             getIdsede()          Returns the current record's "idsede" value
 * @method integer             getEstado()          Returns the current record's "estado" value
 * @method timestamp           getFechaingreso()    Returns the current record's "fechaingreso" value
 * @method float               getSueldo()          Returns the current record's "sueldo" value
 * @method integer             getIdproyecto()      Returns the current record's "idproyecto" value
 * @method integer             getIdconfiguracion() Returns the current record's "idconfiguracion" value
 * @method string              getIpusuario()       Returns the current record's "ipusuario" value
 * @method string              getActivo()          Returns the current record's "activo" value
 * @method integer             getCodigoNomina()    Returns the current record's "codigo_nomina" value
 * @method TipoEmpleado        getTipoEmpleado()    Returns the current record's "TipoEmpleado" value
 * @method Cargo               getCargo()           Returns the current record's "Cargo" value
 * @method Departamento        getDepartamento()    Returns the current record's "Departamento" value
 * @method Sede                getSede()            Returns the current record's "Sede" value
 * @method Proyecto            getProyecto()        Returns the current record's "Proyecto" value
 * @method Configuracion       getConfiguracion()   Returns the current record's "Configuracion" value
 * @method Doctrine_Collection getCoordinador()     Returns the current record's "Coordinador" collection
 * @method Doctrine_Collection getJefeUnidad()      Returns the current record's "JefeUnidad" collection
 * @method Doctrine_Collection getMovimiento()      Returns the current record's "Movimiento" collection
 * @method Doctrine_Collection getPermiso()         Returns the current record's "Permiso" collection
 * @method Doctrine_Collection getUsuarioSistema()  Returns the current record's "UsuarioSistema" collection
 * @method Usuario             setIdusuario()       Sets the current record's "idusuario" value
 * @method Usuario             setNombre()          Sets the current record's "nombre" value
 * @method Usuario             setApellido()        Sets the current record's "apellido" value
 * @method Usuario             setCedula()          Sets the current record's "cedula" value
 * @method Usuario             setIdtipoempleado()  Sets the current record's "idtipoempleado" value
 * @method Usuario             setIdcargo()         Sets the current record's "idcargo" value
 * @method Usuario             setIddepartamento()  Sets the current record's "iddepartamento" value
 * @method Usuario             setIdsede()          Sets the current record's "idsede" value
 * @method Usuario             setEstado()          Sets the current record's "estado" value
 * @method Usuario             setFechaingreso()    Sets the current record's "fechaingreso" value
 * @method Usuario             setSueldo()          Sets the current record's "sueldo" value
 * @method Usuario             setIdproyecto()      Sets the current record's "idproyecto" value
 * @method Usuario             setIdconfiguracion() Sets the current record's "idconfiguracion" value
 * @method Usuario             setIpusuario()       Sets the current record's "ipusuario" value
 * @method Usuario             setActivo()          Sets the current record's "activo" value
 * @method Usuario             setCodigoNomina()    Sets the current record's "codigo_nomina" value
 * @method Usuario             setTipoEmpleado()    Sets the current record's "TipoEmpleado" value
 * @method Usuario             setCargo()           Sets the current record's "Cargo" value
 * @method Usuario             setDepartamento()    Sets the current record's "Departamento" value
 * @method Usuario             setSede()            Sets the current record's "Sede" value
 * @method Usuario             setProyecto()        Sets the current record's "Proyecto" value
 * @method Usuario             setConfiguracion()   Sets the current record's "Configuracion" value
 * @method Usuario             setCoordinador()     Sets the current record's "Coordinador" collection
 * @method Usuario             setJefeUnidad()      Sets the current record's "JefeUnidad" collection
 * @method Usuario             setMovimiento()      Sets the current record's "Movimiento" collection
 * @method Usuario             setPermiso()         Sets the current record's "Permiso" collection
 * @method Usuario             setUsuarioSistema()  Sets the current record's "UsuarioSistema" collection
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUsuario extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asistencia.Usuario');
        $this->hasColumn('idusuario', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('nombre', 'string', 50, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 50,
             ));
        $this->hasColumn('apellido', 'string', 50, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 50,
             ));
        $this->hasColumn('cedula', 'string', 15, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 15,
             ));
        $this->hasColumn('idtipoempleado', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('idcargo', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('iddepartamento', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('idsede', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('estado', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '1',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('fechaingreso', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('sueldo', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('idproyecto', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('idconfiguracion', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('ipusuario', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('activo', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => false,
             'default' => 'S',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('codigo_nomina', 'integer', 7, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => true,
             'primary' => false,
             'length' => 7,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('TipoEmpleado', array(
             'local' => 'idtipoempleado',
             'foreign' => 'idtipoempleado',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Cargo', array(
             'local' => 'idcargo',
             'foreign' => 'idcargo',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Departamento', array(
             'local' => 'iddepartamento',
             'foreign' => 'iddepartamento',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Sede', array(
             'local' => 'idsede',
             'foreign' => 'idsede',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Proyecto', array(
             'local' => 'idproyecto',
             'foreign' => 'idproyecto',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Configuracion', array(
             'local' => 'idconfiguracion',
             'foreign' => 'idconfiguracion',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Coordinador', array(
             'local' => 'idusuario',
             'foreign' => 'usuario_id'));

        $this->hasMany('JefeUnidad', array(
             'local' => 'idusuario',
             'foreign' => 'usuario_id'));

        $this->hasMany('Movimiento', array(
             'local' => 'idusuario',
             'foreign' => 'idusuario'));

        $this->hasMany('Permiso', array(
             'local' => 'idusuario',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioSistema', array(
             'local' => 'idusuario',
             'foreign' => 'idusuario'));
    }
}