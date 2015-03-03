<?php

/**
 * retraso actions.
 *
 * @package    asistencia
 * @subpackage retraso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class retrasoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->retrasos = Doctrine_Core::getTable('Retraso')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->retraso = Doctrine_Core::getTable('Retraso')->find(array($request->getParameter('idretraso')));
    $this->forward404Unless($this->retraso);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new RetrasoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new RetrasoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($retraso = Doctrine_Core::getTable('Retraso')->find(array($request->getParameter('idretraso'))), sprintf('Object retraso does not exist (%s).', $request->getParameter('idretraso')));
    $this->form = new RetrasoForm($retraso);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($retraso = Doctrine_Core::getTable('Retraso')->find(array($request->getParameter('idretraso'))), sprintf('Object retraso does not exist (%s).', $request->getParameter('idretraso')));
    $this->form = new RetrasoForm($retraso);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($retraso = Doctrine_Core::getTable('Retraso')->find(array($request->getParameter('idretraso'))), sprintf('Object retraso does not exist (%s).', $request->getParameter('idretraso')));
    $retraso->delete();

    $this->redirect('retraso/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $retraso = $form->save();

      $this->redirect('retraso/edit?idretraso='.$retraso->getIdretraso());
    }
  }
}
