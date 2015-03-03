<form id="form_inicio_sesion" method="POST" action="<?php echo url_for(@principal) ?>">
	<table class="inicio_sesion" align="center" width="400px">
		<caption>Inicio sesion</caption>
		<tr>
			<td align=center>Cedula de Identidad:</td>
			<td align=center><input id="usuario" type="text" style="width:14em" value="" name="usuario"></td>
		</tr>
		<tr>			
			<td align=center>Contraseña:</td>
			<td align=center><input id="clave" type="password" style="width:14em" value="" name="clave"></td>
		</tr>		
		<tr>
			<td align=center colspan=2 >
				<input type="submit" id="inicio_sesion" value="iniciar sesion">
				<input type="button" id="cancelar" value="Cancelar">
			</td>
		</tr>
	</table>
</form>
