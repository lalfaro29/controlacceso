<table>
  <tbody>
    <tr>
      <th>Idretraso:</th>
      <td><?php echo $retraso->getIdretraso() ?></td>
    </tr>
    <tr>
      <th>Idmovimiento:</th>
      <td><?php echo $retraso->getIdmovimiento() ?></td>
    </tr>
    <tr>
      <th>Motivo:</th>
      <td><?php echo $retraso->getMotivo() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('retraso/edit?idretraso='.$retraso->getIdretraso()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('retraso/index') ?>">List</a>
