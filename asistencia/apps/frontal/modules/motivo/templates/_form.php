<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form id="motivo_form" method="post">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" >
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['motivo']->renderLabel() ?>:</th>
        <td>
          <?php echo $form['motivo']->renderError() ?>
          <?php echo $form['motivo'] ?>
        </td>
      </tr>
    </table>  
    <center>
        <?php echo $form->renderHiddenFields() ?> 
        <input type="button" name="eliminar_motivo" id="eliminar_motivo" value="ELIMINAR" disabled="disabled" class="boton_inactivo">
        <input type="button" name="guardar_motivo" id="guardar_motivo" value="GUARDAR">
        <input type="button" name="cancelar_motivo" id="cancelar_motivo" value="CANCELAR">
        <input type="button" name="salir_motivo" id="salir_motivo" value="SALIR">
    </center>  
</form>
<?php include_partial('lista', array('form' => $form)) ?>
