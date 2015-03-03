<?php

/**
 * Proyecto form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProyectoForm extends BaseProyectoForm
{
  public function configure()
  {
      $this->widgetSchema->setNameFormat('proyectos[%s]');
  }
}
