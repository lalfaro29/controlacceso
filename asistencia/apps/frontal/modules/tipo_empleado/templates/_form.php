<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for(@tipo_empleado,$form) ?>" id="tipo_empleado_form" method="post">
	<table align="center">
		<tr>
			<td>
				Tipo Empleado: <?php echo $form["empleado"]->render() ?>
			</td>
		</tr>
		<tr>
			<td align="center">
      				 <?php echo $form->renderHiddenFields() ?>
         			 <input type="hidden" id="accion" value="nuevo" />
         			 <input type="button" id="tipo_empleado_guardar" value="Guardar" />
         			 <input type="button" id="tipo_empleado_salir" value="Salir" />
			</td>
		</tr>
	</table>
</form>
