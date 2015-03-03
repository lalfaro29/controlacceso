<table>
  <tbody>
    <tr>
      <th>Idconfiguracion:</th>
      <td><?php echo $configuracion->getIdconfiguracion() ?></td>
    </tr>
    <tr>
      <th>Idusuario:</th>
      <td><?php echo $configuracion->getIdusuario() ?></td>
    </tr>
    <tr>
      <th>Fecha:</th>
      <td><?php echo $configuracion->getFecha() ?></td>
    </tr>
    <tr>
      <th>Horaentrada:</th>
      <td><?php echo $configuracion->getHoraentrada() ?></td>
    </tr>
    <tr>
      <th>Horasalida:</th>
      <td><?php echo $configuracion->getHorasalida() ?></td>
    </tr>
    <tr>
      <th>Horamaxentrada:</th>
      <td><?php echo $configuracion->getHoramaxentrada() ?></td>
    </tr>
    <tr>
      <th>Central:</th>
      <td><?php echo $configuracion->getCentral() ?></td>
    </tr>
    <tr>
      <th>Cestatique x jornada:</th>
      <td><?php echo $configuracion->getCestatiqueXJornada() ?></td>
    </tr>
    <tr>
      <th>Precioticks:</th>
      <td><?php echo $configuracion->getPrecioticks() ?></td>
    </tr>
    <tr>
      <th>Idsede:</th>
      <td><?php echo $configuracion->getIdsede() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('configuracion/edit?idconfiguracion='.$configuracion->getIdconfiguracion()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('configuracion/index') ?>">List</a>
