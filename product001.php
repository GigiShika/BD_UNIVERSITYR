<?php
  $page_title = 'Lista de Materias';
  require_once('includes/load.php');
  page_require_level(3);

  // Obtener materias y coordinadores
  $mater = join_area_conocimiento_table();
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>

  <div class="col-md-12">
    <div class="panel panel-default">


      <div class="panel-body">

        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Materias</th>
              <th class="text-center" style="width: 20%;">Coordinador</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($mater as $Mater): ?>
            <tr>
              <td class="text-center"><?php echo count_id(); ?></td>
              <td><?php echo remove_junk($Mater['Nom_Area']); ?></td>
              <td class="text-center"><?php echo remove_junk($Mater['Coord_Area']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>

        </table>

      </div>

    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
