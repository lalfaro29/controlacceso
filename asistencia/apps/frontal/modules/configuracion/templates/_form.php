<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form id="configuracion_form" method="post">
    <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin-top:8em;width:80%" class="display" >
        <tr>
            <th>Hora de entrada</th>
            <td><?php echo $form["horaentrada"]->render() ?></td>
            <td></td>
            <th>Hora de salida</th>
            <td><?php echo $form["horasalida"]->render() ?></td>
            <td></td>
        </tr>
        <tr>
            <th>Limite entrada</th>
            <td><?php echo $form["horamaxentrada"]->render() ?> Minutos</td>
            <td></td>
            <th>sede</th>
            <td><?php echo $form["idsede"]->render() ?></td>
            <td></td>
        </tr>
        <tr>
            <th>Ticket por Dia</th>
            <td><?php echo $form["cestatique_x_jornada"]->render() ?></td>
            <td></td>
            <th>Precio ticket</th>
            <td><?php echo $form["precioticks"]->render() ?></td>
            <td></td>
        </tr>
        <tr>
            <th>Hora de inicio</th>
            <td><?php echo $form["horadesdedi"]->render() ?></td>
            <td></td>
            <th>Hora de fin</th>
            <td><?php echo $form["horahastadi"]->render() ?></td>
            <td></td>
        </tr>
        <tr>
            <th colspan="6">Porcentaje de pago por hora
                <?php echo $form["porcentajedi"]->render() ?>
            </th>
        </tr>
        <tr>
            <th>Hora de inicio</th>
            <td><?php echo $form["horadesdeno"]->render() ?></td>
            <td></td>
            <th>Hora de fin</th>
            <td><?php echo $form["horahastano"]->render() ?></td>
            <td></td>
        </tr>
        <tr>
            <th colspan="6">Porcentaje de pago por hora
                <?php echo $form["porcentajeno"]->render() ?>
            </th>
        </tr> 
    </table>  
            <center>
                <?php echo $form->renderHiddenFields() ?> 
                <input type="button" name="eliminar_configuracion" id="eliminar_configuracion" value="ELIMINAR" disabled="disabled" class="boton_inactivo">
                <input type="button" name="guardar_configuracion" id="guardar_configuracion" value="GUARDAR">
                <input type="button" name="agregar_feriado" id="agregar_feriado" value="AGREGAR FERIADO" disabled="disabled" class="boton_inactivo">
                <input type="button" name="cancelar_configuracion" id="cancelar_configuracion" value="CANCELAR">
            </center>  
</form>   

<script type="text/javascript">
    $('#configuracion_horaentrada').ptTimeSelect();
    $('#configuracion_horasalida').ptTimeSelect();
    $('#configuracion_horadesdedi').ptTimeSelect();
    $('#configuracion_horahastadi').ptTimeSelect();
    $('#configuracion_horadesdeno').ptTimeSelect();
    $('#configuracion_horahastano').ptTimeSelect();
    
    
    $("#guardar_configuracion").click(function(){
        if($("#configuracion_horaentrada").val() ==""){
            alert("debe indicar una hora de llegada valida")
        }else if($("#configuracion_horasalida").val() ==""){
            alert("debe indicar una hora de salida valida")
        }else if($("#configuracion_idsede option:selected").val() == "null"){
            alert("debe seleccionar la sede a la cual se aplicara la configuracion")
        }else if($("#configuracion_horadesdedi").val() == ""){
            alert("debe indicar la hora extra de inicio diurno")
        }else if($("#configuracion_horahastadi").val() == ""){
            alert("debe indicar la hora extra de cierre diurno")
        }else if($("#configuracion_horadesdeno").val() == ""){
            alert("debe indicar la hora extra de inicio nocturna")
        }else if($("#configuracion_horahastano").val() == ""){
            alert("debe indicar la hora extra de cierre nocturna")
        }else{
                $.ajax({
                        url: '<?php echo url_for(@configuracion_registrar) ?>',
                        data:$("#configuracion_form").serialize(),
                        dataType:"json",
                        type: "POST",
                        success: function( resultado ) {
                                if(resultado.valido == true){
                                    limpiar_configuracion();
                                }
                                alert(resultado.mensaje);
                        }
                }); 
        }
    });
    $("#eliminar_configuracion").click(function(){
        configuracion = $("#configuracion_idconfiguracion").val()
        if(configuracion){
            if(confirm("¿realmente desea eliminar la configuración?")){
                    $.ajax({
                            url: '<?php echo url_for(@configuracion_eliminar) ?>',
                            data:"configuracion="+configuracion,
                            dataType:"json",
                            type: "POST",
                            success: function( resultado ) {
                                    alert(resultado);
                                    limpiar_configuracion()
                            }
                    });
            }
        }else{
            alert("debe seleccionar una configuracion valida")
        }
    })
    
    $("#agregar_feriado").click(function(){
            TINY.box.show({
                    url:'<?php echo url_for(@configuracion_lista_feriados) ?>',
                    height: 333,
                    width: 850,
                    openjs:function(){
                        var lista_feriado = $('#listado_feriados').dataTable( {
                                            "bProcessing": true,
                                            "bServerSide": true,
                                            "sAjaxSource": "<?php echo url_for('@feriado_lista') ; ?>",
                                            "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }],
                                            //"sPaginationType": "full_numbers",
                                            "bJQueryUI": true,
                                            "iDisplayLength":3,
                                            "bLengthChange": false,
                                            "bFilter": true,
                                            "aaSorting": [[1, 'asc']],
                                            "fnServerData": function ( sSource, aoData, fnCallback ) {
                                                    aoData.push( { "name": "funcion", "value": "cargar_feriado" } );
                                                    aoData.push( { "name": "agregar", "value": "true" } );
                                                    $.ajax( {
                                                            "dataType": 'json', 
                                                            "type": "POST", 
                                                            "url": sSource, 
                                                            "data": aoData, 
                                                            "success": fnCallback
                                                    } );
                                            }
                                    } );
                        $("#cerrar_feriado").click(function(){
                            TINY.box.hide();
                        })
                        $("#todo_feriado").click(function(){
                            selecciondos = lista_feriado.$('input:checkbox:checked').size()
                            lista_feriado.$("input:checkbox").each(function(){
                                    if(selecciondos){
                                        $(this).removeAttr("checked")
                                    }else{
                                        $(this).attr("checked","checked")
                                    }
                            });
                            if(selecciondos){
                                $(this).val("SELECCIONAR TODOS")
                            }else{
                                $(this).val("QUITAR TODOS")
                            }
                            //TINY.box.hide();
                        })
                        $("#cargar_feriado").click(function(){ 
                           // var sData = lista_feriado.$('input:checkbox:checked').serialize();
                           if($("#configuracion_idconfiguracion").val()){
                                $.ajax({
                                        url: '<?php echo url_for(@configuracion_guardar_feriado) ?>',
                                        data:lista_feriado.$('input:checkbox:checked').serialize()+"&idconfiguracion="+$("#configuracion_idconfiguracion").val(),
                                        dataType:"json",
                                        type: "POST",
                                        success: function( resultado ) {
                                                TINY.box.hide();
                                                alert(resultado);
                                                buscar_feriados()
                                        }
                                });
                           }else{
                               alert("debe seleccionar una configuracion valida")
                           }
                           // TINY.box.hide();
                        })
                    }

            });
    })
    
    function eliminar_feriado(feriado){
        configuracion = $("#configuracion_idconfiguracion").val()
        if(feriado && configuracion){
            if(confirm("¿realmente desea eliminar el dia feriado de la configuracion?")){
                    $.ajax({
                            url: '<?php echo url_for(@configuracion_eliminar_feriado) ?>',
                            data:"feriado_id="+feriado+"&configuracion="+configuracion,
                            dataType:"json",
                            type: "POST",
                            success: function( resultado ) {
                                    alert(resultado);
                                    buscar_feriados()
                            }
                    });
            }
        }else{
            alert("debe seleccionar un dia feriado valido")
        }
    }
</script>    