<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for(@departamento,$form) ?>" id="departamento_form" method="post">
	<table align="center">
		<tr>
			<td>
				Departamento: <?php echo $form["departamento"]->render() ?>
			</td>
		</tr>
		<tr>
			<td align="center">
      				 <?php echo $form->renderHiddenFields() ?>
         			 <input type="hidden" id="accion" value="nuevo" />
         			 <input type="button" id="departamento_guardar" value="Guardar" />
         			 <input type="button" id="departamento_salir" value="Salir" />
			</td>
		</tr>
	</table>
</form>

