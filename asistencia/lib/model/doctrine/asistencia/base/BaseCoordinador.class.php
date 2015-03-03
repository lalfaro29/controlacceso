<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Coordinador', 'doctrine');

/**
 * BaseCoordinador
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_coordinador
 * @property integer $usuario_id
 * @property integer $departamento_id
 * @property Usuario $Usuario
 * @property Departamento $Departamento
 * 
 * @method integer      getIdCoordinador()   Returns the current record's "id_coordinador" value
 * @method integer      getUsuarioId()       Returns the current record's "usuario_id" value
 * @method integer      getDepartamentoId()  Returns the current record's "departamento_id" value
 * @method Usuario      getUsuario()         Returns the current record's "Usuario" value
 * @method Departamento getDepartamento()    Returns the current record's "Departamento" value
 * @method Coordinador  setIdCoordinador()   Sets the current record's "id_coordinador" value
 * @method Coordinador  setUsuarioId()       Sets the current record's "usuario_id" value
 * @method Coordinador  setDepartamentoId()  Sets the current record's "departamento_id" value
 * @method Coordinador  setUsuario()         Sets the current record's "Usuario" value
 * @method Coordinador  setDepartamento()    Sets the current record's "Departamento" value
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCoordinador extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asistencia.coordinador');
        $this->hasColumn('id_coordinador', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 8,
             ));
        $this->hasColumn('usuario_id', 'integer', 20, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 20,
             ));
        $this->hasColumn('departamento_id', 'integer', 20, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 20,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'idusuario',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Departamento', array(
             'local' => 'departamento_id',
             'foreign' => 'iddepartamento',
             'onDelete' => 'CASCADE'));
    }
}