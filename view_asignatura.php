<?php
$page_title = 'Vista de ASIGNATURAS';
require_once('includes/load.php');
page_require_level(1);

$all_asignaturas = find_all('GPP_ASIGNATURA');
?>

<?php include_once('layouts/headerasignatura.php'); ?>

<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-eye-open"></span> Vista de ASIGNATURAS</strong></div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Nombre</th>
              <th class="text-center">Horas Teoría</th>
              <th class="text-center">Horas Práctica</th>
              <th class="text-center">Créditos</th>
              <th class="text-center">Semestre</th>
              <th class="text-center">Tipo</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_asignaturas as $asig): ?>
              <tr>
                <td><?php echo remove_junk($asig['Nom_Asign']); ?></td>
                <td><?php echo remove_junk($asig['HorasTeo']); ?></td>
                <td><?php echo remove_junk($asig['HorasPrac']); ?></td>
                <td><?php echo remove_junk($asig['Creditos']); ?></td>
                <td><?php echo remove_junk($asig['Semestre']); ?></td>
                <td><?php echo remove_junk($asig['Tipo_Asign']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

   <a href="asignatura.php" class="btn btn-info float-btn-left">
     <i class="glyphicon glyphicon-th-large"></i> ATRAS
  </a>
</div>

<?php include_once('layouts/footer.php'); ?>
