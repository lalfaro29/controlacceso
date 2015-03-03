<table>
  <tbody>
    <tr>
      <th>Idsede:</th>
      <td><?php echo $sede->getIdsede() ?></td>
    </tr>
    <tr>
      <th>Sede:</th>
      <td><?php echo $sede->getSede() ?></td>
    </tr>
    <tr>
      <th>Activa:</th>
      <td><?php echo $sede->getActiva() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('sede/edit?idsede='.$sede->getIdsede()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('sede/index') ?>">List</a>
