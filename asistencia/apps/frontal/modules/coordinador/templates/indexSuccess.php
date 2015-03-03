<h1>Coordinadors List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Usuario</th>
      <th>Departamento</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($coordinadors as $coordinador): ?>
    <tr>
      <td><a href="<?php echo url_for('coordinador/show?id='.$coordinador->getId()) ?>"><?php echo $coordinador->getId() ?></a></td>
      <td><?php echo $coordinador->getUsuarioId() ?></td>
      <td><?php echo $coordinador->getDepartamentoId() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('coordinador/new') ?>">New</a>
