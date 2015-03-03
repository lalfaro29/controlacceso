<?php

/**
 * Sede form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SedeForm extends BaseSedeForm
{
  public function configure()
  {
      $this->widgetSchema->setNameFormat('sedes[%s]');
  }
}
