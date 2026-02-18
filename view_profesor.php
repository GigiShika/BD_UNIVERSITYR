<?php
$page_title = 'Vista de PROFESORES';
require_once('includes/load.php');
page_require_level(1);

// Consulta con JOIN para obtener el nombre del área
$all_profesores = $db->query("
    SELECT p.*, a.Nom_Area 
    FROM GPP_PROFESOR p 
    LEFT JOIN GPP_AREA_CONOCIMIENTO a ON p.FK_AreaProf = a.PK_Area
");
?>

<?php include_once('layouts/headerPROF.php'); ?>

<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-eye-open"></span> Vista de PROFESORES</strong></div>
      <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>

              <th class="text-center">Nombre</th>
              <th class="text-center">Especialidad</th>
              <th class="text-center">Email</th>
              <th class="text-center">Teléfono</th>
              <th class="text-center">Área</th>
            </tr>
          </thead>
          <tbody>
            <?php while($prof = $all_profesores->fetch_assoc()): ?>
              <tr>
                <td><?php echo remove_junk($prof['Nom_Prof']); ?></td>
                <td><?php echo remove_junk($prof['Esp_Prof']); ?></td>
                <td><?php echo remove_junk($prof['Email_Prof']); ?></td>
                <td class="text-center"><?php echo remove_junk($prof['Tel_Prof']); ?></td>
                <td class="text-center"><?php echo remove_junk($prof['Nom_Area']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

      <a href="profesor.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
      </a>
</div>

<?php include_once('layouts/footer.php'); ?>