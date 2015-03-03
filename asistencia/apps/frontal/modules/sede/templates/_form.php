<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for(@sede,$form) ?>" id="sede_form" method="post">
	<table align="center">
		<tr>
			<td>
				Sede: <?php echo $form["sede"]->render() ?>
			</td>
		</tr>
		<tr>
			<td align="center">
      				 <?php echo $form->renderHiddenFields() ?>
         			 <input type="hidden" id="accion" value="nuevo" />
         			 <input type="button" id="sede_guardar" value="Guardar" />
         			 <input type="button" id="sede_salir" value="Salir" />
			</td>
		</tr>
	</table>
</form>

