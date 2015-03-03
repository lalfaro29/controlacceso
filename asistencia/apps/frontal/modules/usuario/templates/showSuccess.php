<table>
  <tbody>
    <tr>
      <th>Idusuario:</th>
      <td><?php echo $usuario->getIdusuario() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $usuario->getNombre() ?></td>
    </tr>
    <tr>
      <th>Apellido:</th>
      <td><?php echo $usuario->getApellido() ?></td>
    </tr>
    <tr>
      <th>Cedula:</th>
      <td><?php echo $usuario->getCedula() ?></td>
    </tr>
    <tr>
      <th>Idtipoempleado:</th>
      <td><?php echo $usuario->getIdtipoempleado() ?></td>
    </tr>
    <tr>
      <th>Idcargo:</th>
      <td><?php echo $usuario->getIdcargo() ?></td>
    </tr>
    <tr>
      <th>Iddepartamento:</th>
      <td><?php echo $usuario->getIddepartamento() ?></td>
    </tr>
    <tr>
      <th>Idsede:</th>
      <td><?php echo $usuario->getIdsede() ?></td>
    </tr>
    <tr>
      <th>Estado:</th>
      <td><?php echo $usuario->getEstado() ?></td>
    </tr>
    <tr>
      <th>Fechaingreso:</th>
      <td><?php echo $usuario->getFechaingreso() ?></td>
    </tr>
    <tr>
      <th>Sueldo:</th>
      <td><?php echo $usuario->getSueldo() ?></td>
    </tr>
    <tr>
      <th>Idproyecto:</th>
      <td><?php echo $usuario->getIdproyecto() ?></td>
    </tr>
    <tr>
      <th>Idconfiguracion:</th>
      <td><?php echo $usuario->getIdconfiguracion() ?></td>
    </tr>
    <tr>
      <th>Ipusuario:</th>
      <td><?php echo $usuario->getIpusuario() ?></td>
    </tr>
    <tr>
      <th>Activo:</th>
      <td><?php echo $usuario->getActivo() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('usuario/edit?idusuario='.$usuario->getIdusuario()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('usuario/index') ?>">List</a>
