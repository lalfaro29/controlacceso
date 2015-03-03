<?php

/**
 * FeriadoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class FeriadoTable extends PluginFeriadoTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object FeriadoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Feriado');
    }


        public function buscarFeriados($buscar=null,$configuracion_id= null,$campo="f.feriado",$ordenar="ASC"){
		$q = Doctrine_Query::create()
                        ->from('Feriado f')
                        ->leftJoin("f.RelacionConfigFeriado rfc");
                if(!is_null($configuracion_id)){
                    $q->andWhere("rfc.idconfiguracion = ?",$configuracion_id);
                }
		if(!is_null($buscar) && $buscar){
			$buscar = explode(" ",$buscar);
                        if(is_array($buscar)){
                            foreach($buscar as $palabra){
                                    $q->andWhere("f.feriado LIKE '%".$palabra."%'");
                                  //  $q->orWhere("u.apellido LIKE '%".$palabra."%'");
                            } 
                        }
		}
		$q->orderBy("$campo $ordenar");
		return $q->execute();
        }
    
    public function buscarFeriadoJson($data,$listado=false){
                $campo="f.feriado";
                switch($data->getParameter("iSortCol_0")):
                     case "0":
                         $campo="f.feriado";
                     break; 
                     case "1":
                         $campo="f.feriadofechdesde";
                     break;
                     case "2":
                         $campo="f.porcentajeferiado";
                     break;
                     case "3":
                         $campo="f.porcentajenocturno";
                     break;  
                endswitch; 
                $funcion = $data->getParameter("funcion","feriado_seleccionar");
                $eliminable = $data->getParameter("eliminable");
                $check = $data->getParameter("agregar");
                $resultados = array();
                if($data->getParameter("configuracion_id","0") || $listado){
                    foreach($this->buscarFeriados($data->getParameter("sSearch",false),(($listado)?null:$data->getParameter("configuracion_id")),$campo,$data->getParameter("sSortDir_0")) as $campo_cn => $feriado):
                        $fecha = ($feriado->getUnDia())?"<b>".date("d-m-Y",(strtotime($feriado->getFeriadofechdesde())))."</b>":"desde el <b>".date("d-m-Y",(strtotime($feriado->getFeriadofechdesde())))."</b> hasta el <b>".date("d-m-Y",(strtotime($feriado->getFeriadofechhasta())))."</b>";
                            $js_feriado = "\"".$feriado->getIdferiado()."\",".
                                        "\"".$feriado->getFeriado()."\"".",\"".date("d-m-Y",(strtotime($feriado->getFeriadofechdesde())))."\",".
                                        "\"".date("d-m-Y",(strtotime($feriado->getFeriadofechhasta())))."\"".",\"".date("h:i a",(strtotime($feriado->getFeriadohoradesde())))."\",".
                                        "\"".date("h:i a",(strtotime($feriado->getFeriadohorahasta())))."\","."\"".$feriado->getPorcentajeferiado()."\",".
                                        "\"".$feriado->getPorcentajenocturno()."\","."\"".$feriado->getUnDia()."\",".
                                        "\"".$feriado->getTomarAnio()."\""; 
                            if($eliminable){
                                $resultados [$campo_cn][] = "<div class='eliminar' style='cursor:pointer' onclick='".$eliminable."(".$feriado->getIdferiado().")'>X</div>";
                            }
                            if($check){
                                $resultados [$campo_cn][] = "<input type='checkbox' name='check_feriado[]' id='check_feriado[]' value='".$feriado->getIdferiado()."' />";
                            }
                            $resultados [$campo_cn][] = "<div class='seleccion_campo' style='cursor:pointer' onclick='".$funcion."(".$js_feriado.")'>".Asistencia::limitar_caracteres($feriado->getFeriado(),45)."</div>";
                            $resultados [$campo_cn][] =Asistencia::limitar_caracteres($fecha,40);
                            $resultados [$campo_cn][] =Asistencia::limitar_caracteres($feriado->getPorcentajeferiado(),10)."%";
                            $resultados [$campo_cn][] =Asistencia::limitar_caracteres($feriado->getPorcentajenocturno(),10)."%".((!$check)?
                                                    "<input type=\"hidden\" id=\"feriado_id\" name=\"feriado_id\" value=\"".$feriado->getIdferiado()."\" >":"");
                    endforeach;
                }
		return $resultados;
    }
    
}
