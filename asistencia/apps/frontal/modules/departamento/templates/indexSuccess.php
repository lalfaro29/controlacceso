<h1>Departamentos List</h1>

<table>
  <thead>
    <tr>
      <th>Iddepartamento</th>
      <th>Departamento</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($departamentos as $departamento): ?>
    <tr>
      <td><a href="<?php echo url_for('departamento/show?iddepartamento='.$departamento->getIddepartamento()) ?>"><?php echo $departamento->getIddepartamento() ?></a></td>
      <td><?php echo $departamento->getDepartamento() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('departamento/new') ?>">New</a>
