<?php
$page_title = 'Vista de ÁREAS';
require_once('includes/load.php');
page_require_level(1);

// Obtener todas las áreas de conocimiento
$all_areas = find_all('GPP_AREA_CONOCIMIENTO');

// Asegurarnos de que $all_areas sea un array
if (!is_array($all_areas)) {
    $all_areas = [];
}
?>

<?php include_once('layouts/headerAREAC.php'); ?>

<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-eye-open"></span> Vista de ÁREAS</strong></div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Nombre Área</th>
              <th class="text-center">Descripción</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($all_areas)): ?>
              <?php foreach ($all_areas as $area): ?>
                <tr>
                  <td><?php echo remove_junk($area['Nom_Area']); ?></td>
                  <td><?php echo remove_junk($area['Descrip_Area']); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
                <tr>
                  <td colspan="2" class="text-center">No hay áreas registradas.</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
      <a href="area_conocimiento.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
      </a>
</div>

<?php include_once('layouts/footer.php'); ?>
