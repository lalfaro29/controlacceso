<div id="lista_permiso">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" style="margin-top:8em;width: 50%">
        <tr>
            <th><b>Nombre:</b></th>
            <td><?php echo Asistencia::limitar_caracteres($sf_user->getDatosBasicos()->getNombre(),25) ?></td>
            <th><b>Apellido:</b></th>
            <td><?php echo Asistencia::limitar_caracteres($sf_user->getDatosBasicos()->getApellido(),25) ?></td>
        </tr> 
        <tr>
            <th><b>Cedula:</b></th>
            <td><?php echo $sf_user->getDatosBasicos()->getCedula() ?></td>
            <th><b>Cargo:</b></th>
            <td><?php echo Asistencia::limitar_caracteres($sf_user->getDatosBasicos()->getCargo()->getCargo(),25) ?></td>
        </tr>  
        <tr>
            <th><b>Departamento:</b></th>
          <td colspan="3"><?php echo Asistencia::limitar_caracteres($sf_user->getDatosBasicos()->getDepartamento()->getDepartamento(),70) ?></td>
   <td colspan="3"><input type="hidden" id="idregistrador" value="<?php echo $sf_user->getDatosBasicos()->getUsuarioSistema()->getFirst()->getUsuario()->getIdusuario() ?>"></td>
        </tr>     
    </table>
    <br><br><br>
<?php include_partial('usuario/listado',array("funcion"=>"seleccionar")) ?>
</div>    
    
<script type="text/javascript">
    function seleccionar(idusuario){
        if(isNaN(idusuario)){
            alert("debe seleccionar un empleado valido")
        }else{
            $('#lista_permiso').load("<?php echo url_for(@permiso_asignar_permiso) ?>", { usuario_id: idusuario });
        }
    }
</script>
    