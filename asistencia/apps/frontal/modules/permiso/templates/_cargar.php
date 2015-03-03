
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em;width: 50%">
        <tr>
            <th style="width:6em"><b>Nombre:</b></th>
            <td style="width:10em"><?php echo $usuario->getNombre() ?></td>
            <th style="width:5em"><b>Apellido:</b></th>
            <td style="width:10em"><?php echo $usuario->getApellido() ?></td>
        </tr> 
        <tr>
            <th><b>Cedula:</b></th>
            <td><?php echo $usuario->getCedula() ?></td>
            <th><b>Cargo:</b></th>
            <td><?php echo $usuario->getCargo()->getCargo() ?></td>
        </tr>  
        <tr>
            <th><b>Departamento:</b></th>
            <td colspan="3"><?php echo $usuario->getDepartamento()->getDepartamento() ?></td>
        </tr> 
        <tr>
            <th><b>Tiempo:</b></th>
            <td colspan="3">
                <select id="tiempo" style="width:15em">
                    <option value="parcial">Parcial</option>
                    <option value="dias" selected="selected">Por Dia</option>
                </select>
            </td>
        </tr>
        <tr id="dias">
            <th><b>Desde:</b></th>
            <td><input type="text" id="desde" size="8"></td>
            <th><b>Hasta:</b></th>
            <td><input type="text" id="hasta" size="8"></td>
        </tr>
        <tr id="parcial" style="display:none">
            <th><b>Fecha:</b></th>
            <td><input type="text" id="fecha" size="8"></td>
            <th><b>Horas:</b></th>
            <td>
                <select id="horas" style="width:10em">
                    <?php for($i=1;$i<9;$i++): ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><b>Motivo:</b></th>
            <td colspan="3">
                <select id="motivo">
                    <?php foreach($motivos as $motivo): ?>
                    <option value="<?php echo $motivo->getIdmotivo() ?>"><?php echo $motivo->getMotivo() ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>

            <center>
                <input type="hidden" id="usuario" value="<?php echo $usuario->getIdusuario() ?>">
                <input type="hidden" name="idregistrador" id="idregistrador" value="<?php echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIdusuario(); ?>">
                <input type="hidden" id="permiso" value="">
                <input type="button" name="guardar_permiso" id="guardar_permiso" value="GUARDAR">
                <input type="button" name="cancelar_permiso" id="cancelar_permiso" value="CANCELAR">
                <input type="button" name="volver_permiso" id="volver_permiso" value="VOLVER">
            </center> 
    <br><br><br>
<?php include_partial('listado',array("usuario"=>$usuario->getIdusuario())) ?>
<script type="text/javascript">
    $("#fecha").datepicker();
    var dates = $( "#desde, #hasta" ).datepicker({
                         
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "desde" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
    $("#volver_permiso").click(function(){
            $('#lista_permiso').load("<?php echo url_for(@permiso_asignar) ?>");
    })
    $("#tiempo").change(function(){
        if($(this).val() !="null"){
            if($(this).val() == "parcial"){
                $("#parcial").show()
                $("#dias").hide()
            }else if($(this).val() == "dias"){
                $("#dias").show()
                $("#parcial").hide()
            }
            $("#desde").val("")
            $("#hasta").val("")
            $("#fecha").val("")
        }
    })
    $("#cancelar_permiso").click(function(){
        limpiar_permiso()
    })
    $("#guardar_permiso").click(function(){
        tiempo = $("#tiempo option:selected").val()
        usuario = $("#usuario").val()
       idregistrador = $("#idregistrador").val()
        motivo = $("#motivo option:selected").val()
        if(isNaN(usuario)){
            alert("el usuario seleccionado no es valido")
        }else if(tiempo == "null" || tiempo == null){
            alert("debe seleccionar un tiempo valido")
        }else{
            data = "usuario="+usuario+"&permiso="+$("#permiso").val()+"&motivo="+motivo+"&idregistrador="+idregistrador
           if(tiempo == "parcial"){
               fecha = $("#fecha").val()
               if(fecha =="" || !fecha){
                   alert("debe indicar la fecha del permiso")
               }else{
                   data += "&tiempo="+tiempo+"&fecha="+fecha+"&horas="+$("#horas option:selected").val()
                   guardar(data);
               }
           }else if(tiempo == "dias"){
               desde = $("#desde").val()
               hasta = $("#hasta").val()
               if(desde == "" || !desde){
                   alert("debe indicar la fecha de inicio del permiso")
               }else if(hasta == "" || !hasta){
                   alert("debe indicar la fecha de fin del permiso")
               }else{
                   data += "&tiempo="+tiempo+"&desde="+desde+"&hasta="+hasta
                   guardar(data);
               }
           }
        }
        
    })
        
        function guardar(data){
                $.ajax({
                        url: '<?php echo url_for(@permiso_guardar_permiso) ?>',
                        data:data,
                        success: function( resultado ) {
                                alert(resultado);
                                limpiar_permiso()
                        }
                });
        }
        function limpiar_permiso(){
            $("#desde").val("")
            $("#hasta").val("")
            $("#fecha").val("")
            $("#tiempo option:eq(0)").attr("selected", "selected");
            $("#motivo option:eq(0)").attr("selected", "selected");
            $("#horas option:eq(0)").attr("selected", "selected");
            $("#dias").hide()
            $("#parcial").show()
            var dates = $( "#desde, #hasta" ).datepicker({
                                defaultDate: "+1w",
                                changeMonth: true,
                                numberOfMonths: 1,
                                onSelect: function( selectedDate ) {
                                        var option = this.id == "desde" ? "minDate" : "maxDate",
                                                instance = $( this ).data( "datepicker" ),
                                                date = $.datepicker.parseDate(
                                                        instance.settings.dateFormat || $.datepicker._defaults.dateFormat,
                                                        selectedDate, instance.settings );
                                        dates.not( this ).datepicker( "option", option, date );
                                }
                        });
            listado_permisos.fnDraw();
        }

</script>    