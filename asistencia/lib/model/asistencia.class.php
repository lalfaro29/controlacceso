<?php

class Asistencia{

	static public function slugify($text,$remplazo="_"){
		// reemplazar las no letras o digitos por -
		$text = preg_replace('#[^\\pL\d]+#u',$remplazo, $text);

		// limpiar
		$text = trim($text,$remplazo);

		// transliterar
		if (function_exists('iconv'))
		{
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		}

		// convertir a minuscula
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('#[^-\w]+#', '', $text);

		if (empty($text))
		{
		return 'n'.$remplazo.'a';
		}

		return $text;
	}

	static public function validarCorreo($email){
		$reg = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
		//$reg = "#^(((( [a-z\d]  [\.\-\+_] ?)*) [a-z0-9] )+)\@(((( [a-z\d]  [\.\-_] ?){0,62}) [a-z\d] )+)\.( [a-z\d] {2,6})$#i";
		return preg_match($reg, $email);
	}


	static public function validarFecha($fecha){
		$sep = " [\/\-\.] ";
		$req = "#^(((0? [1-9] |1\d|2 [0-8] ){$sep}(0? [1-9] |1 [012] )|(29|30){$sep}(0? [13456789] |1 [012] )|31{$sep}(0? [13578] |1 [02] )){$sep}(19| [2-9] \d)\d{2}|29{$sep}0?2{$sep}((19| [2-9] \d)(0 [48] | [2468]  [048] | [13579]  [26] )|(( [2468]  [048] | [3579]  [26] )00)))$#";
		return preg_match($reg, $fecha);
	}

	static public function validarIP($ip){
		$val_0_to_255 = "(25 [012345] |2 [01234] \d| [01] ?\d\d?)";
		$reg = "#^($val_0_to_255\.$val_0_to_255\.$val_0_to_255\.$val_0_to_255)$#";
		return preg_match($reg, $ip, $matches);
	}

	static public function validarTelefono($numero){
		//var er_tlf = /^([0-9\s\+\-])+$/
		$reg = "/^([0-9\s\+\-])+$/";
		return preg_match($reg,$numero);
		//return preg_match('/^(\(?[0-9]{3,3}\)?|[0-9]{3,3}[-. ]?)[ ][0-9]{3,3}[-. ]?[0-9]{4,4}$/', $numero);
		//return preg_match("#^\(?\d{3}\)? [\s\.-] ?\d{3} [\s\.-] ?\d{4}$#", $numero);
	}

        static public function  limitar_caracteres($string, $char_limit = 30) {
            // limitar el número de caracteres y devolver solo palabras enteras
            $string = strip_tags($string);
            $orig_str_length = strlen($string);
            $words = explode(' ', $string);
            /*
            $i=0;
            $str_length = 0;
            while ($str_length < $char_limit) {
            $str_length = $str_length + strlen($words[$i])+1;
            $new_words[$i] = $words[$i];
            $i++;
            }*/
            for($i=0,$str_length=0;$str_length<$char_limit,$i<count($words); $i++){
                $str_length = $str_length + strlen($words[$i])+1;
                $new_words[$i] = $words[$i];
            }
            $string = implode(' ', $new_words);

            if (strlen($string) > $char_limit) {
            $new_words = explode(' ', $string);
            $word_count = count($new_words);
            $word_limit = $word_count - 1;
            $string = implode(' ', array_slice($new_words, 0, $word_limit));
            }
            if ($orig_str_length > strlen($string)) { $string = "$string..."; }
            $string = trim ($string);
            return $string;
        }

	static public function limpiarTags($source, $tags = null){
		function clean($matched){
			$attribs =
			"javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|".
			"onmousemove|onmouseout|onkeypress|onkeydown|onkeyup|".
			"onload|class|id|src|style";
		
			$quot = "\"|\'|\`";
			$stripAttrib = "' ($attribs)\s*=\s*($quot)(.*?)(\\2)'i";
			$clean = stripslashes($matched [0] );
			$clean = preg_replace($stripAttrib, '', $clean);
			return $clean;
		}     
 
		$allowedTags='<a><br><b><i><br><li><ol><p><strong><u><ul>';
		$clean = strip_tags($source, $allowedTags);
		$clean = preg_replace_callback('#<(.*?)>#', "clean", $source);
		return $source;
		//ejm:
		//echo limpiarTags("este código es malicioso <script>alert('hola!')</script>");
	}


	static public function convertirBBcode($string){
		$string = strip_tags($string);
		
		$patterns = array(
			"bold" => "#\ [b\] (.*?)\ [/b\] #is",
			"italics" => "#\ [i\] (.*?)\ [/i\] #is",
			"underline" => "#\ [u\] (.*?)\ [/u\] #is",
			"link_title" => "#\ [url=(.*?)] (.*?)\ [/url\] #i",
			"link_basic" => "#\ [url] (.*?)\ [/url\] #i",
			"color" => "#\ [color=(red|green|blue|yellow)\] (.*?)\ [/color\] #is"
		);
		
		$replacements = array(
			"bold" => "<b>$1</b>",
			"italics" => "<i>$1</i>",
			"underline" => "<u>$1</u>",
			"link_title" => "<a href=\"$1\">$2</a>",
			"link_basic" => "<a href=\"$1\">$1</a>",
			"color" => "<span style='color:$1;'>$2</span>"
		);
		return preg_replace($patterns, $replacements, $string);
		//ejm:
		//echo convertirBBcode(" [b] letra negrita [/b] ");
	}

	static public function convertirURL($url){
		$host = "( [a-z\d]  [-a-z\d] * [a-z\d] \.)+ [a-z]  [-a-z\d] * [a-z] ";
		$port = "(:\d{1,})?";
		$path = "(\/ [^?<>\#\"\s] +)?";
		$query = "(\? [^<>\#\"\s] +)?";
		
		$reg = "#((ht|f)tps?:\/\/{$host}{$port}{$path}{$query})#i";
		return preg_replace($reg, "<a href='$1'>$1</a>", $url);
		//ejm:
		//echo convertirURL(" visita http://www.google.com");
	}


	/*function comparar_horas($hora1,$hora2){
		return (strtotime($hora1)-strtotime($hora2));
	}
*/
        static public function combinar_arreglos($arreglo1,$arreglo2){
            $resultado = array();
            foreach($arreglo1 as $variable=> $valor):
                $resultado[$variable]=$valor;
            endforeach;
            foreach($arreglo2 as $variable=> $valor):
                $resultado[$variable]=$valor;
            endforeach;
            return $resultado;
        }
        
        
        static public function hora_select(){
            $hora = array();
            for($i=1;$i<13;$i++):
                $hora[$i]= ($i<10)?"0".$i:$i;
            endfor;
            return $hora;
        }

        static public function minutos_select(){
            $minutos = array();
            for($i=0;$i<61;$i++):
                $minutos[$i]= ($i<10)?"0".$i:$i;
            endfor;
            return $minutos;
        }
        static public function gr_select(){
            return array("am"=>"AM","pm"=>"PM");
        }
        
        static function cuenta_select($desde=0, $hasta=1){
            $cuenta = array();
            for($i=$desde;$i<=$hasta;$i++):
                $cuenta[$i]= ($i<10)?"0".$i:$i;
            endfor;
            return $cuenta;
        }
        
        static function comparar_horas($hora1,$hora2){
        	return (strtotime($hora1)-strtotime($hora2));
	}
        
        static function porcentajeTrabajado($horas,$jornada){
                 return self::redondear_dos_decimal(($horas*100)/$jornada);
	}

	static function contarHoras($fechInicio,$fechaFin){
		return self::redondear_dos_decimal(((strtotime($fechaFin)-strtotime($fechInicio))/60));
	}


	static function comparar_fechas($fecha1,$fecha2,$conHora=false){
		if(!$conHora){
			$fecha1= substr($fecha1,0,10);
			$fecha2= substr($fecha2,0,10);
		}
		return (strtotime($fecha1)-strtotime($fecha2));
	}

	static function modificar_hora($hora,$tiempo=0,$tipo_tiempo='minuto',$modificar='+'){
		switch ($tipo_tiempo):
		    case "hora":
		        $tipo_tiempo='hours';
		    break;
		    case "minuto":
		        $tipo_tiempo='minutes';
		    break;
		    case "segundo":
		        $tipo_tiempo='seconds';
		    break;
	       endswitch;
	       $fechaNueva = strtotime($hora.' '.$modificar.$tiempo.' '.$tipo_tiempo);
	       return date("H:i:s", $fechaNueva);
	}

	static function redondear_dos_decimal($valor) {
		$float_redondeado=round($valor * 100) / 100;
		return $float_redondeado;
	}

        static function cambiarFormatoFecha($fecha,$separador="-",$nuevoSeparador="-"){
            if($fecha){
                list($dia,$mes,$anio)=explode($separador,$fecha);
                return $dia.$nuevoSeparador.$mes.$nuevoSeparador.$anio;
            }else{
                return $fecha;
            }
        } 

        static function cambiarFormatoFechaMDA($fecha,$separador="-",$nuevoSeparador="-"){
            if($fecha){
                list($mes,$dia,$anio)=explode($separador,$fecha); 
                return $anio.$nuevoSeparador.$mes.$nuevoSeparador.$dia;
            }else{
                return $fecha;
            }
        }
        static function cambiarFormatoFechaMDA_2($fecha,$separador="-",$nuevoSeparador="-"){
            if($fecha){
                list($mes,$dia,$anio)=explode($separador,$fecha); 
                return $anio.$nuevoSeparador.$dia.$nuevoSeparador.$mes;
            }else{
                return $fecha;
            }
        }

        static function cambiarFormatoFecha_a_MDA($fecha,$separador="-",$nuevoSeparador="-"){
            if($fecha){
                list($dia,$mes,$anio)=explode($separador,$fecha); 
                return $mes.$nuevoSeparador.$dia.$nuevoSeparador.$anio;
            }else{
                return $fecha;
            }
        }
        
           static function cambiarFormatoFecha_a_MDA_3($fecha,$separador="/",$nuevoSeparador="-"){
            if($fecha){
                list($dia,$mes,$anio)=explode($separador,$fecha); 
                return $anio.$nuevoSeparador.$mes.$nuevoSeparador.$dia;
            }else{
                return $fecha;
            }
        }
        static function Dia_semana($dia,$completo=false){
            switch ($dia){
                case "Mon":
                    return ($completo)?"Lunes":"Lun";
                break;  
                case "Tue":
                    return ($completo)?"Martes":"Mar";
                break; 
                case "Wed":
                    return ($completo)?"Miercoles":"Mie";
                break; 
                case "Thu":
                    return ($completo)?"Jueves":"Jue";
                break; 
                case "Fri":
                    return ($completo)?"Viernes":"vie";
                break; 
                case "Sat":
                    return ($completo)?"Sabado":"sab";
                break; 
                case "Sun":
                    return ($completo)?"Domingo":"dom";
                break; 
            }
            print $completo;
        }
        
        static public function validaData($data,$op){
            switch($op){
                case "d": // Padrao: 15/01/2007
                    $er = "(([0][1-9]|[1-2][0-9]|[3][0-1])\/([0][1-9]|[1][0-2])\/([0-9]{4}))";
                    if(ereg($er,$data)){
                        return 0;
                    }else{
                        return 1;
                    }
                break;
                case "dh": // Padrao 15/01/2007 10:30:00
                    $er = "(([0][1-9]|[1-2][0-9]|[3][0-1])\/([0][1-9]|[1][0-2])\/([0-9]{4})*)";
                    if(ereg($er,$data)){
                        return 0;
                    }else{
                        return 1;
                    }
                break;
            }
        }
        
       static public function diferencia_horas($hora_desde , $hora_hasta ,$horas=false,$formatear=false){
               $desde = self::de_horas_a_segundos($hora_desde);
               $hasta = self::de_horas_a_segundos($hora_hasta);
               $segundos = $hasta-$desde;
           if($horas){
               return self::de_segundo_a_hora($segundos,$formatear);
           }else{
                return $segundos;
           }
    }
    
    static public function de_segundo_a_hora($segundos,$formateado=false) {
        $horas = floor($segundos/3600);
        $minutos = floor(($segundos-($horas*3600))/60);
        $segundos = $segundos-($horas*3600)-($minutos*60);
        $segundos = explode(".", $segundos);
        $segundos = $segundos[0];
        if($formateado){
            return array("horas"=>$horas,"minutos"=>$minutos,"segundos"=>$segundo); 
        }else{
            return $horas.'h:'.$minutos.'m:'.$segundos.'s';
        }

    }
    
    static public function de_horas_a_segundos($hora,$formatear=false){
        $horas = 0;
        $minutos = 0;
        $segundos = 0;
           if($formatear){
                $horas = date("H",(strtotime($horas)));
                $minutos = date("i",(strtotime($horas)));
                $segundos = date("s",(strtotime($horas)));
           }else{
                $tiempo_hasta = explode(":" , $hora);
                foreach($tiempo_hasta as $i => $valor):
                    switch ($i){
                        case 0:
                          $horas = preg_replace("[a-zA-Z]","",$valor);  
                        break; 
                        case 1:
                          $minutos = preg_replace("[a-zA-Z]","",$valor); 
                        break;  
                        case 2:
                          $segundos = preg_replace("[a-zA-Z]","",$valor);
                        break;     
                    }
                endforeach;
           }
           return ((($horas*3600)+($minutos*60))+$segundos);
    }
    
    static public function seg2tiempo($segundos){
        $tiempo=$segundos;
        $signo=($tiempo<0) ?  "-" : "+";
        $tiempo=abs($tiempo);
        $dias=floor($tiempo/86400);
        $resto_dias=$tiempo % 86400;
        $horas=floor($resto_dias/3600);
        $resto_horas=$resto_dias % 3600;
        $minutos=floor($resto_horas/60);
        $resto_minutos=$resto_horas % 60;
        $segundos=floor($resto_minutos);
        return $signo.$dias." d&iacute;as, ".$horas." horas, ".$minutos." minutos, ".$segundos." segundos";
    } 
    
    static public function cantidad_dias($inici,$fin,$contar_fin_semana_semana=false){
        $fechaInicio=strtotime($inici);
        $fechaFin=strtotime($fin);
        $dias = 0;
        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            if($contar_fin_semana_semana){
              $dias++; 
            }else{
                if((self::Dia_semana(date("D",$i))!="sab" && self::Dia_semana(date("D",$i))!="dom")){
                    $dias++; 
                }
            }
        }
        return $dias;  
    }
    
    
    static public function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
    
}
