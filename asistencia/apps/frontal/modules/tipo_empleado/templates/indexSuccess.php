<h1>Tipo empleados List</h1>

<table>
  <thead>
    <tr>
      <th>Idtipoempleado</th>
      <th>Empleado</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tipo_empleados as $tipo_empleado): ?>
    <tr>
      <td><a href="<?php echo url_for('tipo_empleado/show?idtipoempleado='.$tipo_empleado->getIdtipoempleado()) ?>"><?php echo $tipo_empleado->getIdtipoempleado() ?></a></td>
      <td><?php echo $tipo_empleado->getEmpleado() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('tipo_empleado/new') ?>">New</a>
