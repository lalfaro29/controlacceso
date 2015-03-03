<?php

/**
 * horaestra actions.
 *
 * @package    asistencia
 * @subpackage horaestra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class horaestraActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->hora_extras = Doctrine_Core::getTable('HoraExtra')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->hora_extra = Doctrine_Core::getTable('HoraExtra')->find(array($request->getParameter('idhoraextra')));
    $this->forward404Unless($this->hora_extra);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new HoraExtraForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new HoraExtraForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($hora_extra = Doctrine_Core::getTable('HoraExtra')->find(array($request->getParameter('idhoraextra'))), sprintf('Object hora_extra does not exist (%s).', $request->getParameter('idhoraextra')));
    $this->form = new HoraExtraForm($hora_extra);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($hora_extra = Doctrine_Core::getTable('HoraExtra')->find(array($request->getParameter('idhoraextra'))), sprintf('Object hora_extra does not exist (%s).', $request->getParameter('idhoraextra')));
    $this->form = new HoraExtraForm($hora_extra);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($hora_extra = Doctrine_Core::getTable('HoraExtra')->find(array($request->getParameter('idhoraextra'))), sprintf('Object hora_extra does not exist (%s).', $request->getParameter('idhoraextra')));
    $hora_extra->delete();

    $this->redirect('horaestra/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $hora_extra = $form->save();

      $this->redirect('horaestra/edit?idhoraextra='.$hora_extra->getIdhoraextra());
    }
  }
}
