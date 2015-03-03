<table>
  <tbody>
    <tr>
      <th>Iddepartamento:</th>
      <td><?php echo $departamento->getIddepartamento() ?></td>
    </tr>
    <tr>
      <th>Departamento:</th>
      <td><?php echo $departamento->getDepartamento() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('departamento/edit?iddepartamento='.$departamento->getIddepartamento()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('departamento/index') ?>">List</a>
