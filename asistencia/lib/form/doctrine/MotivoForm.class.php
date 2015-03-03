<?php

/**
 * Motivo form.
 *
 * @package    asistencia
 * @subpackage form
 * @author     Juan Casseus
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MotivoForm extends BaseMotivoForm
{
  public function configure(){
      unset(
            $this["activo"], 
            $this["created_at"], 
            $this["updated_at"]
            );
      $this->widgetSchema->setNameFormat('motivos[%s]');
      $this->widgetSchema['motivo']->setAttributes(array('size' => 50));
  }
}
