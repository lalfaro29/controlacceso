<h1>Sedes List</h1>

<table>
  <thead>
    <tr>
      <th>Idsede</th>
      <th>Sede</th>
      <th>Activa</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($sedes as $sede): ?>
    <tr>
      <td><a href="<?php echo url_for('sede/show?idsede='.$sede->getIdsede()) ?>"><?php echo $sede->getIdsede() ?></a></td>
      <td><?php echo $sede->getSede() ?></td>
      <td><?php echo $sede->getActiva() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('sede/new') ?>">New</a>
