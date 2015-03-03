<?php include_partial('hola', array('form' => $form)) ?>
<?php include_partial('listado') ?>

<script type="text/javascript">
    function eliminar_usuario(id){
        var confirmacion = confirm('¿Está seguro que desea deshabilitar éste usuario?. Puede habilitarlo cuando usted lo desee.');

        if (confirmacion){
//            alert("En mantenimiento. "+id);
            $.ajax({
                url: '<?php echo url_for(@usuario_deshabilitar) ?>',
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
    $( "#eliminar_empleado" ).click(function(){
        if(confirm("¿realmente desea eliminar el empleado?")){
            $.ajax({
                    url: '<?php echo url_for(@usuario_eliminar) ?>',
                    data:"idusuario="+$("#usuario_idusuario").val(),
                    dataType:"json",
                    success: function( resultado ) {
                            if(resultado.valido == true){
                                   limpiar_campos_empleado();
                                   if(hola){
                                       hola.fnDraw()
                                   }
                            }
                            alert(resultado.mensaje);
                    }
            });
        }
    })
    $( "#buscar_vista" ).click(function(){
        
        if(confirm("¿Buscar empleado?")){
            $.ajax({
                    url: '<?php echo url_for(@usuario_buscar_vista) ?>',
                    data:"usuario_cedula="+$("#usuario_cedula").val(),
                    dataType:"json",
                    success: function( resultado ) {
                        if(resultado.valido==true){
                            $("#usuario_nombre").attr("readOnly","readOnly");
                            $("#usuario_apellido").attr("readOnly","readOnly");
                            $("#usuario_codigo_nomina").attr("readOnly","readOnly");
                            $("#usuario_codigo_nomina").val(resultado.nomina);
                            $("#usuario_nombre").val(resultado.nombre);
                            $( "#usuario_apellido" ).val(resultado.apellido); 
                        } else{
                           alert(resultado.mensaje);
                           limpiar_campos_empleado();
                        }
                      
                    }
            });
        }
    })
    $( "#guardar_empleado" ).click(function(){
        if( $("#usuario_nombre").val() =="" ){
            alert("el nombre del empleado no es valido")
        }else if( $("#usuario_apellido").val() =="" ){
            alert("el apellido del empleado no es valido")
        }else if( $("#usuario_cedula").val() =="" ){
            alert("la cedula del empleado no es valido")
        }else if( $("#usuario_idtipoempleado").val() =="" || isNaN($("#usuario_idtipoempleado").val()) ){
            alert("debe indicar el tipo de empleado")
        }else if( $("#usuario_idcargo").val() =="" || isNaN($("#usuario_idcargo").val()) ){
            alert("debe indicar el cargo")
        }else if( $("#usuario_iddepartamento").val() =="" || isNaN($("#usuario_iddepartamento").val()) ){
            alert("debe indicar el departamento")
        }else if( $("#usuario_idsede").val() =="" || isNaN($("#usuario_idsede").val()) ){
            alert("debe indicar la sede")
        }//else if( $("#usuario_codigo_nomina").val() =="" || isNaN($("#usuario_codigo_nomina").val()) ){
//            alert("el codigo de nomina es invalido")
//      }  
        else if( $("#usuario_idconfiguracion").val() =="" || isNaN($("#usuario_idconfiguracion").val()) ){
            alert("debe indicar la configuracion a la que pertenece")
        }else{
            $.ajax({
                    url: '<?php echo url_for(@usuario_guardar) ?>',
                    data:$("#empleado_form").serialize(),
                    dataType:"json",
                    success: function( resultado ) {
                            if(resultado.valido == true){
                            }
                            limpiar_campos_empleado();
                            if(hola){
                                hola.fnDraw()
                            }
                            alert(resultado.mensaje);
                    }
            });
        }
    })


    
</script>