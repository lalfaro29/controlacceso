<h1></h1>

<table>
  <thead>
    <tr>
      <th>Idpermiso</th>
      <th>Usuario</th>
      <th>Fecha</th>
      <th>Fechadesde</th>
      <th>Fechahasta</th>
      <th>Horas</th>
      <th>Tipopermiso</th>
      <th>Motivopermiso</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($permisos as $permiso): ?>
    <tr>
      <td><a href="<?php echo url_for('permiso/show?idpermiso='.$permiso->getIdpermiso()) ?>"><?php echo $permiso->getIdpermiso() ?></a></td>
      <td><?php echo $permiso->getUsuarioId() ?></td>
      <td><?php echo $permiso->getFecha() ?></td>
      <td><?php echo $permiso->getFechadesde() ?></td>
      <td><?php echo $permiso->getFechahasta() ?></td>
      <td><?php echo $permiso->getHoras() ?></td>
      <td><?php echo $permiso->getTipopermiso() ?></td>
      <td><?php echo $permiso->getMotivopermiso() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('permiso/new') ?>">New</a>
