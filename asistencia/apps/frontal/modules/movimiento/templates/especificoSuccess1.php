
<form id="rpp_especifico" method="POST" action="<?php echo url_for("@movimiento_rpp_especifico") ?>">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em">
        <tr>
            <td align="center">POR PERIODO</td>
        </tr>
        <tr >
            <td colspan="2" align="center">
                <b>DESDE:</b> <input type="text" id="desde" name="desde" size="8">  <b>HASTA:</b> <input type="text" id="hasta" name="hasta" size="8">
            </td>
        </tr>  <tr>
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
            <br>
            <td align="center">EMPLEADO</td>
<!--            <input type="hidden" name="departamentos" id="departamentos" value="<?php //echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento(); ?>">-->
        </tr>
        <tr>
<!--            <td align="center">
                <?php //echo $form["empleados"] ?>
            </td>-->
         <?php   $empleado1 = Doctrine_Core::getTable("Usuario")->listaUsuariosSelect($sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIddepartamento());
             ?> </td></tr> <tr><td align="center"><select id="empleado" name="empleado" style="with:50px" >
                            <option value="null">Seleccione el empleado</option>
                        <?php foreach($empleado1 as $empleado): ?>
                        <option name="empleado" value="<?php echo $empleado->getIdusuario() ?>" ><?php echo $empleado->getApellido().'   '.$empleado->getNombre() ?></option>
                        <?php endforeach; ?>
                </select> </td> 
        </tr>   
    </table>
    <center>
        <input type="button" name="generar_reporte" id="generar_reporte" value="GENERAR">
        <input type="button" name="cancelar_configuracion" id="cancelar_configuracion" value="CANCELAR">
    </center>
</form>
<script type="text/javascript">
   $(function() {
        var params = {
            changeMonth : false,
            changeYear : false,
            numberOfMonths : 1,
            showButtonPanel : false,
            dateFormat : "dd/mm/yy" 
        };
        $("#desde").datepicker(params);
        $("#hasta").datepicker(params);
        
        $("#cancelar_configuracion").click(function(){
            $('#empleado option[value="null"]').attr('selected', 'selected');
            $("#desde").val("")
            $("#hasta").val("")
        });
        $("#generar_reporte").click(function(){
            
             if($("#empleado option:selected").val() == "null"){
                alert("debe seleccionar una option")
            }else if($("#desde").val() == ""){
                alert("debe seleccionar una fecha de inicio valido")
            }else if($("#hasta").val() == ""){
                alert("debe seleccionar una fecha final valida")
            }else{
                $("#rpp_especifico").submit();
            }
        })
    }); 
</script>
