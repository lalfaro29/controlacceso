<style>
    .display td.titulo{
        font-weight: bold;
        text-align: left;
        text-transform: uppercase;
    }
</style>
<form id="rpp_he" method="POST" action="<?php echo url_for("@movimiento_rpp_he") ?>">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em">
        <tr>
            <td align="center" class="titulo">DEPARTAMENTO:</td>
            <td align="center">
                <select id="departamento" name="departamento">
                    <option value="null">Seleccione el departamento</option>
                    <?php foreach($ls_departamento as $departamento): ?>
                        <option value="<?php echo $departamento->getIddepartamento(); ?>"><?php echo $departamento->getDepartamento(); ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="center" class="titulo">Tipo Personal:</td>
            <td align="center">
                <select id="tipo_personal" name="tipo_personal">
                    <option value="null">Seleccione el tipo de personal</option>
                    <?php foreach($ls_tipo_personal as $id => $tipo_personal): ?>
                        <option value="<?php echo $id ?>"><?php echo $tipo_personal ?></option>
                    <?php endforeach ?>
                </select>
                <input type="hidden" name="departamento" id="departamento" value="<?php echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento(); ?>">
            </td>
        </tr>
        <tr>
            <td align="center" class="titulo">Turnos:</td>
            <td align="center">
                <select id="turno" name="turno">
                    <option value="null">Seleccione el turno</option>
                    <?php foreach($ls_turno as $id => $turno): ?>
                        <option value="<?php echo $id ?>"><?php echo $turno ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr> 
        <tr >
            <td colspan="2" align="center">
                <b>DESDE:</b> <input type="text" id="fecha_desde" name="fecha_desde" size="8">  <b>HASTA:</b> <input type="text" id="fecha_hasta" name="fecha_hasta" size="8">
            </td>
        </tr>   
    </table>
    <center>
        <input type="button" name="generar_reporte" id="generar_reporte_HE" value="GENERAR">
        <input type="button" name="cancelar_configuracion" id="cancelar_HE" value="CANCELAR">
    </center>
</form>
<?php //include_partial("reporte/horas_extras"); ?>
<script type="text/javascript">
   $(function() {
       var dates = $("#fecha_desde, #fecha_hasta" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        changeYear:true,
			numberOfMonths: 1,
                      
			onSelect: function( selectedDate ) {
				var option = this.id == "fecha_desde" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});

        $("#fecha_desde").datepicker(dates);
        $("#fecha_hasta").datepicker(dates);
        
        $("#cancelar_HE").click(function(){
//            $('#departamento option[value="null"]').attr('selected', 'selected');
            $('#tipo_personal option[value="null"]').attr('selected', 'selected');
            $('#turno option[value="null"]').attr('selected', 'selected');
            $("#fecha_desde").val("")
            $("#fecha_hasta").val("")
        });
        $("#generar_reporte_HE").click(function(){
//            if($("#departamento option:selected").val() == "null"){
                //alert("debe seleccionar un departamento valido")
            if($("#tipo_personal option:selected").val() == "null"){
                alert("debe seleccionar un tipo de persona valida")
            }else if($("#turno option:selected").val() == "null"){
                alert("debe seleccionar un turno valido")
            }else if($("#fecha_desde").val() == ""){
                alert("debe seleccionar una fecha de inicio valido")
            }else if($("#fecha_hasta").val() == ""){
                alert("debe seleccionar una fecha final valida")
            }else{
                $("#rpp_he").submit();
            }
        })
    }); 
</script>