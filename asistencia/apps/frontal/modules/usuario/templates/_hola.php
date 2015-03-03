<?php //use_stylesheets_for_form($form) ?>
<?php //use_javascripts_for_form($form) ?>


<form id="empleado_form" method="post">
    <table cellpadding="0" cellspacing="0" border="0" style="margin-top:8em" class="display" style="width:85%">
        <tr>
             <th>CEDULA</th>
            <td><?php echo $form["cedula"]->render() ?></td>
            <td></td>
            
            <th>NOMBRE</th>
            
            <td><?php echo $form["nombre"]->render() ?></td>
            <td></td>
            
        </tr>
        <tr>
           <th>APELLIDO</th>
            <td><?php echo $form["apellido"]->render() ?></td>
            <td></td>
            <th>TIPO DE EMPLEADO</th>
            <td>
                <?php echo $form["idtipoempleado"]->render() ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <th>CARGO</th>
            <td>
                <?php echo $form["idcargo"]->render() ?>
            </td>
            <td></td>
            <th>DEPARTAMENTO</th>
            <td>
                <?php echo $form["iddepartamento"]->render() ?>
            </td>
            <td></td>
        </tr>
       <tr>
            <th>CONFIGURACION</th>
            <td>
                <?php echo $form["idconfiguracion"]->render() ?>
            </td>
            <td></td>
            <?php if(isset($formTipoUsuario)): ?>
                <th>Tipo de Usuario:</th>
                <td><?php echo $formTipoUsuario["idtipousuario"]->render() ?></td>
            <?php else: ?>
                <th>IP. DE LA MAQUINA</th>
                <td><?php echo $form["ipusuario"]->render() ?></td>
            <?php endif; ?>
            <td></td>
        </tr>
        <tr>
            <th>SEDE</th>
            <td>
                <?php echo $form["idsede"]->render() ?>
            </td>
            <td></td>
            <th></th>
            <td>
                <?php //echo $form["codigo_nomina"]->render() ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6" align="center" >
                <?php echo $form->renderHiddenFields() ?>
                <?php if(isset($formTipoUsuario)): ?>
                    <input type="hidden" id="usuario_idusuario_sistema" name="usuario_idusuario_sistema"/> 
                <? endif; ?>
                <?php if(!isset($formTipoUsuario)): ?>
<!--                <input type="button" name="buscar_vista" id="buscar_vista" value="BUSCAR REGISTRO"> -->
                <? endif; ?>
                <input type="button" name="eliminar_empleado" id="eliminar_empleado" value="ELIMINAR" disabled="disabled" class="boton_inactivo">
                <input type="button" name="guardar_empleado" id="guardar_empleado" value="<?php echo ((isset($formTipoUsuario))?"CONTRASEÑA":"GUARDAR") ?>">
                <input type="button" name="cancelar_empleado" id="cancelar_empleado" value="CANCELAR">
            </td> 
        </tr>
    </table> 
</form>
<script type="text/javascript">

   $("#cancelar_empleado").click(function(){
        limpiar_campos_empleado();
    })
    
    function limpiar_campos_empleado(){
        $( "#usuario_nombre" ).val("")
        $( "#usuario_apellido" ).val("")
        $( "#usuario_cedula" ).val("")
        $( "#usuario_ipusuario" ).val("")
        //$( "#usuario_fechaingreso" ).val("")
        $( "#usuario_codigo_nomina" ).val("")
        $( "#usuario_idusuario" ).val("")
        $('#usuario_idtipoempleado option[value="null"]').attr('selected', 'selected');
        $('#usuario_idcargo option[value="null"]').attr('selected', 'selected');
        $('#usuario_iddepartamento option[value="null"]').attr('selected', 'selected');
        $('#usuario_idsede option[value="null"]').attr('selected', 'selected');
        //$('#usuario_idproyecto option[value="null"]').attr('selected', 'selected');
        $('#usuario_idconfiguracion option[value="null"]').attr('selected', 'selected');
        if($("#tipo_usuario_idtipousuario")){
            $('#tipo_usuario_idtipousuario option[value="null"]').attr('selected', 'selected');
        }
        $( "#eliminar_empleado" ).addClass("boton_inactivo")
        $( "#eliminar_empleado" ).attr("disabled","disabled")
        $( "#usuario_nombre" ).removeAttr("readonly","readonly")
        $( "#usuario_apellido" ).removeAttr("readonly","readonly")
        $( "#usuario_codigo_nomina" ).removeAttr("readonly","readonly")
    }
 
    
</script>


