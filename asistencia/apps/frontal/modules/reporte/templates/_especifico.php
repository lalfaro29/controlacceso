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
            <td align="left"><?php echo date("h:i a",(strtotime($movimiento[0]["Usuario"]["Configuracion"]["horaentrada"]))) ?> a <?php echo date("h:i a",(strtotime($movimiento[0]["Usuario"]["Configuracion"]["horasalida"]))) ?></td>
            <th align="left" width="400"><b>Dependencia: </b></th>
            <td align="left" width="1200"><?php echo $movimiento[0]["Usuario"]["Departamento"]["departamento"] ?></td>
        </tr>
        <tr>
            <th align="left" width="500"><b>Apellido y Nombre: </b></th>
            <td align="left"><?php echo $movimiento[0]["Usuario"]["nombre"]. " " . $movimiento[0]["Usuario"]["apellido"]?></td>
            <th align="left" width="400"><b>Cedula: </b></th>
            <td align="left"><?php echo $movimiento[0]["Usuario"]["cedula"] ?></td>
           
        </tr>
        <tr>
          <th align="left" width="500"><b>Codigo Nomina:</b></th>
          <td align="left"><?php echo $movimiento[0]["Usuario"]["codigo_nomina"] ?></td>   
        
        </tr>
        <tr>
            <th align="left" width="500"><b>Tipo Empleado: </b></th>
            <td align="left"><?php echo $movimiento[0]["Usuario"]["TipoEmpleado"]["empleado"] ?></td>
            <th align="left" width="400"><b>Fecha: </b></th>
            <td align="left"><?php echo date("d/m/Y h:i a") ?></td>
        </tr>
        <tr>
            <td colspan="4" align="left"><b>Del </b> <?php echo $fecha_desde ?> <b>al</b> <?php echo $fecha_hasta ?></td>
        </tr>    
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
            <?php $total_HD=0 ?>
            <?php $total_HN=0 ?>
            <?php $total_DF=0 ?>
            <?php $total_FS=0 ?>
            <?php $inasistencia =0; ?>
            <?php $diasPermiso = 0; ?>
            <?php $horasPermiso = 0; ?>
            <?php $entrada_adelantada = 0; ?>
            <?php $salida_retrasada = 0; ?>
            <?php $total_HT = 0; ?>
            <?php $configuracion = $movimiento[0]["Usuario"]["Configuracion"] ?>
            <?php $segundos_jornada = Asistencia::diferencia_horas($configuracion["horaentrada"], $configuracion["horasalida"]); ?><br><br><br>
            <?php $segundos_jd = Asistencia::diferencia_horas($configuracion["horaentrada"],$configuracion["horahastadi"]); ?><br><br><br>
          <?php for($i =0,$j=0;$j<Asistencia::cantidad_dias(Asistencia::cambiarFormatoFecha($fecha_desde,"/"),Asistencia::cambiarFormatoFecha($fecha_hasta,"/"),true);$j++): ?>
            <?php $fin_feriado = (((count($movimiento)>$i)?($movimiento[$i]["registro"]== "DIA FERIADO"):false) ) || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))=="sab" || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))=="dom"  ?>
            <tr class="<?php echo ($fin_feriado)?"fin":"tr"?>">    
                <?php if((count($movimiento)>$i)?(date("d-m-Y",((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400)))==date("d-m-Y", (strtotime($movimiento[$i]["fecha"])))):false ): ?>
                        <?php $HD = "0h:0m:0s"; ?>
                        <?php $HN = "0h:0m:0s"; ?>
                        <?php $salida = $movimiento[$i]["Usuario"]["Movimiento"] ?>
                        <?php $jornada = Asistencia::diferencia_horas(date("H:i a", (strtotime($movimiento[$i]["fecha"]))),$configuracion["horaentrada"]); ?>
                        <?php if($jornada > 0): ?>
                            <?php $entrada = $configuracion["horaentrada"] ?>
                        <?php else: ?>
                            <?php $entrada = date("H:i a", (strtotime($movimiento[$i]["fecha"]))) ?>
                        <?php endif; ?>
                        <?php $jornada_trabajada = (count($salida))?Asistencia::diferencia_horas($entrada,date("H:i a", (strtotime($salida[0]["fecha"])))):0; ?>
                        <?php //$jornada_trabajada= ($jornada > 0)?$jornada_trabajada-$jornada:$jornada_trabajada ?>
                        <?php if((count($salida))?(Asistencia::diferencia_horas($configuracion["horasalida"],date("H:i:s", (strtotime($salida[0]["fecha"]))))>=0 && ($jornada_trabajada > $segundos_jornada)):false):  ?>
                            <?php if($fin_feriado): ?>
                                <!--  Si el tiempo es mayor a los 14400 seg (4 horas)  -->
                                <?php if($jornada_trabajada >= 14400): ?>
                                    <?php $total_DF += 1; ?>
                                <?php else: ?>
                                <?php if($jornada_trabajada >= 14400): ?>
                                <?php $total_DF += 1; ?>
                            <?php else: ?>
                             <?php if($jornada_trabajada <  14400): ?>
                                    <?php  $HD = Asistencia::de_segundo_a_hora($segundos_jd-$segundos_jornada); ?>
                                    <?php $total_HD+= $segundos_jd-$segundos_jornada; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($jornada_trabajada > $segundos_jd): ?>
                                    <?php  $HD = Asistencia::de_segundo_a_hora($segundos_jd-$segundos_jornada); ?>
                                    <?php $total_HD+= $segundos_jd-$segundos_jornada; ?>
                                <?php elseif($jornada_trabajada > $segundos_jornada): ?>
                                    <?php  $HD = Asistencia::de_segundo_a_hora($jornada_trabajada-$segundos_jornada); ?>
                                    <?php $total_HD+= $jornada_trabajada-$segundos_jornada; ?>
                                <?php endif; ?>
                            <?php endif;?>    
                        <?php endif; ?>
                        <?php if((count($salida))?($jornada_trabajada >$segundos_jd):false ): ?>
                            <?php $total_HN += $jornada_trabajada-$segundos_jd; ?>
                            <?php $HN= Asistencia::de_segundo_a_hora($jornada_trabajada-$segundos_jd); ?>
                        <?php endif; ?>
                        <?php $total_FS += (Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))=="sab" || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))=="dom" )?1:0 ?>
                        <td width="210"><?php echo date("d-m-Y", (strtotime($movimiento[$i]["fecha"]))) ?></td>
                        <td width="200"><?php echo Asistencia::Dia_semana(date("D", (strtotime($movimiento[$i]["fecha"]))),true) ?></td>
                        <td width="220"><?php echo date("h:i a", (strtotime($movimiento[$i]["fecha"]))) ?></td>
                        <td width="220"><?php echo (count($salida))?date("h:i a", (strtotime($salida[0]["fecha"]))):"--" ?></td>
                        <td width="230"><?php echo $HD; ?></td>
                        <td width="230"><?php echo $HN;?></td>
                        <td width="900" style="text-align:center"><?php echo isset($movimiento[$i]["Motivo"]["motivo"]) ? Asistencia::limitar_caracteres($movimiento[$i]["Motivo"]["motivo"],70):"&nbsp;"; ?></td>
                        <td width="900" style="text-align:center"><?php echo count($salida)?Asistencia::limitar_caracteres($salida[0]["Motivo"]["motivo"],70): "&nbsp;"; ?></td>
                        <?php $i++; ?>
                     <?php else: ?>
                            <?php if(Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))!="sab" && Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))!="dom"): ?>
                                <?php $inasistencia++; ?>   
                            <?php endif; ?>
                        <td width="210"><?php echo date("d-m-Y",((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))) ?></td>
                        <td width="200"><?php echo Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))),true) ?></td>
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
    <table>
        <tr>
            <td><b>Cantidad de Feriados Trabajados: </b><?php echo $total_DF; ?></td>
            <td><b>Cantidad de Fines de Semana Trabajados: </b><?php echo $total_FS; ?></td>
        </tr> 
        <tr>
            <td><b>Promedio Horas trabajadas : </b><?php echo ($total_HT)?Asistencia::de_segundo_a_hora($total_HT/$i):"0h:0m:0s" ?></td>
            <td><b>Cantidad de Inasistencias:</b><?php echo $inasistencia ?></td>
        </tr> 
        <tr>
            <td><b>Totales Horas extras Diurnas: </b><?php echo ($total_HD)?Asistencia::de_segundo_a_hora($total_HD):"0h:0m:0s" ?></td>
            <td><b>Totales Horas extras Nocturnas: </b><?php echo ($total_HN)?Asistencia::de_segundo_a_hora($total_HN):"0h:0m:0s"  ?></td>
        </tr> 
        <tr>
            <td><b>Totales Horas extras: </b><?php echo ($total_HD || $total_HN)?Asistencia::de_segundo_a_hora($total_HD+$total_HN):"0h:0m:0s" ?></td>
            <td><b>Total Horas trabajadas: </b><?php echo ($total_HT)?Asistencia::de_segundo_a_hora($total_HT):"0h:0m:0s" ?></td>
        </tr>   
    </table>  
</div>