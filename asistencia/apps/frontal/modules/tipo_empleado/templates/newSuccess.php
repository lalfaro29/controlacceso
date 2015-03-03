<center>
	<h1>Nuevo Tipo Empleado</h1>
</center>

<?php include_partial('form', array('form' => $form)) ?>
<div id="lista_proyectos">
	<?php include_partial('lista',array('tipo_empleados'=>$tipo_empleados)) ?>
</div>
