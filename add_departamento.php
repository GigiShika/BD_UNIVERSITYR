<?php
  $page_title = 'Agregar DEPARTAMENTO';
  require_once('includes/load.php'); 
  page_require_level(1);

  // Variable para mostrar solo el último departamento agregado
  $last_departamento = [];
?>


<?php
if(isset($_POST['add_cat'])){
   $req_field = array('PK_Dpto','Nom_Dpto','FechCre_Dpto','Tel_Dpto','Email_Dpto','Coord_Dpto');
   validate_fields($req_field);

   $PK_Dpto      = remove_junk($db->escape($_POST['PK_Dpto']));
   $Nom_Dpto     = remove_junk($db->escape($_POST['Nom_Dpto']));
   $FechCre_Dpto = remove_junk($db->escape($_POST['FechCre_Dpto']));
   $Tel_Dpto     = remove_junk($db->escape($_POST['Tel_Dpto']));
   $Email_Dpto   = remove_junk($db->escape($_POST['Email_Dpto']));
   $Coord_Dpto   = remove_junk($db->escape($_POST['Coord_Dpto']));

// Verificar que el ID no exista
   $sql_check = "SELECT * FROM GPP_DEPARTAMENTO WHERE PK_Dpto='{$PK_Dpto}' LIMIT 1";
   $result_check = $db->query($sql_check);

   if($result_check->num_rows > 0){
       $session->msg("d", "El ID {$PK_Dpto} ya existe. Elige otro.");
       redirect('add_departamento.php', false);
   } else if(empty($errors)){
       $sql  = "INSERT INTO GPP_DEPARTAMENTO (PK_Dpto, Nom_Dpto, FechCre_Dpto, Tel_Dpto, Email_Dpto, Coord_Dpto) ";
       $sql .= "VALUES ('{$PK_Dpto}', '{$Nom_Dpto}', '{$FechCre_Dpto}', '{$Tel_Dpto}', '{$Email_Dpto}', '{$Coord_Dpto}')";
       if($db->query($sql)){
           $session->msg("s", "Departamento agregado exitosamente.");
           // Traer solo el último departamento agregado
           $last_departamento_sql = "SELECT * FROM GPP_DEPARTAMENTO WHERE PK_Dpto='{$PK_Dpto}' LIMIT 1";
           $last_departamento = $db->query($last_departamento_sql)->fetch_assoc();
       } else {
           $session->msg("d", "Lo siento, registro falló.");
           redirect('add_departamento.php', false);
       }
   } else {
       $session->msg("d", $errors);
       redirect('add_departamento.php', false);
   }
}
?>

<?php include_once('layouts/headerDEP.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">

<!-- FORMULARIO AGREGAR DEPARTAMENTO -->
<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Agregar DEPARTAMENTO</span>
      </strong>
      <!-- Botón a la derecha -->
      <a href="departamento.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
      </a>


    </div>
    <div class="panel-body">
      <form method="post" action="add_departamento.php">
        <div class="form-group">
          <input type="number" class="form-control" name="PK_Dpto" placeholder="ID del departamento" required>
          <input type="text" class="form-control" name="Nom_Dpto" placeholder="Nombre del departamento" required>
          <input type="text" class="form-control" name="FechCre_Dpto" placeholder="Fecha de Creación" required>
          <input type="text" class="form-control" name="Tel_Dpto" placeholder="Teléfono" required>
          <input type="text" class="form-control" name="Email_Dpto" placeholder="Email" required>
          <input type="text" class="form-control" name="Coord_Dpto" placeholder="Coordinador" required>
        </div>
        <button type="submit" name="add_cat" class="btn btn-primary">Agregar DEPARTAMENTO</button>
      </form>
    </div>
  </div>
</div>


  <!-- TABLA SOLO DEL DEPARTAMENTO AGREGADO -->
  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Departamento Agregado</span>
        </strong>
      </div>
      <div class="panel-body">
        <?php if(!empty($last_departamento)): ?>
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">ID</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Fecha Creación</th>
              <th class="text-center">Teléfono</th>
              <th class="text-center">Email</th>
              <th class="text-center">Coordinador</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center"><?php echo (int)$last_departamento['PK_Dpto']; ?></td>
              <td><?php echo remove_junk(ucfirst($last_departamento['Nom_Dpto'])); ?></td>
              <td><?php echo remove_junk(ucfirst($last_departamento['FechCre_Dpto'])); ?></td>
              <td><?php echo remove_junk(ucfirst($last_departamento['Tel_Dpto'])); ?></td>
              <td><?php echo remove_junk(ucfirst($last_departamento['Email_Dpto'])); ?></td>
              <td><?php echo remove_junk(ucfirst($last_departamento['Coord_Dpto'])); ?></td>
            </tr>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

  document.querySelectorAll(".float-btn").forEach(btn => {

    btn.style.transition = "all 0.3s ease-in-out";

    btn.addEventListener("mouseenter", () => {
      btn.style.background = "linear-gradient(90deg, #0c2e8dff, #692eb5ff)";
      btn.style.paddingLeft = "30px";
      btn.style.boxShadow = "0 4px 8px rgba(0,0,0,0.5)";
    });

    btn.addEventListener("mouseleave", () => {
      btn.style.background = "rgba(27, 39, 53, 0.6)";
      btn.style.paddingLeft = "20px";
      btn.style.boxShadow = "none";
    });

  });

});
</script>

<?php include_once('layouts/footer.php'); ?>
