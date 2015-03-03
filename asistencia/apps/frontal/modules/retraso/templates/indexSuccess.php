<h1>Retrasos List</h1>

<table>
  <thead>
    <tr>
      <th>Idretraso</th>
      <th>Idmovimiento</th>
      <th>Motivo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($retrasos as $retraso): ?>
    <tr>
      <td><a href="<?php echo url_for('retraso/show?idretraso='.$retraso->getIdretraso()) ?>"><?php echo $retraso->getIdretraso() ?></a></td>
      <td><?php echo $retraso->getIdmovimiento() ?></td>
      <td><?php echo $retraso->getMotivo() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('retraso/new') ?>">New</a>
