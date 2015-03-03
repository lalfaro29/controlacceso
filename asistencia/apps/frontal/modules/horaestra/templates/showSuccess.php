<table>
  <tbody>
    <tr>
      <th>Idhoraextra:</th>
      <td><?php echo $hora_extra->getIdhoraextra() ?></td>
    </tr>
    <tr>
      <th>Horadesdedi:</th>
      <td><?php echo $hora_extra->getHoradesdedi() ?></td>
    </tr>
    <tr>
      <th>Horahastadi:</th>
      <td><?php echo $hora_extra->getHorahastadi() ?></td>
    </tr>
    <tr>
      <th>Horadesdeno:</th>
      <td><?php echo $hora_extra->getHoradesdeno() ?></td>
    </tr>
    <tr>
      <th>Horahastano:</th>
      <td><?php echo $hora_extra->getHorahastano() ?></td>
    </tr>
    <tr>
      <th>Porcentajedi:</th>
      <td><?php echo $hora_extra->getPorcentajedi() ?></td>
    </tr>
    <tr>
      <th>Porcentajeno:</th>
      <td><?php echo $hora_extra->getPorcentajeno() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('horaestra/edit?idhoraextra='.$hora_extra->getIdhoraextra()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('horaestra/index') ?>">List</a>
