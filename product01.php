<?php
  $page_title = 'Lista de Titulaciones';
  require_once('includes/load.php');
  page_require_level(3);

  // Obtener los datos de la tabla TITULACION
  $titulaciones = join_titulacion_table();
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>

  <div class="col-md-12">
    <div class="panel panel-default">

      <div class="panel-heading clearfix">
        <span class="panel-title">Titulaciones</span>
      </div>

      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th class="text-center">Tipo</th>
              <th class="text-center">Duración</th>
              <th class="text-center">Créditos Totales</th>
              <th class="text-center">Coordinador</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($titulaciones as $t): ?>
            <tr>
              <td class="text-center"><?php echo count_id(); ?></td>
              <td class="text-center"><?php echo remove_junk($t['Tipo_Titu']); ?></td>
              <td class="text-center"><?php echo remove_junk($t['Dur_Titu']); ?></td>
              <td class="text-center"><?php echo remove_junk($t['CredTot_Titu']); ?></td>
              <td class="text-center"><?php echo remove_junk($t['Coord_Titu']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>

    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
