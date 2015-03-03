<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $coordinador->getId() ?></td>
    </tr>
    <tr>
      <th>Usuario:</th>
      <td><?php echo $coordinador->getUsuarioId() ?></td>
    </tr>
    <tr>
      <th>Departamento:</th>
      <td><?php echo $coordinador->getDepartamentoId() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('coordinador/edit?id='.$coordinador->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('coordinador/index') ?>">List</a>
