<table cellpadding="0" cellspacing="0" border="0" class="display selecion_td" id="listado" style="width:100%">
  <thead>
    <tr>
      <th width="5%">Opcion</th>
      <th width="20%">Nombre</th>
      <th width="10%">Cedula</th>
      <th width="20%">Cargo</th>
      <th width="25%">Departamento</th>
      <th width="20%">Sede</th>
    </tr>
  </thead>
</table>


<script type="text/javascript">
    hola = $('#listado').dataTable( {
                        "bProcessing": true,
                        "bServerSide": false,
                        "sAjaxSource": "<?php echo url_for('@usuario_listado') ; ?>",
                       // "sPaginationType": "full_numbers",
                        "bJQueryUI": true,
                        "iDisplayLength":15,
                        "bLengthChange": false,
                        "bFilter": true,
                        "aaSorting": [[0, 'asc']]
                         <?php if(isset($funcion)): ?>
                         ,"fnServerParams": function ( aoData ) {
		                                    aoData.push( { "name": "funcion", "value": "<?php echo $funcion ?>" } );
		                             }
                          <?php endif; ?>   
                });
                
<?php if(!isset($funcion)): ?>             
    function empleado_seleccionar(id,nombre,apellido,codigo_nomina,cedula,te,cargo,dpto,sueldo,sede,fecha,proyecto,configuracion,ip,tipoUsuario,idusuario){
        $( "#usuario_nombre" ).val(nombre)
        $( "#usuario_apellido" ).val(apellido)
        $( "#usuario_cedula" ).val(cedula)
        $( "#usuario_ipusuario" ).val(ip)
        //$( "#usuario_fechaingreso" ).val(fecha)
        //$( "#usuario_sueldo" ).val(sueldo)
        $( "#usuario_idusuario" ).val(id)
        $( "#usuario_codigo_nomina" ).val(codigo_nomina)
        
       /* $("#empleado_form select[@name=''] option[@selected='selected']").removeAttr("selected"); //deselect all options
        $("#empleado_form select[@name=''] option[@value='']").attr("selected","selected");
        */
        $('#usuario_idtipoempleado option[value="'+te+'"]').attr('selected', 'selected');
        $('#usuario_idcargo option[value="'+cargo+'"]').attr('selected', 'selected');
        $('#usuario_iddepartamento option[value="'+dpto+'"]').attr('selected', 'selected');
        $('#usuario_idsede option[value="'+sede+'"]').attr('selected', 'selected');
       // $('#usuario_idproyecto option[value="'+proyecto+'"]').attr('selected', 'selected');
        $('#usuario_idconfiguracion option[value="'+configuracion+'"]').attr('selected', 'selected');
        
        if($("#tipo_usuario_idtipousuario")){
            $('#tipo_usuario_idtipousuario option[value="'+tipoUsuario+'"]').attr('selected', 'selected');
        }
        if($( "#usuario_idusuario_sistema" )){
            $( "#usuario_idusuario_sistema" ).val(idusuario)
        }
        
        $( "#eliminar_empleado" ).removeClass("boton_inactivo")
        $( "#eliminar_empleado" ).removeAttr("disabled")
    }
    
<?php endif; ?>       
</script>