<div>
    <style type="text/css">
        table{
                color: #000000;
                font-family: Arial,Verdana,Tahoma;
                font-size: 90px;
            }
        thead th,tfoot,th{
        /* font-weight: bold;*/
            text-align: center;
            text-transform: lowercase;
        }
        table td{
            text-align: left;
        }
        .fin{
            /*border: 2px solid #333366;*/
            background-color: #4E6CA3;
            color:white;
        }
        .tr{
            background-color: #DDDDDD;
        }
        thead{
            border: 1px;
        }
    </style>    
    <table align="center" width="2500">
        <tr>
            <th align="left" width="500"><b>Turno: </b></th>
            <td align="left">08:00 AM a 04:00 PM</td>
            <th align="left" width="400"><b>Dependencia: </b></th>
            <td align="left" width="1200"><?php echo $movimiento->getDepartamento()->getDepartamento() ?></td>
        </tr>
        <tr>
            <th align="left" width="500"><b>Apellido y Nombre: </b></th>
            <td align="left"><?php echo $movimiento->getNombre() . " " . $movimiento->getApellido() ?></td>
            <th align="left" width="400"><b>Cedula: </b></th>
            <td align="left"><?php echo $movimiento->getCedula() ?></td>
        </tr>
        <tr>
            <th align="left" width="500"><b>Tipo Empleado: </b></th>
            <td align="left"><?php echo $movimiento->getTipoEmpleado()->getEmpleado() ?></td>
            <th align="left" width="400"><b>Fecha: </b></th>
            <td align="left"><?php echo date("d/m/Y h:i a") ?></td>
        </tr>
    <?php if (isset($entrada) && $entrada != "" && isset($salida) && $salida != ""): ?>
        <tr>
            <td colspan="4" align="left"><b>Del </b> <?php echo Asistencia::cambiarFormatoFecha($entrada,"/") ?> <b>al</b> <?php echo Asistencia::cambiarFormatoFecha($salida,"/") ?></td>
        </tr>    
    <?php endif; ?>
    </table><br><br>
    <table align="center" width="2500" border="2" >
        <thead>
            <tr>
                <th width="210"><b>Fecha</b></th>
                <th width="200"><b>Dia</b></th>
                <th width="220"><b>Entrada</b></th>
                <th width="220"><b>Salida</b></th>
                <th width="230"><b>Hora extra Diurna</b></th>
                <th width="230"><b>Hora extra Nocturna</b></th>
                <th width="900"><b>Motivo Entrada Retrasada</b></th>
                <th width="900"><b>Motivo Salida Adelantada</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $segundos = 0; ?>
            <?php $retraso_segundos = 0; ?>
            <?php $adelanto_segundos = 0; ?>
            <?php $finSemana = 0; ?>
            <?php $feriado = 0; ?>
            <?php $hed = 0; ?>
            <?php $hen = 0; ?>
            <?php $diasPermiso = 0; ?>
            <?php $horasPermiso = 0; ?>
            <?php $fecha_inicial = ""; ?>
            <?php $inasistencia=0; ?>   
            <?php $configuracion = $movimiento->configuracion() ?>
            <?php $segundos_jd = Asistencia::diferencia_horas($configuracion->getHoraentrada(), $configuracion->getHorahastadi()); ?>
            <?php $segundos_jornada = Asistencia::diferencia_horas(Asistencia::modificar_hora($configuracion->getHoraentrada()), $configuracion->getHorasalida()); ?>
            <?php $mov = $movimiento->registroMovimientos(Asistencia::cambiarFormatoFecha($entrada,"/","-"),Asistencia::cambiarFormatoFecha($salida,"/","-")); ?>
             <?php for($i =0,$j=0;$j<Asistencia::cantidad_dias(Asistencia::cambiarFormatoFecha($entrada,"/"),Asistencia::cambiarFormatoFecha($salida,"/"),true);$j++): ?>
                <?php //foreach ($movimiento->registroMovimientos($entrada, $salida) as $i => $mov): ?>
                <tr class="<?php echo ((((count($mov)>$i)?($mov[$i]['registroentrada']== "DIA FERIADO"):false) ) || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))))=="sab" || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))))=="dom" )?"fin":"tr"?>">    
                    <?php if((count($mov)>$i)?(date("d-m-Y",((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400)))==date("d-m-Y", (strtotime($mov[$i]["fechaentrada"])))):false ): ?>
                                <?php if (!$i): ?>
                                    <?php $fecha_inicial = date("d-m-Y", (strtotime($mov[$i]["fechaentrada"]))) ?>
                                <?php endif; ?>
                            <?php $horas = Asistencia::comparar_horas(Asistencia::modificar_hora($configuracion->getHoraentrada(), ((INT) $configuracion->getHoramaxentrada())), date("h:i:s a", (strtotime($mov[$i]["fechaentrada"])))); ?>
                            <?php $retraso_segundos += ($horas < 0 && $mov[$i]["registroentrada"] != "DIA FERIADO" && $mov[$i]["registroentrada"] != "FIN DE SEMANA") ? Asistencia::diferencia_horas(Asistencia::modificar_hora($configuracion->getHoraentrada(), ((INT) $configuracion->getHoramaxentrada())), date("H:i:s", (strtotime($mov[$i]["fechaentrada"])))) : 0 ?>
                            <?php $segundos += Asistencia::diferencia_horas(date("H:i:s", (strtotime($mov[$i]["fechaentrada"]))), date("H:i:s", (strtotime($mov[$i]["fechasalida"])))); ?>
                            <?php $finSemana += (Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))))=="sab" || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))))=="dom" )?1:0; ?>
                            <?php $segundos_trabajo = Asistencia::diferencia_horas(date("H:i:s", (strtotime($mov[$i]["fechaentrada"]))), date("H:i:s", (strtotime($mov[$i]["fechasalida"])))); ?>
                            <?php $adelanto_segundos += ($segundos_trabajo < $segundos_jornada && $mov[$i]["registroentrada"] != "DIA FERIADO" && $mov[$i]["registroentrada"] != "FIN DE SEMANA") ? ($segundos_jornada - $segundos_trabajo) : 0 ?>
                            <?php $feriado += ($mov[$i]["registroentrada"] == "DIA FERIADO") ? 1 : 0; ?>
                            <?php $jornada_trabajada = Asistencia::diferencia_horas($entrada,date("H:i a", (strtotime($mov[$i]["fechasalida"])))); ?>
                            <?php if(($mov[$i]["fechasalida"])?(Asistencia::diferencia_horas($configuracion->getHorasalida(),date("H:i:s", (strtotime($mov[$i]["fechasalida"]))))>=0 && ($jornada_trabajada > $segundos_jornada)):false):  ?>
                                <?php if($jornada_trabajada > $segundos_jd): ?>
                                    <?php  $HD = Asistencia::de_segundo_a_hora($segundos_jd-$segundos_jornada); ?>
                                    <?php $total_HD+= $segundos_jd-$segundos_jornada; ?>
                                <?php elseif($jornada_trabajada > $segundos_jornada): ?>
                                    <?php  $HD = Asistencia::de_segundo_a_hora($jornada_trabajada-$segundos_jornada); ?>
                                    <?php $total_HD+= $jornada_trabajada-$segundos_jornada; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <td width="210"><?php echo date("d-m-Y", (strtotime($mov[$i]["fechaentrada"]))) ?></td>
                            <td width="200"><?php echo Asistencia::Dia_semana(date("D", (strtotime($mov[$i]["fechaentrada"]))),true) ?></td>
                            <td width="220"><?php echo date("h:i a", (strtotime($mov[$i]["fechaentrada"]))) ?></td>
                            <td width="220"><?php echo ($mov[$i]["fechasalida"])?date("h:i a", (strtotime($mov[$i]["fechasalida"]))):"--" ?></td>
                            <th width="230">
                                <?php if (strtotime($configuracion->getHoraentrada()) > strtotime(date("h:i:s a", strtotime($mov[$i]["fechaentrada"])))): ?>
                                    <?php echo Asistencia::diferencia_horas(date("H:i:s", (strtotime($mov[$i]["fechaentrada"]))), date("H:i:s", (strtotime($configuracion->getHoraentrada()))),true) ?>
                                    <?php $hed += Asistencia::diferencia_horas(date("H:i:s", (strtotime($mov[$i]["fechaentrada"]))), date("H:i:s", (strtotime($configuracion->getHoraentrada())))) ?>
                                <?php else: ?>
                                    0h:0m:0s
                                <?php endif; ?>
                            </th>
                            <th width="230">
                                <?php if (strtotime(date("h:i:s a", strtotime($mov[$i]["fechasalida"]))) > strtotime($configuracion->getHorasalida())): ?>
                                    <?php echo Asistencia::diferencia_horas(date("H:i:s", (strtotime($configuracion->getHorasalida()))),date("H:i:s", (strtotime($mov[$i]["fechasalida"]))),true) ?>
                                    <?php $hen += Asistencia::diferencia_horas(date("H:i:s", (strtotime($configuracion->getHorasalida()))),date("H:i:s", (strtotime($mov[$i]["fechasalida"])))) ?>
                                <?php else: ?>
                                    0h:0m:0s
                                <?php endif; ?>
                            </th>
                            <td width="900" style="text-align:center"><?php echo isset($mov[$i]["motivoentrada"]) ? Asistencia::limitar_caracteres($mov[$i]["motivoentrada"],70) : "&nbsp;" ?></td>
                            <td width="900" style="text-align:center"><?php echo isset($mov[$i]["motivosalida"]) ?  Asistencia::limitar_caracteres($mov[$i]["motivosalida"] ,70) : "&nbsp;" ?></td>
                            <?php ;$i++ ?>
                     <?php else: ?>
                            <?php if(Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))))!="sab" && Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))))!="dom"): ?>
                                <?php $inasistencia++; ?>   
                            <?php endif; ?>
                        <td width="210"><?php echo date("d-m-Y",((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))) ?></td>
                        <td width="200"><?php echo Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($entrada,"/")))+($j*86400))),true) ?></td>
                        <th width="220"><b></b></th>
                        <th width="220"><b></b></th>
                        <th width="230"><b></b></th>
                        <th width="230"><b></b></th>
                        <th width="900"><b></b></th>
                        <th width="900"><b></b></th>
                    <?php endif; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table><br><br>
    <?php $permisos = $movimiento->listadoPermisos($entrada, $salida) ?>
    <?php if ($permisos->count()): ?>
        <table align="center" width="2000" >       
            <thead>
                <tr>
                    <th colspan="2" width="3000" align="center"><b>Permisos Asignados</b></th>
                </tr>
                <tr>
                    <th width="1000"><b>Fecha</b></th>
                    <th width="2000"><b>Motivo</b></th>
                </tr>
            </thead>
            <tbody>
                <?php //for($i=0;$i<10;$i++): ?>
                <?php foreach ($permisos->execute() as $i => $permiso): ?>
                    <tr <?php echo (!($i % 2)) ? "class=\"tr_1\"" : "class=\"tr_2\"" ?> >
                        <?php if ($permiso->getTipopermiso() == "dias"): ?>
                            <?php $diasPermiso+=Asistencia::cantidad_dias($permiso->getFechadesde(), $permiso->getFechahasta()); ?>
                            <td width="1000">Desde el: <?php echo date("d/m/Y", (strtotime($permiso->getFechadesde()))) ?> hasta <?php echo date("d/m/Y", (strtotime($permiso->getFechahasta()))) ?></td>
                        <?php elseif ($permiso->getTipopermiso() == "parcial"): ?>
                            <?php $horasPermiso +=$permiso->getHoras() ?>
                            <td width="1000"><?php echo date("d/m/Y", (strtotime($permiso->getFechadesde()))) ?> por (<?php echo $permiso->getHoras() ?>)Hrs</td>
                        <?php endif; ?>
                        <td width="2000"><?php echo Asistencia::limitar_caracteres($permiso->getMotivo()->getMotivo(),70) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php //endfor; ?>
            </tbody>
        </table><br>
    <?php endif; ?>
    <table>
        <tr>
            <td><b>Cantidad de Feriados Trabajados: </b><?php echo $feriado; ?></td>
            <td><b>Cantidad de Fines de Semana Trabajados: </b><?php echo $finSemana; ?></td>
        </tr>  
        <tr>
            <td><b>Totales Horas Adelantadas: </b><?php echo Asistencia::de_segundo_a_hora($adelanto_segundos); ?></td>
            <td><b>Totales Horas Retrasadas: </b><?php echo Asistencia::de_segundo_a_hora($retraso_segundos); ?></td>
        </tr> 
        <tr>
            <td><b>Promedio Horas trabajadas : </b><?php echo Asistencia::de_segundo_a_hora(($segundos / ($i + 1))); ?></td>
            <td><b>Cantidad de Inasistencias:</b><?php echo $inasistencia; ?></td>
        </tr> 
        <?php if($horasPermiso || $diasPermiso): ?>
        <tr>
            <td><b>Cantidad de Horas de Permiso: </b><?php echo $horasPermiso; ?></td>
            <td><b>Cantidad de Dias de Permiso: </b><?php echo $diasPermiso; ?></td>
        </tr> 
        <?php endif; ?>
        <tr>
            <td><b>Totales Horas extras Diurnas: </b><?php echo Asistencia::de_segundo_a_hora($hed); ?></td>
            <td><b>Totales Horas extras Nocturnas: </b><?php echo Asistencia::de_segundo_a_hora($hen); ?></td>
        </tr> 
        <tr>
            <td><b>Totales Horas extras: </b><?php echo Asistencia::de_segundo_a_hora(($hed+$hen)); ?></td>
            <td><b>Total Horas trabajadas: </b><?php echo Asistencia::de_segundo_a_hora($segundos); ?></td>
        </tr>   
    </table>    
</div>
