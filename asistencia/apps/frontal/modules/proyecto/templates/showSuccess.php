<table>
  <tbody>
    <tr>
      <th>Idproyecto:</th>
      <td><?php echo $proyecto->getIdproyecto() ?></td>
    </tr>
    <tr>
      <th>Proyecto:</th>
      <td><?php echo $proyecto->getProyecto() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('proyecto/edit?idproyecto='.$proyecto->getIdproyecto()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('proyecto/index') ?>">List</a>
