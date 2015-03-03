<?php

/**
 * Cargo form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CargoForm extends BaseCargoForm
{
  public function configure()
  {
      $this->widgetSchema->setNameFormat('cargos[%s]');
  }
}
