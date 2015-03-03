<h1>Movimientos List</h1>

<table>
  <thead>
    <tr>
      <th>Idmovimiento</th>
      <th>Idusuario</th>
      <th>Fecha</th>
      <th>Movimiento</th>
      <th>Estado</th>
      <th>Registro</th>
      <th>Ipsede</th>
      <th>Ipusuario</th>
      <th>Idconfiguracion</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($movimientos as $movimiento): ?>
    <tr>
      <td><a href="<?php echo url_for('movimiento/edit?idmovimiento='.$movimiento->getIdmovimiento()) ?>"><?php echo $movimiento->getIdmovimiento() ?></a></td>
      <td><?php echo $movimiento->getIdusuario() ?></td>
      <td><?php echo $movimiento->getFecha() ?></td>
      <td><?php echo $movimiento->getMovimiento() ?></td>
      <td><?php echo $movimiento->getEstado() ?></td>
      <td><?php echo $movimiento->getRegistro() ?></td>
      <td><?php echo $movimiento->getIpsede() ?></td>
      <td><?php echo $movimiento->getIpusuario() ?></td>
      <td><?php echo $movimiento->getIdconfiguracion() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('movimiento/new') ?>">New</a>
