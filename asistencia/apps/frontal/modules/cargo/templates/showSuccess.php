<table>
  <tbody>
    <tr>
      <th>Idcargo:</th>
      <td><?php echo $cargo->getIdcargo() ?></td>
    </tr>
    <tr>
      <th>Cargo:</th>
      <td><?php echo $cargo->getCargo() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('cargo/edit?idcargo='.$cargo->getIdcargo()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('cargo/index') ?>">List</a>
