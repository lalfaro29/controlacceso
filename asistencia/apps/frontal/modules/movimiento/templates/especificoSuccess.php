<form id="rpp_especifico" method="POST" action="<?php echo url_for("@movimiento_rpp_especifico") ?>">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em">
        <tr>
            <td align="center">PERIODO:</td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <b>DESDE:</b> <input type="text" id="fecha_desde" name="fecha_desde" size="8">  <b>HASTA:</b> <input type="text" id="fecha_hasta" name="fecha_hasta" size="8">
            </td>
        </tr>
        <tr>
            <td align="center">DEPARTAMENTO:
    <?php   $departamentos = Doctrine_Core::getTable("Departamento")->buscarDepartamentoPorCoordinador($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIdusuario()); ?> 
            </td>
        </tr>
        <tr>
            <td align="center">
                <select id="comboDepartamentos" name="comboDepartamentos" style="with:50px" >
                    <option value="null">Seleccione departamento</option>
                    <?php foreach($departamentos as $departamento): ?>
                    <option name="comboDepartamentos" value="<?php echo $departamento->getIddepartamento() ?>" ><?php echo $departamento->getDepartamento(); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="center">TIPO EMPLEADOS:</td>
        </tr>
        <tr>
            <td align="center">
                <select id="tipo_personal" name="tipo_personal" style="with:50px" disabled="disabled">
                    <option value="null">Seleccione el tipo de personal</option>
                    <?php foreach($ls_tipo_personal as $id => $tipo_personal): ?>
                        <option value="<?php echo $id ?>"><?php echo $tipo_personal ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="center">EMPLEADOS:</td>
        </tr>
        <tr>
            <td align="center">
                <select id="empleados" name="empleados" style="with:50px" disabled="disabled">
                    <option value="null">Seleccione el empleado</option>
                </select>
            </td>
        </tr>
        <tr>
            <br>
            <input type="hidden" name="departamentos" id="departamentos" value="<?php  echo $contador; ?>">
        </tr>

    </table>
    <center>
        <input type="button" name="generar_reporte" id="generar_reporte" value="GENERAR">
        <input type="button" name="cancelar_configuracion" id="cancelar_configuracion" value="CANCELAR">
    </center>
</form>

<script type="text/javascript">
   $(function() {
//        
    var dates = $("#fecha_desde, #fecha_hasta" ).datepicker({
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
        $('#empleado option[value="null"]').attr('selected', 'selected');
        $("#fecha_desde").val("")
        $("#fecha_hasta").val("")
    });

    $("#generar_reporte").click(function(){

            if($("#empleados option:selected").val() == "null"){
            alert("debe seleccionar un empleado valido")
        }else if($("#fecha_desde").val() == ""){
            alert("debe seleccionar una fecha de inicio valido")
        }else if($("#fecha_hasta").val() == ""){
            alert("debe seleccionar una fecha final valida")
        }else{
            $("#rpp_especifico").submit();
        }
    });
        
    $("#comboDepartamentos").change(function(){
        if($(this).val() !="null"){
            $("#tipo_personal").removeAttr("disabled");
        }else{
            $('#tipo_personal option[value="null"]').attr('selected', 'selected');
            $("#tipo_personal").attr("disabled","disabled");
            $("#empleados").html("<option value='null'>Seleccione el empleado</option>");
            $("#empleados").attr("disabled","disabled");
        }
    });
    
    $("#tipo_personal").change(function(){
        if($(this).val() !="null"){
            var departamento=$("#comboDepartamentos").val();
            var tipo=$("#tipo_personal").val();
            $.getJSON("<?php echo url_for(@usuario_combo_usuario_tipo) ?>?departamento="+departamento+"&tipo="+tipo,function(json){
                $("#empleados option").remove();
                var option="<option value='null'>Seleccione el empleado</option>";
                option+="<option value='0'>Todos</option>";
                $.each(json, function(id,valor) {
                    option+="<option value='"+id+"'>"+valor+"</option>";
                });

                $("#empleados").append(option);
                $("#empleados").removeAttr("disabled");
            })
        }else{
            $("#empleados").html("<option value='null'>Seleccione el empleado</option>");
            $("#empleados").attr("disabled","disabled");

        }
    });
    
    $("#cancelar_configuracion").click(function(){
        $('form').each (function(){
            this.reset();
        });
        $("#empleados").html("<option value='null'>Seleccione el empleado</option>");
        $("#empleados").attr("disabled","disabled");
        $('#tipo_personal option[value="null"]').attr('selected', 'selected');
        $("#tipo_personal").attr("disabled","disabled");
    });
    
    
        
    }); 
</script>

