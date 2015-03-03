
<form id="rpp_especifico" method="POST" action="<?php echo url_for("@movimiento_rpp_especifico") ?>">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em">
        <tr>
            <td align="center">POR DEPARTAMENTO</td>
        </tr>
        <tr>
            <td align="center">
                <?php echo $form["departamentos"] ?>
            </td>
        </tr>                        
        <tr>
            <td colspan="2">Desde <?php echo $form["fecha_desde"] ?> &nbsp;&nbsp;&nbsp;Hasta <?php echo $form["fecha_hasta"] ?></td>
        </tr>  
    </table>
    <center>
        <input type="button" name="generar_reporte" id="generar_reporte" value="GENERAR">
        <input type="button" name="cancelar_configuracion" id="cancelar_configuracion" value="CANCELAR">
    </center>
</form>
<script type="text/javascript">
    $("#generar_reporte").click(function(){
        $("#rpp_especifico").submit()
    })
</script>