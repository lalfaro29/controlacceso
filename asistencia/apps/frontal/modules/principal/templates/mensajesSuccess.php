<table align="center" class="mensaje_class">
<?php 

	switch($tipo_mensaje):
		case "jornada_incompleta":
			?>
				<tr><th>No ha culminado la jornada laboral</th></tr>
				<tr><th>Hora de entrada: <?php echo date("h:i:s a",(strtotime($sf_user->get_variable("fecha_hora_entrada")))) ?></th></tr>
				<tr><th>Hora de salida: <?php echo date("h:i:s a",(strtotime($sf_user->get_variable("fecha_hora_salida")))) ?></th></tr>
				<tr><th>Porcentaje laborado: <?php echo $sf_user->get_variable("jornada_laboral") ?>%</th></tr>
				<tr><th>¿Desea registrar la salida?</th></tr>
			<?php
		break;
		case "adelantado": 
			?>
				<tr><th>Usuario: <?php echo $sf_user->get_variable("apellido")." ".$sf_user->get_variable("nombre") ?></th></tr>
				<tr><th>Hora de entrada: <?php echo date("h:i:s a",(strtotime($sf_user->get_variable("fecha_hora_entrada")))) ?></th></tr>
				<tr><th>Hora de salida: <?php echo date("h:i:s a",(strtotime($sf_user->get_variable("fecha_hora_salida")))) ?></th></tr>
				<tr><th>Porcentaje laborado: <?php echo $sf_user->get_variable("jornada_laboral") ?>%</th></tr>
				<tr><th>
					<select id="motivo" name="motivo" style="with:50px">
						<?php foreach($motivos as $motivo): ?>
						<option id="motivo" name="motivo" value="<?php echo $motivo->getIdmotivo() ?>" <?php echo ($motivo->getIdmotivo()==1)?"selected='selected'":"" ?> ><?php echo $motivo->getMotivo() ?></option>
						<?php endforeach; ?>
					</select>
				</th></tr>

			<?php	
		break;
		case "retraso":
			?>
				<tr><th>Tiene un retraso en la hora de llegada</th></tr>
				<tr><th>Hora de entrada del sistema: <?php echo date("h:i:s a",(strtotime($sf_user->get_variable("fecha_entrada_sistema")))) ?></th></tr>
				<tr><th>Su hora de llegada: <?php echo date("h:i:s a",(strtotime($sf_user->get_variable("fecha_entrada")))) ?></th></tr>
				<tr><th>Debe indicar el motivo de retraso en la hora de llegada</th></tr>
				<tr><th>
					<select id="motivo" name="motivo" style="with:50px">
						<?php foreach($motivos as $motivo): ?>
						<option id="motivo" name="motivo" value="<?php echo $motivo->getIdmotivo() ?>" <?php echo ($motivo->getIdmotivo()==1)?"selected='selected'":"" ?> ><?php echo $motivo->getMotivo() ?></option>
						<?php endforeach; ?>
					</select>
				</th></tr>
			<?php
		break;
	endswitch;
?>
</table>
<table align="center">
	<tr>
<?php
	switch($ventana):
		case "confirmacion":  ?>
			<td>
				<input type="submit" id="mensaje_si" value="Si">
				<input type="button" id="mensaje_no" value="no">
			</td>
<?php           break;
		case "registro":  ?>
			<td>
				<input type="submit" id="mensaje_aceptar" value="Guardar">
			</td>
<?php		break;
/*		case "":
		
		break;
		default:

		break;*/
	endswitch;        ?>
	</tr>
</table>







