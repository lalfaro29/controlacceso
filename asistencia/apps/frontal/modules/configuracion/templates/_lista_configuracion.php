<table cellpadding="0" cellspacing="0" border="0" align="center" class="display selecion_td" id="listado_configuracion" style="width:100%">
  <thead>
    <tr>
      <th width="25%">Hora de entrada</th>
      <th width="12%">Hora de salida</th>
      <th width="19%">Limite min.</th>
      <th width="25%">Precio ticket</th>
      <th width="19%">Ticket por Dia</th>
    </tr>
  </thead>
</table>
<script type="text/javascript">
    listado_configuracion = $('#listado_configuracion').dataTable( {
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "<?php echo url_for('@configuracion_listado1') ; ?>",
                       // "sPaginationType": "full_numbers",
                        "bJQueryUI": true,
                        "iDisplayLength":3,
                        "bLengthChange": false,
                        "bFilter": true,
                        "aaSorting": [[0, 'asc']]/*,
                        "fnServerData": function ( sSource, aoData, fnCallback ) {
                                $.ajax( {
                                        "dataType": 'json', 
                                        "type": "POST", 
                                        "url": sSource, 
                                        "data": aoData, 
                                        "success": fnCallback
                                } );
                        }*/
                } );
            
            $("#cancelar_configuracion").click(function(){
                limpiar_configuracion();
            })
            
            
    function configuracion_seleccionar(configuracion_id,horaentrada,horasalida,sede,horamaxentrada,
                precio,cesta_jornada,horadesdedia,horahastadia,horadesdenoche,horahastanoche,
                porcentajedia,porcentajenoche){
        $( "#configuracion_horaentrada" ).val(horaentrada)
        $( "#configuracion_horasalida" ).val(horasalida)
        $( "#configuracion_horamaxentrada" ).val(horamaxentrada)
        $( '#configuracion_idsede option[value="'+sede+'"]').attr('selected', 'selected');
        $( "#configuracion_precioticks" ).val(precio)
        $( "#configuracion_cestatique_x_jornada" ).val(cesta_jornada)
        $( "#configuracion_horadesdedi" ).val(horadesdedia)
        $( "#configuracion_horahastadi" ).val(horahastadia)
        $( "#configuracion_horadesdeno" ).val(horadesdenoche)
        $( "#configuracion_horahastano" ).val(horahastanoche)
        $( "#configuracion_porcentajedi" ).val(porcentajedia)
        $( "#configuracion_porcentajeno" ).val(porcentajenoche)
        $( "#configuracion_idconfiguracion" ).val(configuracion_id)
        
        $( "#agregar_feriado" ).removeClass("boton_inactivo")
        $( "#agregar_feriado" ).removeAttr("disabled")
        
        if(configuracion_id){
            $( "#eliminar_configuracion" ).removeClass("boton_inactivo")
            $( "#eliminar_configuracion" ).removeAttr("disabled") 
        }
        buscar_feriados();
    }
    
    function buscar_feriados(){
            if(listado_feriado){
                listado_feriado.fnDraw()
            }
    }
    
    function limpiar_configuracion(){
        $( "#configuracion_horaentrada" ).val("")
        $( "#configuracion_horasalida" ).val("")
        $( "#configuracion_horamaxentrada" ).val("")
        $( '#configuracion_idsede option[value="null"]').attr('selected', 'selected');
        $( "#configuracion_precioticks" ).val("")
        $( "#configuracion_cestatique_x_jornada" ).val("")
        $( "#configuracion_horadesdedi" ).val("")
        $( "#configuracion_horahastadi" ).val("")
        $( "#configuracion_horadesdeno" ).val("")
        $( "#configuracion_horahastano" ).val("")
        $( "#configuracion_porcentajedi" ).val("")
        $( "#configuracion_porcentajeno" ).val("")
        $( "#configuracion_idconfiguracion" ).val("")
        $( "#configuracion_idhoraextra" ).val("")
        
        $( "#agregar_feriado" ).addClass("boton_inactivo")
        $( "#agregar_feriado" ).attr("disabled","disabled")
        $( "#eliminar_configuracion" ).addClass("boton_inactivo")
        $( "#eliminar_configuracion" ).attr("disabled","disabled");
        if(listado_feriado){
            listado_feriado.fnDraw();
        }
        if(listado_configuracion){
            listado_configuracion.fnDraw()
        }
    }
    
</script>
