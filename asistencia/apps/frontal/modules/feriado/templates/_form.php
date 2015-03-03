<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


<form id="feriado_form" method="post">
    <table cellpadding="0" cellspacing="0" border="0" align="center" style="width:80%" class="display" >
        <tr>
            <th colspan="2">Feriado <?php echo $form["feriado"] ?></td>
        </tr>
        <tr>
            <th>Hora de entrada<?php echo $form["feriadohoradesde"] ?></th>
            <th>Hora de salida<?php echo $form["feriadohorahasta"] ?></th>
        </tr>
        <tr>
            <th colspan="2">Tiempo <?php echo $form["un_dia"] ?></th>
        </tr>
        <tr>
            <th>Fecha Inicio <?php echo $form["feriadofechdesde"] ?></th>
            <th>Fecha de Fin &nbsp; <?php echo $form["feriadofechhasta"] ?></th>
        </tr>
        <tr>
            <th>Porc. Diurno <?php echo $form["porcentajeferiado"] ?></th>
            <th>Porc. Nocturno<?php echo $form["porcentajenocturno"] ?></th>
        </tr>
        <tr>
            <th colspan="2">
                <?php echo $form["tomar_anio"] ?>
                <label for="feriados[tomar_anio]">El feriado varia según el año(es dependiente del año)</label>
            </th>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <?php echo $form->renderHiddenFields() ?> 
                <input type="button" name="guardar_feriado" id="guardar_feriado" value="GUARDAR">
                <input type="button" name="eliminar_feriado" id="eliminar_feriado" value="ELIMINAR" disabled="disabled" class="boton_inactivo">
                <input type="button" name="limpiar_feriado" id="limpiar_feriado" value="LIMPIAR">
                <input type="button" name="cancelar_feriado" id="cancelar_feriado" value="CANCELAR">
            </td>
        </tr>
    </table>
</form>
<?php include_partial('listado') ?>