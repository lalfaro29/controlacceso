<?php include_partial('hola', array('form' => $form,'formTipoUsuario'=>$formTipoUsuario)) ?>
<?php include_partial('listado') ?>
<script type="text/javascript">
    function eliminar_usuario(id){
        var confirmacion = confirm('¿Está seguro que desea eliminar la cuenta de este usuario?. Puede crear otra cuando usted lo desee.');

        if (confirmacion){
//            alert("En mantenimiento. "+id);
            $.ajax({
                url: '<?php echo url_for(@usuario_eliminar_usuario) ?>',
                data:"idUsuario="+id,
                dataType:"json",
                success: function(resultado){
                    alert(resultado.mensaje);
                    window.location=window.location
                }
            });
        }
    }
    
    function habilitar_usuario(id){
        var confirmacion = confirm('¿Está seguro que desea habilitar éste usuario?. Puede deshabilitarlo cuando usted lo desee.');

        if (confirmacion){
//            alert("En mantenimiento. "+id);
            $.ajax({
                url: '<?php echo url_for(@usuario_habilitar) ?>',
                data:"idUsuario="+id,
                dataType:"json",
                success: function(resultado){
                    alert(resultado.mensaje);
                    window.location=window.location
                }
            });
        }
    }
    $(document).ready(function(){
        $("#usuario_nombre").attr("readOnly","readOnly");
        $("#usuario_apellido").attr("readOnly","readOnly");
        $("#usuario_cedula").attr("readOnly","readOnly");
        $("#usuario_idtipoempleado").attr("disabled","disabled");
        $("#usuario_idcargo").attr("disabled","disabled");
        $("#usuario_iddepartamento").attr("disabled","disabled");
        $("#usuario_sueldo").attr("readOnly","readOnly");
        $("#usuario_idsede").attr("disabled","disabled");
        $("#usuario_fechaingreso").attr("readOnly","readOnly");
        $("#usuario_idproyecto").attr("disabled","disabled");
        $("#usuario_idconfiguracion").attr("disabled","disabled");
        $("#usuario_codigo_nomina").attr("readOnly","readOnly");
        
        $( "#eliminar_empleado" ).click(function(){
            if(confirm("¿realmente desea eliminar el usuario?")){
                $.ajax({
                        url: '<?php echo url_for(@usuario_eliminar_usuario) ?>',
                        data:"idusuario="+$("#usuario_idusuario").val(),
                        dataType:"json",
                        success: function( resultado ) {
                                if(resultado.valido == true){
                                    if(listado){
                                        listado.fnDraw()
                                    }
                                }
                                    limpiar_empleado();
                                alert(resultado.mensaje);
                        }
                });
            }
        })
        
        $("#guardar_empleado").click(function(){
            if(!$("#usuario_idusuario").val() || $("#usuario_idusuario").val()=="null" || $("#usuario_idusuario").val() ==""){
                alert("debe seleccionar un empleado del listado")
            }else  if($("#tipo_usuario_idtipousuario option:selected").val()=="null"){
                alert("debe seleccionar un tipo de usuario")
            }else{
                usuario = $("#usuario_idusuario").val();
                tu      = $("#tipo_usuario_idtipousuario option:selected").val();
                idus    = $("#usuario_idusuario_sistema").val();
                TINY.box.show({
                        url:'<?php echo url_for(@usuario_confirmar_clave) ?>',
                            height: 140,
                            width: 390,
                        openjs:function(){
                            $("#guardar_confirmacion").click(function(evento){
                                    evento.preventDefault();
                                    clave= $("#clave").val();
                                    confirmacion= $("#confirmacion").val();
                                    if(clave =="" ){
                                        alert("debe seleccionar una clave valida")
                                    }else if(clave != confirmacion){
                                        alert("la confirmacion no es valida")
                                    }else{
                                        $.ajax({
                                                url: '<?php echo url_for(@usuario_registrar_usuario) ?>',
                                                data:"idusuario="+usuario+"&clave="+clave+"&idtipousuario="+tu+"&idusuariosistema="+idus,
                                                dataType:"json",
                                                success: function( resultado ) {
                                                        TINY.box.hide();
                                                        limpiar_empleado();
                                                        alert(resultado.mensaje);
                                                        if(listado){
                                                            listado.fnDraw()
                                                        }
                                                }
                                        });
                                    }
                            });
                            $("#cancelar").click(function(){
                                TINY.box.hide();
                            })
                        }
                    });  
            }     
        })
    })
    
</script>    