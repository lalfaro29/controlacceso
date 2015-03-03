<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Departamento', 'doctrine');

/**
 * BaseDepartamento
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $iddepartamento
 * @property string $departamento
 * @property Doctrine_Collection $Coordinador
 * @property Doctrine_Collection $JefeUnidad
 * @property Doctrine_Collection $Usuario
 * 
 * @method integer             getIddepartamento() Returns the current record's "iddepartamento" value
 * @method string              getDepartamento()   Returns the current record's "departamento" value
 * @method Doctrine_Collection getCoordinador()    Returns the current record's "Coordinador" collection
 * @method Doctrine_Collection getJefeUnidad()     Returns the current record's "JefeUnidad" collection
 * @method Doctrine_Collection getUsuario()        Returns the current record's "Usuario" collection
 * @method Departamento        setIddepartamento() Sets the current record's "iddepartamento" value
 * @method Departamento        setDepartamento()   Sets the current record's "departamento" value
 * @method Departamento        setCoordinador()    Sets the current record's "Coordinador" collection
 * @method Departamento        setJefeUnidad()     Sets the current record's "JefeUnidad" collection
 * @method Departamento        setUsuario()        Sets the current record's "Usuario" collection
 * 
 * @package    asistencia
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDepartamento extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asistencia.Departamento');
        $this->hasColumn('iddepartamento', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('departamento', 'string', 60, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 60,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Coordinador', array(
             'local' => 'iddepartamento',
             'foreign' => 'departamento_id'));

        $this->hasMany('JefeUnidad', array(
             'local' => 'iddepartamento',
             'foreign' => 'departamento_id'));

        $this->hasMany('Usuario', array(
             'local' => 'iddepartamento',
             'foreign' => 'iddepartamento'));
    }
}