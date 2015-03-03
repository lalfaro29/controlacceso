<h1>Motivos List</h1>

<table>
  <thead>
    <tr>
      <th>Idmotivo</th>
      <th>Motivo</th>
      <th>Activo</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($motivos as $motivo): ?>
    <tr>
      <td><a href="<?php echo url_for('motivo/edit?idmotivo='.$motivo->getIdmotivo()) ?>"><?php echo $motivo->getIdmotivo() ?></a></td>
      <td><?php echo $motivo->getMotivo() ?></td>
      <td><?php echo $motivo->getActivo() ?></td>
      <td><?php echo $motivo->getCreatedAt() ?></td>
      <td><?php echo $motivo->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('motivo/new') ?>">New</a>
