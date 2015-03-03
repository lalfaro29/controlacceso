<h1>Proyectos List</h1>

<table>
  <thead>
    <tr>
      <th>Idproyecto</th>
      <th>Proyecto</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($proyectos as $proyecto): ?>
    <tr>
      <td><a href="<?php echo url_for('proyecto/show?idproyecto='.$proyecto->getIdproyecto()) ?>"><?php echo $proyecto->getIdproyecto() ?></a></td>
      <td><?php echo $proyecto->getProyecto() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('proyecto/new') ?>">New</a>
