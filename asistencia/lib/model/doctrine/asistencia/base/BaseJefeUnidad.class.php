<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('JefeUnidad', 'doctrine');

/**
 * BaseJefeUnidad
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $departamento_id
 * @property Usuario $Usuario
 * @property Departamento $Departamento
 * 
 * @method integer      getId()              Returns the current record's "id" value
 * @method integer      getUsuarioId()       Returns the current record's "usuario_id" value
 * @method integer      getDepartamentoId()  Returns the current record's "departamento_id" value
 * @method Usuario      getUsuario()         Returns the current record's "Usuario" value
 * @method Departamento getDepartamento()    Returns the current record's "Departamento" value
 * @method JefeUnidad   setId()              Sets the current record's "id" value
 * @method JefeUnidad   setUsuarioId()       Sets the current record's "usuario_id" value
 * @method JefeUnidad   setDepartamentoId()  Sets the current record's "departamento_id" value
 * @method JefeUnidad   setUsuario()         Sets the current record's "Usuario" value
 * @method JefeUnidad   setDepartamento()    Sets the current record's "Departamento" value
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseJefeUnidad extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asistencia.jefe_unidad');
        $this->hasColumn('id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 8,
             ));
        $this->hasColumn('usuario_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('departamento_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
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