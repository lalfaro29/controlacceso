<?php

/**
 * VDatosPersonales form base class.
 *
 * @method VDatosPersonales getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseVDatosPersonalesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'cedula'                => new sfWidgetFormInputText(),
      'primer_nombre'         => new sfWidgetFormTextarea(),
      'segundo_nombre'        => new sfWidgetFormTextarea(),
      'primer_apellido'       => new sfWidgetFormTextarea(),
      'segundo_apellido'      => new sfWidgetFormTextarea(),
      'descripcion_cargo'     => new sfWidgetFormTextarea(),
      'estatus'               => new sfWidgetFormTextarea(),
      'telefono_oficina'      => new sfWidgetFormTextarea(),
      'telefono_celular'      => new sfWidgetFormTextarea(),
      'telefono_residencia'   => new sfWidgetFormTextarea(),
      'email'                 => new sfWidgetFormTextarea(),
      'codigo_nomina'         => new sfWidgetFormInputText(),
      'dependencia'           => new sfWidgetFormTextarea(),
      'fecha_ingreso'         => new sfWidgetFormDate(),
      'nombre'                => new sfWidgetFormTextarea(),
      'periodicidad'          => new sfWidgetFormTextarea(),
      'unidad_administradora' => new sfWidgetFormTextarea(),
      'fecha_nacimiento'      => new sfWidgetFormDate(),
      'sexo'                  => new sfWidgetFormTextarea(),
      'estado_civil'          => new sfWidgetFormTextarea(),
      'id_personal'           => new sfWidgetFormInputText(),
      'id_dependencia'        => new sfWidgetFormInputText(),
      'id_unidad_funcional'   => new sfWidgetFormInputText(),
      'nombre_uf'             => new sfWidgetFormTextarea(),
      'id_tipo_personal'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'cedula'                => new sfValidatorInteger(array('required' => false)),
      'primer_nombre'         => new sfValidatorString(),
      'segundo_nombre'        => new sfValidatorString(),
      'primer_apellido'       => new sfValidatorString(),
      'segundo_apellido'      => new sfValidatorString(),
      'descripcion_cargo'     => new sfValidatorString(),
      'estatus'               => new sfValidatorString(),
      'telefono_oficina'      => new sfValidatorString(),
      'telefono_celular'      => new sfValidatorString(),
      'telefono_residencia'   => new sfValidatorString(),
      'email'                 => new sfValidatorString(),
      'codigo_nomina'         => new sfValidatorInteger(),
      'dependencia'           => new sfValidatorString(),
      'fecha_ingreso'         => new sfValidatorDate(),
      'nombre'                => new sfValidatorString(),
      'periodicidad'          => new sfValidatorString(),
      'unidad_administradora' => new sfValidatorString(),
      'fecha_nacimiento'      => new sfValidatorDate(),
      'sexo'                  => new sfValidatorString(),
      'estado_civil'          => new sfValidatorString(),
      'id_personal'           => new sfValidatorInteger(),
      'id_dependencia'        => new sfValidatorInteger(),
      'id_unidad_funcional'   => new sfValidatorInteger(),
      'nombre_uf'             => new sfValidatorString(),
      'id_tipo_personal'      => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('v_datos_personales[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VDatosPersonales';
  }

}
