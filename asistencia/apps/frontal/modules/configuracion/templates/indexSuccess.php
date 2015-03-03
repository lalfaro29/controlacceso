<h1>Configuracions List</h1>

<table>
  <thead>
    <tr>
      <th>Idconfiguracion</th>
      <th>Idusuario</th>
      <th>Fecha</th>
      <th>Horaentrada</th>
      <th>Horasalida</th>
      <th>Horamaxentrada</th>
      <th>Central</th>
      <th>Cestatique x jornada</th>
      <th>Precioticks</th>
      <th>Idsede</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($configuracions as $configuracion): ?>
    <tr>
      <td><a href="<?php echo url_for('configuracion/show?idconfiguracion='.$configuracion->getIdconfiguracion()) ?>"><?php echo $configuracion->getIdconfiguracion() ?></a></td>
      <td><?php echo $configuracion->getIdusuario() ?></td>
      <td><?php echo $configuracion->getFecha() ?></td>
      <td><?php echo $configuracion->getHoraentrada() ?></td>
      <td><?php echo $configuracion->getHorasalida() ?></td>
      <td><?php echo $configuracion->getHoramaxentrada() ?></td>
      <td><?php echo $configuracion->getCentral() ?></td>
      <td><?php echo $configuracion->getCestatiqueXJornada() ?></td>
      <td><?php echo $configuracion->getPrecioticks() ?></td>
      <td><?php echo $configuracion->getIdsede() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('configuracion/new') ?>">New</a>
