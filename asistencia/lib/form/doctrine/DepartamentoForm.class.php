<?php

/**
 * Departamento form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartamentoForm extends BaseDepartamentoForm
{
  public function configure()
  {
      $this->widgetSchema->setNameFormat('departamentos[%s]');
  }
}
