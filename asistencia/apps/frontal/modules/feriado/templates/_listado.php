<table cellpadding="0" cellspacing="0" border="0" class="display selecion_td" id="listado_feriados">
  <thead>
    <tr>
      <?php if(isset($botones)):  ?>
        <th width="1%">&nbsp;</th>
      <?php endif; ?>
      <th width="45%">Feriado</th>
      <th width="35%">Fecha</th>
      <th width="10%">Porcentaje Diurno</th>
      <th width="10%">Porcentaje nocturno</th>
    </tr>
  </thead>
</table>
<?php if(isset($botones)):  ?>
    <center>
                <input type="button" name="cerrar_feriado" id="cerrar_feriado" value="CERRAR">
                <input type="button" name="cargar_feriado" id="cargar_feriado" value="CARGAR">
                <input type="button" name="todo_feriado" id="todo_feriado" value="SELECCIONAR TODO">
    </center>
<?php endif; ?>
