<h1>Cargos List</h1>

<table>
  <thead>
    <tr>
      <th>Idcargo</th>
      <th>Cargo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cargos as $cargo): ?>
    <tr>
      <td><a href="<?php echo url_for('cargo/show?idcargo='.$cargo->getIdcargo()) ?>"><?php echo $cargo->getIdcargo() ?></a></td>
      <td><?php echo $cargo->getCargo() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('cargo/new') ?>">New</a>
