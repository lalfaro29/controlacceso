<?php

/**
 * Configuracion form base class.
 *
 * @method Configuracion getObject() Returns the current form's model object
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseConfiguracionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idconfiguracion'              => new sfWidgetFormInputHidden(),
      'idusuario'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'add_empty' => true)),
      'fecha'                        => new sfWidgetFormDateTime(),
      'horaentrada'                  => new sfWidgetFormTime(),
      'horasalida'                   => new sfWidgetFormTime(),
      'horamaxentrada'               => new sfWidgetFormInputText(),
      'central'                      => new sfWidgetFormInputText(),
      'cestatique_x_jornada'         => new sfWidgetFormInputText(),
      'precioticks'                  => new sfWidgetFormInputText(),
      'idsede'                       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sede'), 'add_empty' => false)),
      'horadesdedi'                  => new sfWidgetFormTime(),
      'horahastadi'                  => new sfWidgetFormTime(),
      'horadesdeno'                  => new sfWidgetFormTime(),
      'horahastano'                  => new sfWidgetFormTime(),
      'porcentajedi'                 => new sfWidgetFormInputText(),
      'porcentajeno'                 => new sfWidgetFormInputText(),
      'relacion_config_feriado_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Feriado')),
    ));

    $this->setValidators(array(
      'idconfiguracion'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idconfiguracion')), 'empty_value' => $this->getObject()->get('idconfiguracion'), 'required' => false)),
      'idusuario'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Usuario'), 'required' => false)),
      'fecha'                        => new sfValidatorDateTime(),
      'horaentrada'                  => new sfValidatorTime(),
      'horasalida'                   => new sfValidatorTime(),
      'horamaxentrada'               => new sfValidatorInteger(),
      'central'                      => new sfValidatorInteger(array('required' => false)),
      'cestatique_x_jornada'         => new sfValidatorNumber(array('required' => false)),
      'precioticks'                  => new sfValidatorNumber(array('required' => false)),
      'idsede'                       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sede'))),
      'horadesdedi'                  => new sfValidatorTime(),
      'horahastadi'                  => new sfValidatorTime(),
      'horadesdeno'                  => new sfValidatorTime(),
      'horahastano'                  => new sfValidatorTime(),
      'porcentajedi'                 => new sfValidatorNumber(array('required' => false)),
      'porcentajeno'                 => new sfValidatorNumber(array('required' => false)),
      'relacion_config_feriado_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Feriado', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('configuracion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Configuracion';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['relacion_config_feriado_list']))
    {
      $this->setDefault('relacion_config_feriado_list', $this->object->RelacionConfigFeriado->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveRelacionConfigFeriadoList($con);

    parent::doSave($con);
  }

  public function saveRelacionConfigFeriadoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['relacion_config_feriado_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->RelacionConfigFeriado->getPrimaryKeys();
    $values = $this->getValue('relacion_config_feriado_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('RelacionConfigFeriado', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('RelacionConfigFeriado', array_values($link));
    }
  }

}
