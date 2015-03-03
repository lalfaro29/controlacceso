<table>
  <tbody>
    <tr>
      <th>Idpermiso:</th>
      <td><?php echo $permiso->getIdpermiso() ?></td>
    </tr>
    <tr>
      <th>Usuario:</th>
      <td><?php echo $permiso->getUsuarioId() ?></td>
    </tr>
    <tr>
      <th>Fecha:</th>
      <td><?php echo $permiso->getFecha() ?></td>
    </tr>
    <tr>
      <th>Fechadesde:</th>
      <td><?php echo $permiso->getFechadesde() ?></td>
    </tr>
    <tr>
      <th>Fechahasta:</th>
      <td><?php echo $permiso->getFechahasta() ?></td>
    </tr>
    <tr>
      <th>Horas:</th>
      <td><?php echo $permiso->getHoras() ?></td>
    </tr>
    <tr>
      <th>Tipopermiso:</th>
      <td><?php echo $permiso->getTipopermiso() ?></td>
    </tr>
    <tr>
      <th>Motivopermiso:</th>
      <td><?php echo $permiso->getMotivopermiso() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('permiso/edit?idpermiso='.$permiso->getIdpermiso()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('permiso/index') ?>">List</a>
