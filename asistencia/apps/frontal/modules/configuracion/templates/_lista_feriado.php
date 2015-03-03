<table cellpadding="0" cellspacing="0" border="0" class="display selecion_td" id="listado_feriado" style="width:100%">  
  <thead>
    <tr>
      <th width="1%" aling="center">&nbsp;</th>
      <th width="50%">Feriado</th>
      <th width="29%">fecha</th>
      <th width="10%">Porc. Diurno</th>
      <th width="10%">Porc. nocturno</th>
    </tr>
  </thead>
</table>
<script type="text/javascript">
    listado_feriado = $('#listado_feriado').dataTable( {
                        "bProcessing": true,
                        "bServerSide": true,
                         "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }],
                        "sAjaxSource": "<?php echo url_for('@configuracion_listado2') ; ?>",
                       // "sPaginationType": "full_numbers",
                        "bJQueryUI": true,
                        "iDisplayLength":3,
                        "bLengthChange": false,
                        "bFilter": true,
                        "aaSorting": [[0, 'asc']],
                        "fnServerParams": function ( aoData ) {
                                aoData.push( { "name": "configuracion_id", "value": $("#configuracion_idconfiguracion").val() } );
                                aoData.push( { "name": "eliminable", "value": "eliminar_feriado" } );
	                    }/*,
                        "fnServerData": function ( sSource, aoData, fnCallback ) {
                                aoData.push( { "name": "configuracion_id", "value": $("#configuracion_idconfiguracion").val() } );
                                aoData.push( { "name": "eliminable", "value": "eliminar_feriado" } );
                                $.ajax( {
                                        "dataType": 'json', 
                                        "type": "POST", 
                                        "url": sSource, 
                                        "data": aoData, 
                                        "success": fnCallback
                                } );
                        }*/
                } );
  
</script>
