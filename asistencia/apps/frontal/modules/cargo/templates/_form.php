
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for(@cargo,$form) ?>" id="cargo_form" method="post">
	<table align="center">
		<tr>
			<td>
				Cargo: <?php echo $form["cargo"]->render() ?>
			</td>
		</tr>
		<tr>
			<td align="center">
      				 <?php echo $form->renderHiddenFields() ?>
         			 <input type="hidden" id="accion" value="nuevo" />
         			 <input type="button" id="cargo_guardar" value="Guardar" />
         			 <input type="button" id="cargo_salir" value="Salir" />
			</td>
		</tr>
	</table>
</form>
