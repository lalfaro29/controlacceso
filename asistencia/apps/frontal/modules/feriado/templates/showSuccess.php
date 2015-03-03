<table>
  <tbody>
    <tr>
      <th>Idferiado:</th>
      <td><?php echo $feriado->getIdferiado() ?></td>
    </tr>
    <tr>
      <th>Feriado:</th>
      <td><?php echo $feriado->getFeriado() ?></td>
    </tr>
    <tr>
      <th>Feriadofechdesde:</th>
      <td><?php echo $feriado->getFeriadofechdesde() ?></td>
    </tr>
    <tr>
      <th>Feriadofechhasta:</th>
      <td><?php echo $feriado->getFeriadofechhasta() ?></td>
    </tr>
    <tr>
      <th>Feriadohoradesde:</th>
      <td><?php echo $feriado->getFeriadohoradesde() ?></td>
    </tr>
    <tr>
      <th>Feriadohorahasta:</th>
      <td><?php echo $feriado->getFeriadohorahasta() ?></td>
    </tr>
    <tr>
      <th>Porcentajeferiado:</th>
      <td><?php echo $feriado->getPorcentajeferiado() ?></td>
    </tr>
    <tr>
      <th>Porcentajenocturno:</th>
      <td><?php echo $feriado->getPorcentajenocturno() ?></td>
    </tr>
    <tr>
      <th>Tipoferiado:</th>
      <td><?php echo $feriado->getTipoferiado() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('feriado/edit?idferiado='.$feriado->getIdferiado().'&feriado='.$feriado->getFeriado()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('feriado/index') ?>">List</a>
