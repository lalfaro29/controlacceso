<style>
    table{
            color: #000000;
            font-family: Arial,Verdana,Tahoma;
            font-size: 90px;
        }
    thead th,tfoot,th{
       /* font-weight: bold;*/
        text-align: center;
        text-transform: uppercase;
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
    tr td {
        text-align: center;
    }
    .encabezado{
        text-align: center;
        text-transform: uppercase;
        text-transform:capitalize;
        vertical-align:bottom;
    }
/*    tbody .tr,tbody .fin {
    border-color: #E5E5E5;
    border-width: 1px 0;
    height: 20px;
    }
    tbody .tr,tbody .fin {
        background-color: #FBFBFB;
        border-top-color: #FBFBFB;
    }
    tbody .tr,tbody .fin {
        -moz-user-select: none;
        border-color: #E5E5E5;
        border-style: solid;
        border-width: 1px 0;
        cursor: pointer;
        height: 18px;
    }*/
</style>


<?php //print $sql ?>
<table border="0" id="cabeera_1" width="100%">
    <tbody>
        <tr>
            <td colspan="2">MINISTERIO DEL PODER POPULAR DE PLANIFICACION Y FINANZAS</td>
            <td colspan="2">REFLEJAR PERIODO DE PAGO</td>
        </tr>
        <tr>
            <td colspan="2">DIRECCION DE RECURSOS HUMANOS</td>
            <td colspan="2"><b>DESDE:</b> <?php echo $fecha_desde ?></td>
        </tr>
        <tr>
            <td colspan="2">RELACION DE HORAS ADICIONALES</td>
            <td colspan="2"><b>HASTA:</b> <?php echo $fecha_hasta ?></td>
        </tr>
    </tbody>
</table><br>
<table border="0" id="cabeera_1" width="100%">
    <tbody>
        <tr>
            <td><b>TURNO:</b></td>
            <td><?php echo date("h:i a",(strtotime($movimiento[0]["Usuario"]["Configuracion"]["horaentrada"]))) ?> a <?php echo date("h:i a",(strtotime($movimiento[0]["Usuario"]["Configuracion"]["horasalida"]))) ?></td>
            <td><b>DEPENDENCIA:</b></td>
            <td><?php echo $movimiento[0]["Usuario"]["Departamento"]["departamento"] ?></td>
        </tr>  
        <tr>
            <td><b>APELLIDO Y NOMBRE:</b></td>
            <td><?php echo $movimiento[0]["Usuario"]["nombre"]. " " . $movimiento[0]["Usuario"]["apellido"]?></td>
            <td><b>CEDULA DE IDENTIDAD:</b></td>
            <td><?php echo $movimiento[0]["Usuario"]["cedula"] ?></td>
        </tr> 
        <tr>
            <td><b>CARGO:</b></td>
            <td><?php echo $movimiento[0]["Usuario"]["Cargo"]["cargo"] ?></td>
            <td><b>TIPO DE PERSONAL:</b></td>
            <td><?php echo $movimiento[0]["Usuario"]["TipoEmpleado"]["empleado"] ?></td>
        </tr> 
        <tr>
            <td coslpan="2"><b>CODIGO NOMINA:</b></td>
            <td coslpan="2"><?php echo $movimiento[0]["Usuario"]["codigo_nomina"];  ?></td>
        </tr>
    </tbody>
</table>
<table border="1" id="contenido" width="100%" style="border-color:white">
        <tr class="encabezado">
            <th width="210">fecha</th>
            <th width="200">día</th>
            <th style="text-align: center">entrada</th>
            <th> -- </th>
            <th>desde Diurno</th>
            <th>hasta Diurno</th> 
            <th>salida</th>
            <th>desde Nococturno</th>
            <th>hasta Noturno</th> 
            <th>Bono Nocturno</th>
            <th>Días de Descanso</th>
            <th>Días Feriados</th>
            <th width="250">Horas Diurnas</th>
            <th width="250">Horas Nocturnas</th>
        </tr>
            <?php $total_HD=0 ?>
            <?php $total_HN=0 ?>
            <?php $total_DF=0 ?>
            <?php $configuracion = $movimiento[0]["Usuario"]["Configuracion"] ?>
            <?php $segundos_jornada = Asistencia::diferencia_horas($configuracion["horaentrada"], $configuracion["horasalida"]); ?>
            <?php $segundos_jd = Asistencia::diferencia_horas($configuracion["horaentrada"], $configuracion["horahastadi"]); ?>
       <?php for($i =0,$j=0;$j<Asistencia::cantidad_dias(Asistencia::cambiarFormatoFecha($fecha_desde,"/"),Asistencia::cambiarFormatoFecha($fecha_hasta,"/"),true);$j++): ?>
            <?php $fin_feriado = (((count($movimiento)>$i)?($movimiento[$i]["registro"]== "DIA FERIADO"):false) ) || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))=="sab" || Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))))=="dom"?>
            <tr class="<?php echo ($fin_feriado)?"fin":"tr" ?>">    
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
                        <?php if($fin_feriado): ?>
                            <!--  Si el tiempo es mayor a los 14400 seg (4 horas)  -->
                            <?php if($jornada_trabajada >= 14400): ?>
                                <?php $total_DF += 1; ?>
                            <?php else: ?>

                            <?php endif; ?>
                        <?php else: ?>
                            <?php if((count($salida))?(Asistencia::diferencia_horas($configuracion["horasalida"],date("H:i:s", (strtotime($salida[0]["fecha"]))))>=0 && ($jornada_trabajada > $segundos_jornada)):false):  ?>
                                <?php if($jornada_trabajada > $segundos_jd): ?>
                                    <?php  $HD = Asistencia::de_segundo_a_hora($segundos_jd-$segundos_jornada); ?>
                                    <?php $total_HD+= $segundos_jd-$segundos_jornada; ?>
                                <?php elseif($jornada_trabajada > $segundos_jornada): ?>
                                    <?php  $HD = Asistencia::de_segundo_a_hora($jornada_trabajada-$segundos_jornada); ?>
                                    <?php $total_HD+= $jornada_trabajada-$segundos_jornada; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if((count($salida))?($jornada_trabajada >$segundos_jd):false ): ?>
                            <?php $total_HN += $jornada_trabajada-$segundos_jd; ?>
                            <?php $HN= Asistencia::de_segundo_a_hora($jornada_trabajada-$segundos_jd); ?>
                        <?php endif; ?>
                        <td width="210"><?php echo date("d-m-Y", (strtotime($movimiento[$i]["fecha"]))) ?></td>
                        <td width="200"><?php echo Asistencia::Dia_semana(date("D", (strtotime($movimiento[$i]["fecha"]))),true) ?></td>
                        <td><?php echo date("h:i a", (strtotime($movimiento[$i]["fecha"]))) ?></td>
                        <td><?php echo ($jornada > 0)?Asistencia::diferencia_horas(date("H:i a", (strtotime($movimiento[$i]["fecha"]))),date("H:i a",strtotime($configuracion["horaentrada"])),true):""; ?></td>
                        <td><?php echo date("h:i a", (strtotime($configuracion["horadesdedi"]))) ?></td>
                        <td><?php echo date("h:i a", (strtotime($configuracion["horahastadi"]))) ?></td>
                        <td><?php echo (count($salida))?date("h:i a", (strtotime($salida[0]["fecha"]))):"--" ?></td>
                        <td><?php echo date("h:i a", (strtotime($configuracion["horadesdeno"]))) ?></td>
                        <td><?php echo date("h:i a", (strtotime($configuracion["horahastano"]))) ?></td>
                        <td></td>
                        <td></td>
                        <td><?php echo (($jornada_trabajada >= 14400) && $fin_feriado)?"1":"" ?></td>
                        <td width="250"><?php echo $HD; ?></td>
                        <td width="250"><?php echo $HN;$i++ ?></td>
                <?php else: ?>
                    <td widtd="210"><?php echo date("d-m-Y",((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))) ?></td>
                    <td widtd="200"><?php echo Asistencia::Dia_semana(date("D", ((strtotime(Asistencia::cambiarFormatoFecha($fecha_desde,"/")))+($j*86400))),true) ?></td>
                    <th></th>
                    <th></th>
                    <td><?php echo date("h:i a", (strtotime($configuracion["horadesdedi"]))) ?></td>
                    <td><?php echo date("h:i a", (strtotime($configuracion["horahastadi"]))) ?></td> 
                    <th></th>
                    <td><?php echo date("h:i a", (strtotime($configuracion["horadesdeno"]))) ?></td>
                    <td><?php echo date("h:i a", (strtotime($configuracion["horahastano"]))) ?></td>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th width="250"></th>
                    <th width="250"></th>
                <?php endif; ?>
            </tr>
        <?php endfor ?>
</table>    
<br>
<table border="0" id="contenido" width="100%" style="border-color:white">
    <tbody>
        <tr>
            <td colspan="2">CONFORME SUPERVISOR INMEDIATO:<br>Observación:</td>
            <td colspan="2">DIRECTOR LINEA:</td>
            <td colspan="2">DIRECTOR GENERAL:</td>
            <td>TOTAL BN</td>
            <td>TOTAL DD</td>
            <td>DF <?php echo $total_DF ?></td>
            <td>HD <?php echo ($total_HD)?Asistencia::de_segundo_a_hora($total_HD):"0h:0m:0s" ?></td>
            <td>HN <?php echo ($total_HN)?Asistencia::de_segundo_a_hora($total_HN):"0h:0m:0s"  ?></td>
        </tr>
    </tbody>
</table>    
