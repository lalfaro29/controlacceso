<h1>Hora extras List</h1>

<table>
  <thead>
    <tr>
      <th>Idhoraextra</th>
      <th>Horadesdedi</th>
      <th>Horahastadi</th>
      <th>Horadesdeno</th>
      <th>Horahastano</th>
      <th>Porcentajedi</th>
      <th>Porcentajeno</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($hora_extras as $hora_extra): ?>
    <tr>
      <td><a href="<?php echo url_for('horaestra/show?idhoraextra='.$hora_extra->getIdhoraextra()) ?>"><?php echo $hora_extra->getIdhoraextra() ?></a></td>
      <td><?php echo $hora_extra->getHoradesdedi() ?></td>
      <td><?php echo $hora_extra->getHorahastadi() ?></td>
      <td><?php echo $hora_extra->getHoradesdeno() ?></td>
      <td><?php echo $hora_extra->getHorahastano() ?></td>
      <td><?php echo $hora_extra->getPorcentajedi() ?></td>
      <td><?php echo $hora_extra->getPorcentajeno() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('horaestra/new') ?>">New</a>
