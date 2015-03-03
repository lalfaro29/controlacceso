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
</style>
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
            <td><?php echo date("h:i a",(strtotime($movimiento->getConfiguracion()->getHoraentrada()))) ?> a <?php echo date("h:i a",(strtotime($movimiento->getConfiguracion()->getHorasalida()))) ?></td>
            <td><b>DEPENDENCIA:</b></td>
            <td><?php echo $movimiento->getDepartamento()->getDepartamento() ?></td>
        </tr>  
        <tr>
            <td><b>APELLIDO Y NOMBRE:</b></td>
            <td><?php echo $movimiento->getNombre() . " " . $movimiento->getApellido() ?></td>
            <td><b>CEDULA DE IDENTIDAD:</b></td>
            <td><?php echo $movimiento->getCedula() ?></td>
        </tr> 
        <tr>
            <td><b>CARGO:</b></td>
            <td><?php echo $movimiento->getCargo()->getCargo() ?></td>
            <td><b>TIPO DE PERSONAL:</b></td>
            <td><?php echo $movimiento->getTipoEmpleado()->getEmpleado() ?></td>
        </tr> 
        <tr>
            <td coslpan="2"><b>CODIGO:</b></td>
            <td coslpan="2"><?php echo str_pad($movimiento->getIddepartamento(), 3, "0", STR_PAD_LEFT);  ?></td>
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


