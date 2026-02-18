<?php 
  $page_title = 'Agregar TITULACIÓN';
  require_once('includes/load.php');
  page_require_level(1);
  $last_titu = [];
?>

<?php
if(isset($_POST['add_titu'])){
   $req_field = array('Dur_Titu','CredTot_Titu','Tipo_Titu','FechCre_Titu','Coord_Titu');
   validate_fields($req_field);

   $Dur_Titu     = remove_junk($db->escape($_POST['Dur_Titu']));
   $CredTot_Titu = remove_junk($db->escape($_POST['CredTot_Titu']));
   $Tipo_Titu    = remove_junk($db->escape($_POST['Tipo_Titu']));
   $FechCre_Titu = remove_junk($db->escape($_POST['FechCre_Titu']));
   $Coord_Titu   = remove_junk($db->escape($_POST['Coord_Titu']));

   if(empty($errors)){
       $sql  = "INSERT INTO GPP_TITULACION (Dur_Titu, CredTot_Titu, Tipo_Titu, FechCre_Titu, Coord_Titu) ";
       $sql .= "VALUES ('{$Dur_Titu}','{$CredTot_Titu}','{$Tipo_Titu}','{$FechCre_Titu}','{$Coord_Titu}')";
       if($db->query($sql)){
           $session->msg("s", "Titulación agregada exitosamente.");
           $last_titu = $db->query("SELECT * FROM GPP_TITULACION ORDER BY PK_Titu DESC LIMIT 1")->fetch_assoc();
       } else {
           $session->msg("d", "Registro falló.");
           redirect('add_titulacion.php', false);
       }
   } else {
       $session->msg("d", $errors);
       redirect('add_titulacion.php', false);
   }
}
?>

<?php include_once('layouts/headerTITU.php'); ?>

<div class="row">
  <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
        <a href="titulacion.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Agregar TITULACIÓN</strong></div>
      <div class="panel-body">
        <form method="post" action="add_titulacion.php">
          <input type="number" class="form-control" name="Dur_Titu" placeholder="Duración" required>
          <input type="number" class="form-control" name="CredTot_Titu" placeholder="Créditos Totales" required>
          <input type="text" class="form-control" name="Tipo_Titu" placeholder="Tipo" required>
          <input type="text" class="form-control" name="FechCre_Titu" placeholder="Fecha Creación" required>
          <input type="text" class="form-control" name="Coord_Titu" placeholder="Coordinador" required>
          <button type="submit" name="add_titu" class="btn btn-primary">Agregar Titulación</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Titulación Agregada</strong></div>
      <div class="panel-body">
        <?php if(!empty($last_titu)): ?>
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th><th>Duración</th><th>Créditos Totales</th><th>Tipo</th>
              <th>Fecha Creación</th><th>Coordinador</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $last_titu['PK_Titu']; ?></td>
              <td><?php echo remove_junk($last_titu['Dur_Titu']); ?></td>
              <td><?php echo remove_junk($last_titu['CredTot_Titu']); ?></td>
              <td><?php echo remove_junk($last_titu['Tipo_Titu']); ?></td>
              <td><?php echo remove_junk($last_titu['FechCre_Titu']); ?></td>
              <td><?php echo remove_junk($last_titu['Coord_Titu']); ?></td>
            </tr>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
