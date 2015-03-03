
<form id="rpp_permisos" method="POST" action="<?php echo url_for("@movimiento_rpp_permisos") ?>">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em">
        <tr>
            <td align="center">POR PERIODO</td>
        </tr>
        <tr>
            <td colspan="2">Desde <?php echo $form["fecha_desde"] ?> &nbsp;&nbsp;&nbsp;Hasta <?php echo $form["fecha_hasta"] ?></td>
        </tr> 
<!--        <tr>
            <td align="center">POR DEPARTAMENTO</td>
        </tr>
        <tr>
            <td align="center">
                <?php //echo $form["departamentos"] ?>
            </td>
        </tr>-->
<!--        <tr>
            <br>
            <td align="center">EMPLEADO</td>
            <input type="hidden" name="departamentos" id="departamentos" value="<?php //echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento(); ?>">
        </tr>
        <tr>
            <td align="center">
                <?php// echo $form["empleados"] ?>
            </td>
        </tr>   -->
    </table>
    <center>
        <input type="button" name="generar_reporte" id="generar_reporte" value="GENERAR">
        <input type="button" name="cancelar_configuracion" id="cancelar_configuracion" value="CANCELAR">
    </center>
</form>
<script type="text/javascript">
    $("#generar_reporte").click(function(){
        $("#rpp_permisos").submit()
    })
//    $("#movimiento_departamentos").change(function(){
//            $.ajax({
//                    url: '<?php //echo url_for(@movimiento_select_departamento) ?>',
//                    data:"departamento="+$(this).val(),
//                    dataType:"json",
//                    type: "POST",
//                    success: function( resultado ) {
//                        $("#movimiento_empleados").html("")
//                        //recorremos todas las filas del resultado del proceso que obtenemos en Json
//                        $.each(resultado, function(id,valor){
//                            //introducimos los option del Json obtenido
//                            $("#movimiento_empleados").append('<option value="'+id+'">'+valor+'</option>');
//                        });
//                    }
//            })
//    })
    
</script>
