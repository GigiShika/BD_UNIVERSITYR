<?php 
  $page_title = 'Agregar PROFESOR';
  require_once('includes/load.php');
  page_require_level(1);
  $last_prof = [];
?>

<?php
if(isset($_POST['add_prof'])){
   $req_field = array('Nom_Prof','Esp_Prof','FechCont_Prof','Email_Prof','Tel_Prof','FK_AreaProf');
   validate_fields($req_field);

   $Nom_Prof     = remove_junk($db->escape($_POST['Nom_Prof']));
   $Esp_Prof     = remove_junk($db->escape($_POST['Esp_Prof']));
   $FechCont_Prof= remove_junk($db->escape($_POST['FechCont_Prof']));
   $Email_Prof   = remove_junk($db->escape($_POST['Email_Prof']));
   $Tel_Prof     = remove_junk($db->escape($_POST['Tel_Prof']));
   $FK_AreaProf  = remove_junk($db->escape($_POST['FK_AreaProf']));

   if(empty($errors)){
       $sql  = "INSERT INTO GPP_PROFESOR (Nom_Prof, Esp_Prof, FechCont_Prof, Email_Prof, Tel_Prof, FK_AreaProf) ";
       $sql .= "VALUES ('{$Nom_Prof}','{$Esp_Prof}','{$FechCont_Prof}','{$Email_Prof}','{$Tel_Prof}','{$FK_AreaProf}')";
       if($db->query($sql)){
           $session->msg("s", "Profesor agregado exitosamente.");
           $last_prof = $db->query("SELECT * FROM GPP_PROFESOR ORDER BY PK_Prof DESC LIMIT 1")->fetch_assoc();
       } else {
           $session->msg("d", "Registro falló.");
           redirect('add_profesor.php', false);
       }
   } else {
       $session->msg("d", $errors);
       redirect('add_profesor.php', false);
   }
}
?>

<?php include_once('layouts/headerPROF.php'); ?>

<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">

            <a href="profesor.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Agregar PROFESOR</strong></div>
      <div class="panel-body">
        <form method="post" action="add_profesor.php">
          <input type="text" class="form-control" name="Nom_Prof" placeholder="Nombre del profesor" required>
          <input type="text" class="form-control" name="Esp_Prof" placeholder="Especialidad" required>
          <input type="text" class="form-control" name="FechCont_Prof" placeholder="Fecha Contrato" required>
          <input type="text" class="form-control" name="Email_Prof" placeholder="Email" required>
          <input type="text" class="form-control" name="Tel_Prof" placeholder="Teléfono" required>
          <input type="number" class="form-control" name="FK_AreaProf" placeholder="ID Área" required>
          <button type="submit" name="add_prof" class="btn btn-primary">Agregar Profesor</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Profesor Agregado</strong></div>
      <div class="panel-body">
        <?php if(!empty($last_prof)): ?>
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th><th>Nombre</th><th>Especialidad</th><th>Fecha Contrato</th>
              <th>Email</th><th>Teléfono</th><th>ID Área</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $last_prof['PK_Prof']; ?></td>
              <td><?php echo remove_junk($last_prof['Nom_Prof']); ?></td>
              <td><?php echo remove_junk($last_prof['Esp_Prof']); ?></td>
              <td><?php echo remove_junk($last_prof['FechCont_Prof']); ?></td>
              <td><?php echo remove_junk($last_prof['Email_Prof']); ?></td>
              <td><?php echo remove_junk($last_prof['Tel_Prof']); ?></td>
              <td><?php echo remove_junk($last_prof['FK_AreaProf']); ?></td>
            </tr>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
