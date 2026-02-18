<?php
$page_title = 'Vista de TITULACIONES';
require_once('includes/load.php');
page_require_level(1);

$all_titulaciones = find_all('GPP_TITULACION');
?>

<?php include_once('layouts/headerTITU.php'); ?>

<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-eye-open"></span> Vista de TITULACIONES</strong></div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Duración</th>
              <th class="text-center">Créditos Totales</th>
              <th class="text-center">Tipo</th>
              <th class="text-center">Coordinador</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_titulaciones as $titu): ?>
              <tr>
                <td><?php echo remove_junk($titu['Dur_Titu']); ?></td>
                <td><?php echo remove_junk($titu['CredTot_Titu']); ?></td>
                <td><?php echo remove_junk($titu['Tipo_Titu']); ?></td>
                <td><?php echo remove_junk($titu['Coord_Titu']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

        <a href="titulacion.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
</div>

<?php include_once('layouts/footer.php'); ?>
