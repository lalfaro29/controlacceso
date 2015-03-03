
<form id="rpp_permisos" method="POST" action="<?php echo url_for("@movimiento_rpp_permisos") ?>">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em">
        <tr>
            <td align="center">POR PERIODO</td>
        </tr>
       <tr >
            <td colspan="2" align="center">
                <b>DESDE:</b> <input type="text" id="fecha_desde" name="fecha_desde" size="8">  <b>HASTA:</b> <input type="text" id="fecha_hasta" name="fecha_hasta" size="8">
            </td>
        </tr> 
<tr>
            <td align="center">
            <?php 
            
            $secretarias = Doctrine_Core::getTable("Usuario")->buscarSecretaria($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento(),null);
             ?> </td></tr> <tr><td align="center"><select id="secretaria" name="secretaria" style="with:50px" >
                            <option value="null">Seleccione el responsable</option>
                        <?php foreach($secretarias as $secretaria): ?>
                        <option name="secretaria" value="<?php echo $secretaria->getIdusuario() ?>" ><?php echo $secretaria->getApellido().'   '.$secretaria->getNombre() ?></option>
                        <?php endforeach; ?>
                </select> </td>
        </tr>

   <tr>
            <br>
            <input type="hidden" name="departamento" id="departamento" value="<?php echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento(); ?>">
        </tr>

    </table>
    <center>
        <input type="button" name="generar_reporte" id="generar_reporte" value="GENERAR">
        <input type="button" name="cancelar_configuracion" id="cancelar_configuracion" value="CANCELAR">
    </center>
</form>

<script type="text/javascript">
 
      var dates =$("#fecha_desde, #fecha_hasta" ).datepicker({
			//defaultDate: "+1w",
                        //dateFormat:'dd-mm-yyyy',
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
        
        $("#cancelar_configuracion").click(function(){
            $('#secretaria option[value="null"]').attr('selected', 'selected');
            $("#fecha_desde").val("")
            $("#fecha_hasta").val("")
        });
        $("#generar_reporte").click(function(){
            
             if($("#secretaria option:selected").val() == "null"){
                alert("debe seleccionar una secretaria valida")
            }else if($("#fecha_desde").val() == ""){
                alert("debe seleccionar una fecha de inicio valido")
            }else if($("#fecha_hasta").val() == ""){
                alert("debe seleccionar una fecha final valida")
            }else{
                $("#rpp_permisos").submit();
            }
        })
 
</script>