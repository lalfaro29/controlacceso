<h1>Feriados List</h1>

<table>
  <thead>
    <tr>
      <th>Idferiado</th>
      <th>Feriado</th>
      <th>Feriadofechdesde</th>
      <th>Feriadofechhasta</th>
      <th>Feriadohoradesde</th>
      <th>Feriadohorahasta</th>
      <th>Porcentajeferiado</th>
      <th>Porcentajenocturno</th>
      <th>Tipoferiado</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($feriados as $feriado): ?>
    <tr>
      <td><a href="<?php echo url_for('feriado/show?idferiado='.$feriado->getIdferiado().'&feriado='.$feriado->getFeriado()) ?>"><?php echo $feriado->getIdferiado() ?></a></td>
      <td><a href="<?php echo url_for('feriado/show?idferiado='.$feriado->getIdferiado().'&feriado='.$feriado->getFeriado()) ?>"><?php echo $feriado->getFeriado() ?></a></td>
      <td><?php echo $feriado->getFeriadofechdesde() ?></td>
      <td><?php echo $feriado->getFeriadofechhasta() ?></td>
      <td><?php echo $feriado->getFeriadohoradesde() ?></td>
      <td><?php echo $feriado->getFeriadohorahasta() ?></td>
      <td><?php echo $feriado->getPorcentajeferiado() ?></td>
      <td><?php echo $feriado->getPorcentajenocturno() ?></td>
      <td><?php echo $feriado->getTipoferiado() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('feriado/new') ?>">New</a>
