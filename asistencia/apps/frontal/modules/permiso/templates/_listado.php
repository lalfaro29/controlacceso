<table cellpadding="0" cellspacing="0" border="0" align="center" class="display selecion_td" id="listado_permisos" style="width:100%">
  <thead>
    <tr>
      <th width="3%">&nbsp;</th>
      <th width="3%">&nbsp;</th>
      <th width="30%">Fecha</th>
      <th width="64%">Motivo</th>
    </tr>
  </thead>
</table>
<script type="text/javascript">
    listado_permisos = $('#listado_permisos').dataTable( {
                        "bProcessing": true,
                        "bServerSide": true,
                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1 ] }],
                        "sAjaxSource": "<?php echo url_for('@permiso_listado') ; ?>",
                        //"sPaginationType": "full_numbers",
                        "bJQueryUI": true,
                        "iDisplayLength":15,
                        "bLengthChange": false,
                        "bFilter": false,
                        "aaSorting": [[2, 'asc']],
                        "fnServerData": function ( sSource, aoData, fnCallback ) {
                            <?php if(isset($usuario)): ?>
                                 aoData.push( { "name": "usuario", "value": "<?php echo $usuario ?>" } );
                            <?php endif; ?> 
                                $.ajax( {
                                        "dataType": 'json', 
                                        "type": "POST", 
                                        "url": sSource, 
                                        "data": aoData, 
                                        "success": fnCallback
                                } );
                        }
                } );
  
        function eliminar(permiso){
            if(isNaN(permiso)){
                alert("no es posible eliminar el permiso")
            }else if(confirm("¿ seguro que desea eliminar el permiso ?")){
                        $.ajax({
                                url: '<?php echo url_for(@permiso_eliminar_permiso) ?>',
                                data:"permiso="+permiso,
                                success: function( resultado ) {
                                        alert(resultado);
                                        listado_permisos.fnDraw();
                                }
                        });
            }
        }
        function editar(idpermiso,tiempo,desde,hasta,horas,motivo){
            $("#permiso").val(idpermiso)
            $("#motivo option[value='"+motivo+"']").attr('selected', 'selected');
            $("#tiempo option[value='"+tiempo+"']").attr('selected', 'selected');
            if(tiempo == "parcial"){
                $("#parcial").show()
                $("#dias").hide()
                $("#desde").val("")
                $("#hasta").val("")
                $("#fecha").val(desde)
                $("#horas option[value='"+horas+"']").attr('selected', 'selected');
            }else if(tiempo == "dias"){
                $("#parcial").hide()
                $("#dias").show()
                $("#desde").val(desde)
                $("#hasta").val(hasta)
                $("#fecha").val("")
                $("#horas option:eq(0)").attr("selected", "selected");
            }
            
        }
</script>
