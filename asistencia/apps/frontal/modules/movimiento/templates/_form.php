<?php //use_stylesheets_for_form($form) ?>
<?php //use_javascripts_for_form($form) ?>
<form id="movimiento_form" method="post">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="width: auto;">
        <tr>
            <th>Empleado </th>
            <td><input type="text" disabled="disabled" id="empleado" name="empleado" size="50" style="border:none; background-color:transparent"></td>
        <tr>
            <th>Cedula </th>
            <td><input type="text" disabled="disabled" id="cedula" name="cedula" size="10" style="border:none; background-color:transparent"></td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td><input type="text" id="fecha" name="fecha" size="10" disabled="disabled"></td>
        </tr>
        <tr>
            <th>Movimiento </th>
            <td>
                <select id="tipo_movimiento" name="tipo_movimiento" disabled="disabled">
                    <option value="null">Movimiento</option>
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                   <!-- <option value="dia">Dia completo</option>-->
                </select>
            </td>
        </tr>
        <tr>
            <th>Hora de entrada</th>
            <td><input type="text" disabled="disabled" id="entrada" name="entrada" size="10" value=""></td>
        </tr>
        <tr>
            <th>Hora de salida</th>
            <td><input type="text" disabled="disabled" id="salida" name="salida" size="10" value=""></td>
        </tr>
        <tr>
            <th>Motivo</th>
            <td>
                <select id="motivo" name="motivo" style="with:50px" disabled="disabled" >
                        <?php foreach($motivos as $motivo): ?>
                        <option id="motivo" name="motivo" value="<?php echo $motivo->getIdmotivo() ?>" <?php echo ($motivo->getIdmotivo()==1)?"selected='selected'":"" ?> ><?php echo $motivo->getMotivo() ?></option>
                        <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
            </td>
        </tr>
    </table>
    <center>
        <input type="hidden" id="usuario_id" name="usuario_id">
         <input type="hidden" name="departamento" id="departamento" value="<?php echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento(); ?>">
        <input type="hidden" id="movimiento_entrada" name="movimiento_entrada">
        <input type="hidden" id="movimiento_salida" name="movimiento_salida">
                <input type="button" name="eliminar_movimiento" id="eliminar_movimiento" value="ELIMINAR" disabled="disabled" class="boton_inactivo">
                <input type="button" name="guardar_movimiento" id="guardar_movimiento" value="GUARDAR">
                <input type="button" name="cancelar_movimiento" id="cancelar_movimiento" value="CANCELAR">
    </center>
</form>

<?php include_partial('usuario/lista',array("funcion"=>"usuario_seleccionar")) ?>

<script type="text/javascript">
    $("#departamento").change(function(){
        listado_empleado.fnDraw()
    })
    
      function usuario_seleccionar(id,nombre,apellido,cedula){
          $("#empleado").val(apellido+" "+nombre)
          $("#cedula").val(cedula)
          $("#usuario_id").val(id)
          $("#entrada").val("")
          $("#salida").val("")
          $('#entrada').ptTimeSelect();
          $('#salida').ptTimeSelect();
          $("#entrada").attr("disabled","disabled")
          $("#salida").attr("disabled","disabled")
          $('#motivo option[value=1]').attr('selected', 'selected');
          $('#motivo').attr("disabled","disabled"); 
          $("#usuario_id").val(id)
          $("#tipo_movimiento").removeAttr("disabled");
          $("#fecha").datepicker({changeMonth: true,changeYear: true,disabled:false});
          $("#fecha").val("");
          $("#fecha").removeAttr("disabled");
          //$("#motivo").removeAttr("disabled");
          $("#eliminar_movimiento").addClass("boton_inactivo")
          $("#eliminar_movimiento").attr("disabled","disabled") 
          
      }  
      
      function limpiar_movimiento(){
          $("#empleado").val("")
          $("#cedula").val("")
          $("#tipo_movimiento").attr("disabled","disabled");
          $('#tipo_movimiento option[value="null"]').attr('selected', 'selected');
          $("#fecha").val("")
          $("#fecha").datepicker({ disabled: true });
          $("#fecha").attr("disabled","disabled");
          $("#entrada").val("")
          $("#salida").val("")
          $("#entrada").attr("disabled","disabled")
          $("#salida").attr("disabled","disabled")
          $('#motivo option[value=1]').attr('selected', 'selected');
          $('#motivo').attr("disabled","disabled");
          $("#usuario_id").val("")
          $("#eliminar_movimiento").addClass("boton_inactivo")
          $("#eliminar_movimiento").attr("disabled","disabled") 
          $("#movimiento_entrada").val("")
          $("#movimiento_salida").val("")
          
      }
          
      $("#fecha").change(function(){
          $('#motivo option[value=1]').attr('selected', 'selected'); 
          $('#tipo_movimiento option[value="null"]').attr('selected', 'selected'); 
          $("#entrada").val("")
          $("#salida").val("")
          $("#entrada").attr("disabled","disabled")
          $("#salida").attr("disabled","disabled")
          $("#movimiento_entrada").val("")
          $("#movimiento_salida").val("")
          $( "#eliminar_movimiento" ).addClass("boton_inactivo")
          $( "#eliminar_movimiento" ).attr("disabled","disabled") 
      })
      
      $("#tipo_movimiento").change(function(){
          fecha = $("#fecha").val()
          usuario = $("#usuario_id").val()
          movimiento = $(this).val()
          if(fecha){
              if(movimiento != "null"){
                    $.ajax({
                            url: '<?php echo url_for(@movimiento_validar_fecha) ?>',
                            data:"idusuario="+usuario+"&fecha="+fecha+((movimiento)?"&movimiento="+movimiento:""),
                            dataType:"json",
                            type: "POST",
                            success: function( resultado ) {
                                    if(resultado.valido){
                                        if(movimiento == "entrada"){
                                            $("#entrada").val("")
                                            $("#salida").val("")
                                            $('#motivo option[value=1]').attr('selected', 'selected');
                                            $("#entrada").removeAttr("disabled")
                                            $("#salida").attr("disabled","disabled")
                                            $("#motivo").removeAttr("disabled")
                                        }else if(movimiento == "salida"){
                                            if(!resultado.data){
                                                alert("no puede registrar una salida de la fecha seleccionada sin una entrada valida")
                                                $('#tipo_movimiento option[value="null"]').attr('selected', 'selected'); 
                                                $("#entrada").attr("disabled","disabled")
                                                $("#salida").attr("disabled","disabled")
                                                $("#motivo").attr("disabled","disabled")
                                                $("#entrada").val("")
                                                $("#salida").val("")
                                                $('#motivo option[value="1"]').attr('selected', 'selected');
                                            }else{
                                                $("#entrada").val("")
                                                $("#salida").val("")
                                                $('#motivo option[value="1"]').attr('selected', 'selected');
                                                $("#entrada").attr("disabled","disabled")
                                                $("#salida").removeAttr("disabled")
                                                $("#motivo").removeAttr("disabled") 
                                            }
                                        }else if(movimiento == "dia"){
                                            $("#entrada").val("")
                                            $("#salida").val("")
                                            $('#motivo option[value="1"]').attr('selected', 'selected');
                                            $("#salida").removeAttr("disabled")
                                            $("#entrada").removeAttr("disabled")
                                            $("#motivo").removeAttr("disabled")
                                        }
                                            if(resultado.data){
                                                $("#entrada").val(resultado.entrada)
                                                $("#salida").val(resultado.salida)
                                                $("#movimiento_entrada").val(resultado.entrada_id)
                                                $("#movimiento_salida").val(resultado.salida_id)
                                                $( "#eliminar_movimiento" ).removeClass("boton_inactivo")
                                                $( "#eliminar_movimiento" ).removeAttr("disabled") 
                                            }else{
                                                $("#entrada").val("")
                                                $("#salida").val("")
                                            // $("#entrada").attr("disabled","disabled")
                                            // $("#salida").attr("disabled","disabled")
                                                $("#movimiento_entrada").val("")
                                                $("#movimiento_salida").val("")
                                                $( "#eliminar_movimiento" ).addClass("boton_inactivo")
                                                $( "#eliminar_movimiento" ).attr("disabled","disabled") 
                                            }
                                    }else{
                                        alert(resultado.mensaje)
                                    }
                            }
                    }); 
              }
          }else{
            alert("debe seleeccionar una fecha antes de asignar el movimiento") 
            $('#tipo_movimiento option[value="null"]').attr('selected', 'selected'); 
          }
      })
      
      $("#eliminar_movimiento").click(function(){
          usuario = $("#usuario_id").val()
          movimiento_entrada = $("#movimiento_entrada").val()
          movimiento_salida = $("#movimiento_salida").val()
          usuario = $("#usuario_id").val()
          fecha = $("#fecha").val()
          movimiento = $("#tipo_movimiento option:selected").val()
          motivo = $('#motivo option:selected').val();
          if(!usuario || isNaN(usuario)){
              alert("debe seleccionar un usuario valido")
              limpiar_movimiento()
          }else if(!fecha){
              alert("debe seleccionar una fecha valida")
          }else if(movimiento == "null" || movimiento == null){
              alert("debe seleccionar un movimiento valido")
          }else{
            if(movimiento_entrada || movimiento_salida){
                if(confirm("¿realmente desea eliminar el movimiento")){
                    $.ajax({
                            url: '<?php echo url_for(@movimiento_eliminar_movimiento) ?>',
                            data:"movimiento="+movimiento+"&fecha="+fecha+"&usuario="+usuario+"&entrada_id="+$("#movimiento_entrada").val()+"&salida_id="+$("#movimiento_salida").val(),
                            dataType:"json",
                            type: "POST",
                            success: function( resultado ) {
                                if( resultado.valido){
                                    limpiar_movimiento()
                                }
                                alert(resultado.mensaje)
                            }
                    });
                }
            }else{
                $( "#eliminar_movimiento" ).addClass("boton_inactivo")
                $( "#eliminar_movimiento" ).attr("disabled","disabled")
            }
         }
      })
      
      $("#guardar_movimiento").click(function(){
          usuario = $("#usuario_id").val()
          fecha = $("#fecha").val()
          movimiento = $("#tipo_movimiento option:selected").val()
          motivo = $('#motivo option:selected').val();
          if(!usuario || isNaN(usuario)){
              alert("debe seleccionar un usuario valido")
              limpiar_movimiento()
          }else if(!fecha){
              alert("debe seleccionar una fecha valida")
          }else if(movimiento == "null" || movimiento == null){
              alert("debe seleccionar un movimiento valido")
          }else{
              if(movimiento=="entrada" && $("#entrada").val()==""){
                  alert("debe indicar una hora de entrada valida")
              }else if(movimiento=="salida" && $("#salida").val()==""){
                  alert("debe indicar una hora de salida valida")
              }else if(movimiento=="dia" && ($("#entrada").val()=="" || $("#salida").val()=="")){ 
                  alert("debe indicar una hora de entrada y salida valida")
              }else{
                    movimiento_entrada = $("#movimiento_entrada").val()
                    movimiento_salida = $("#movimiento_salida").val() 
                    datos = "idusuario="+usuario+"&fecha="+fecha+
                            "&entrada_id="+movimiento_entrada+"&salida_id="+movimiento_salida+
                            "&hora_entrada="+$("#entrada").val()+"&hora_salida="+$("#salida").val()+
                            "&motivo="+motivo+"&movimiento="+movimiento
                    $.ajax({
                            url: '<?php echo url_for(@movimiento_guardar_movimiento) ?>',
                            data:datos,
                            dataType:"json",
                            type: "POST",
                            success: function( resultado ) {
                                if( resultado.valido){
                                    limpiar_movimiento()
                                }
                                alert(resultado.mensaje)
                            }
                    });
              }
          }
      })
      
      
      $("#cancelar_movimiento").click(function(){
          limpiar_movimiento()
      })
      
</script>    
