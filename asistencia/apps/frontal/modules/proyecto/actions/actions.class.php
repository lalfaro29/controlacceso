<?php

/**
 * proyecto actions.
 *
 * @package    asistencia
 * @subpackage proyecto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class proyectoActions extends sfActions
{
	public function executeIndex(sfWebRequest $request){
		$this->proyectos = Doctrine_Core::getTable('Proyecto')->createQuery('a')->execute();
	}

	public function executeShow(sfWebRequest $request){
		/*$this->proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('idproyecto')));
		$this->forward404Unless($this->proyecto);*/
	}

	public function executeNew(sfWebRequest $request){
		$this->form = new ProyectoForm();
	}

	public function executeCreate(sfWebRequest $request){
		/*$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new ProyectoForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');*/
	}

	public function executeCrear(sfWebRequest $request){
            $datos = $request->getParameter("proyectos");
            if(is_numeric($datos["idproyecto"])){
                foreach($datos as $name => $value):
                    $request->setParameter($name, $value);
                endforeach;
                $proyecto = Doctrine_Core::getTable('Proyecto')->findOneByIdproyecto(array($request->getParameter('idproyecto')));
		$this->form = new ProyectoForm($proyecto);
            }else{
		$this->form = new ProyectoForm();
            }
		return $this->renderText(json_encode($this->processForm($request, $this->form)));
	}


	public function executeEdit(sfWebRequest $request){
		$this->forward404Unless($proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('idproyecto'))), sprintf('Object proyecto does not exist (%s).', $request->getParameter('idproyecto')));
		$this->form = new ProyectoForm($proyecto);
	}

	public function executeUpdate(sfWebRequest $request){
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('idproyecto'))), sprintf('Object proyecto does not exist (%s).', $request->getParameter('idproyecto')));
		$this->form = new ProyectoForm($proyecto);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request){
		$request->checkCSRFProtection();
		$this->forward404Unless($proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('idproyecto'))), sprintf('Object proyecto does not exist (%s).', $request->getParameter('idproyecto')));
		$proyecto->delete();
		$this->redirect('proyecto/index');
	}

        public function executeEliminar(sfWebRequest $request){
            $proyecto = Doctrine_Core::getTable('Proyecto')->find(array($request->getParameter('proyecto')));
            if($proyecto->count() && $request->getParameter('proyecto')){
               $proyecto->delete(); 
               return $this->renderText(json_encode("Proyecto eliminado"));
            }else{
               return $this->renderText(json_encode("Error intentando eliminar proyecto"));
            }
        }
        
	public function executeLista(sfWebRequest $request){
		$resultado = Doctrine_Core::getTable('Proyecto')->buscarProyectoJson($request->getParameter("sSearch"));
		return $this->renderText(json_encode(array(
			"sEcho"=> intval($request->getParameter('sEcho')),
			"iTotalRecords" =>count($resultado), //total de resultados
			"iTotalDisplayRecords" => count($resultado)/*array_slice( , inicio, fin )  */   , //total de resultados a mostrar
			"aaData" => array_slice($resultado,$request->getParameter("iDisplayStart"),$request->getParameter("iDisplayLength")) // arreglo con los resultados a mostrar
		)));
	}

	protected function processForm(sfWebRequest $request, sfForm $form){
		//$respuesta = array("valido"=>false,"mensaje"=>"Error intentando guardar el proyecto");
		$respuesta = "Error intentando guardar el proyecto";
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid()){
			/*$proyecto = */$form->save();
			//$respuesta = array("valido"=> true,"id"=> $proyecto->getIdproyecto());
                        $respuesta = "Proyecto Guardado";
		}
		return $respuesta;
	}
}









