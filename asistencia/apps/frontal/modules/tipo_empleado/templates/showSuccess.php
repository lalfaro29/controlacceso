<table>
  <tbody>
    <tr>
      <th>Idtipoempleado:</th>
      <td><?php echo $tipo_empleado->getIdtipoempleado() ?></td>
    </tr>
    <tr>
      <th>Empleado:</th>
      <td><?php echo $tipo_empleado->getEmpleado() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('tipo_empleado/edit?idtipoempleado='.$tipo_empleado->getIdtipoempleado()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('tipo_empleado/index') ?>">List</a>
