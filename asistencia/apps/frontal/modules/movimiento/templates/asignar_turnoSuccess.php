
<form id="movimiento_form" method="post">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em">
        <tr>
            <th>Turnos:</th>
            <td>
                <select id="turnos" name="turnos">
                    <option value="null">Seleccione el turno</option>
                    <?php foreach($ls_turnos as $id => $turno): ?>
                        <option value="<?php echo $id ?>"><?php echo $turno ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        <tr> 
        <tr>
<!--            <th>Departamento:</th>-->
          <td>
               <input type="hidden" name="departamento" id="departamento" value="<?php echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento(); ?>">
<!--                <select id="departamento" name="departamento">
                    <option value="null">Seleccione el departamento</option>
                    <?php// foreach($ls_departamento as $id => $departamento): ?>
                        <option value="<?php //echo $id ?>"><?php //echo $departamento ?></option>
                    <?php// endforeach; ?>
                </select>-->
            </td>
            
            
        <tr>     
    </table><br><br><br>
    <table cellpadding="0" cellspacing="0" border="0" class="display selecion_td" id="listado_empleados" style="width:100%;">
        <thead>
            <tr>
            <th width="1%">&nbsp;</th>
            <th width="15%">Nombre</th>
            <th width="12%">Cedula</th>
            <th width="20%">Cargo</th>
            <th width="30%">Departamento</th>
            <th width="20%">Configuracion</th>
            </tr>
        </thead>
    </table>
    
    <center>
                <input type="button" value="SELECCIONAR TODOS" id="todo_empleado" name="todo_feriado" >
                <input type="button" name="guardar_asignacion" id="guardar_asignacion" value="GUARDAR">
                <input type="button" name="cancelar_asignacion" id="cancelar_asignacion" value="CANCELAR">
    </center>
</form>
<script type="text/javascript"> 
    $("#departamento").change(function(){
        listado_empleado.fnDraw()
    })
    
    $("#todo_empleado").click(function(){
        selecciondos = listado_empleado.$('input:checkbox:checked').size()
        listado_empleado.$("input:checkbox").each(function(){
                if(selecciondos){
                    $(this).removeAttr("checked")
                }else{
                    $(this).attr("checked","checked")
                }
        });
        if(selecciondos){
            $(this).val("SELECCIONAR TODOS")
        }else{
            $(this).val("     QUITAR TODOS       ")
        }
    })
    
    $("#guardar_asignacion").click(function(){
        turno = $("#turnos option:selected").val()
        if(turno == null || turno =="null"){
            alert("debe seleccionar un turno valido")
        }else{
          empleados = listado_empleado.$('input:checked').serialize();
          if(empleados){
                $.ajax({
                        url: '<?php echo url_for(@movimiento_guardar_turno) ?>',
                        data:empleados+"&turno="+turno,
                        dataType:"json",
                        type: "POST",
                        success: function( resultado ) {
                            alert(resultado)
                            $('#turnos option[value="null"]').attr('selected', 'selected');
                            $('#departamento').val();
                            listado_empleado.fnDraw()
                        }
                })
          }else{
            alert("debe seleccionar un empleado valido")  
          }
        }
    })
    
    listado_empleado = $('#listado_empleados').dataTable( {
                        "bProcessing": true,
                        "bServerSide": false,
                        "sAjaxSource": "<?php echo url_for('@usuario_listado') ; ?>",
                       // "sPaginationType": "full_numbers",
                        "bJQueryUI": true,
                        "iDisplayLength":15,
                        "bLengthChange": false,
                        "bFilter": true,
                        "aaSorting": [[1, 'asc']],
                        "fnServerData": function ( sSource, aoData, fnCallback ) {
                                aoData.push( { "name": "seleccion", "value": true } );
                                aoData.push( { "name": "turno", "value": true } );
                                aoData.push( { "name": "funcion", "value": "void" } );
                                aoData.push( { "name": "departamento_id", "value": $("#departamento").val() } );    
                                $.ajax( {
                                        "dataType": 'json', 
                                        "type": "POST", 
                                        "url": sSource, 
                                        "data": aoData, 
                                        "success": fnCallback
                                } );
                        }
                } );
</script>
    