<table cellpadding="0" cellspacing="0" border="0" class="display" id="listado_tipo_empleado" style="width:100%">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Tipo Empleado</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($tipo_empleados as $empleado): ?>
		<tr>
			<td><?php echo image_tag('eliminar.gif',"class='btnTabla' title='eliminar el registro'") ?></td>
			<td><?php echo image_tag('editar.jpg',"class='btnTabla' title='seleccionar el registro'") ?></td>
			<td style="padding-left:1.5em"><?php echo $empleado->getEmpleado() ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
