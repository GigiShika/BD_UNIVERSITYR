<?php $page_title = 'Agregar ASIGNATURA'; require_once('includes/load.php'); page_require_level(1); $last_asig = []; ?> 
<?php 
if(isset($_POST['add_asig'])){
   $req_field = array('Nom_Asign','HorasTeo','HorasPrac','Creditos','Semestre','Tipo_Asign','FK_AreaAsign','FK_TituAsign'); 
   validate_fields($req_field); 
   $Nom_Asign = remove_junk($db->escape($_POST['Nom_Asign'])); 
   $HorasTeo = remove_junk($db->escape($_POST['HorasTeo'])); 
   $HorasPrac = remove_junk($db->escape($_POST['HorasPrac'])); 
   $Creditos = remove_junk($db->escape($_POST['Creditos'])); 
   $Semestre = remove_junk($db->escape($_POST['Semestre'])); 
   $Tipo_Asign = remove_junk($db->escape($_POST['Tipo_Asign'])); 
   $FK_AreaAsign= remove_junk($db->escape($_POST['FK_AreaAsign'])); 
   $FK_TituAsign= remove_junk($db->escape($_POST['FK_TituAsign'])); 

   if(empty($errors)){ 
       $sql = "INSERT INTO GPP_ASIGNATURA (Nom_Asign,HorasTeo,HorasPrac,Creditos,Semestre,Tipo_Asign,FK_AreaAsign,FK_TituAsign) "; 
       $sql .= "VALUES ('{$Nom_Asign}','{$HorasTeo}','{$HorasPrac}','{$Creditos}','{$Semestre}','{$Tipo_Asign}','{$FK_AreaAsign}','{$FK_TituAsign}')"; 
       if($db->query($sql)){ 
           $session->msg("s", "Asignatura agregada exitosamente."); 
           $last_asig = $db->query("SELECT * FROM GPP_ASIGNATURA ORDER BY PK_Asign DESC LIMIT 1")->fetch_assoc(); 
       } else { 
           $session->msg("d", "Registro falló."); 
           redirect('add_asignatura.php', false); 
       } 
   } else { 
       $session->msg("d", $errors); 
       redirect('add_asignatura.php', false); 
   } 
} 
?> 

<?php include_once('layouts/headerasignatura.php'); ?> 
<div class="row"> 
  <div class="col-md-12"><?php echo display_msg($msg); ?></div> 
</div> 
<div class="row"> 
  <div class="col-md-4"> 
    <div class="panel panel-default"> 
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Agregar ASIGNATURA</strong></div> 
      <div class="panel-body"> 
        <form method="post" action="add_asignatura.php"> 
          <input type="text" class="form-control" name="Nom_Asign" placeholder="Nombre de la asignatura" required> 
          <input type="number" class="form-control" name="HorasTeo" placeholder="Horas Teoría" required> 
          <input type="number" class="form-control" name="HorasPrac" placeholder="Horas Práctica" required> 
          <input type="number" class="form-control" name="Creditos" placeholder="Créditos" required> 
          <input type="number" class="form-control" name="Semestre" placeholder="Semestre" required> 
          <input type="text" class="form-control" name="Tipo_Asign" placeholder="Tipo" required> 
          <input type="number" class="form-control" name="FK_AreaAsign" placeholder="ID Área" required> 
          <input type="number" class="form-control" name="FK_TituAsign" placeholder="ID Titulación" required> 
          <button type="submit" name="add_asig" class="btn btn-primary">Agregar Asignatura</button> 
        </form> 
      </div> 
        <a href="asignatura.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
    </div> 
  </div> 
  <div class="col-md-8"> 
    <div class="panel panel-default"> 
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Asignatura Agregada</strong></div> 
      <div class="panel-body"> 
        <?php if(!empty($last_asig)): ?> 
        <table class="table table-bordered table-striped table-hover"> 
          <thead> 
            <tr> 
              <th>ID</th><th>Nombre</th><th>Horas Teoría</th><th>Horas Práctica</th> 
              <th>Créditos</th><th>Semestre</th><th>Tipo</th><th>ID Área</th><th>ID Titulación</th> 
            </tr> 
          </thead> 
          <tbody> 
            <tr> 
              <td><?php echo $last_asig['PK_Asign']; ?></td> 
              <td><?php echo remove_junk($last_asig['Nom_Asign']); ?></td> 
              <td><?php echo remove_junk($last_asig['HorasTeo']); ?></td> 
              <td><?php echo remove_junk($last_asig['HorasPrac']); ?></td> 
              <td><?php echo remove_junk($last_asig['Creditos']); ?></td> 
              <td><?php echo remove_junk($last_asig['Semestre']); ?></td> 
              <td><?php echo remove_junk($last_asig['Tipo_Asign']); ?></td> 
              <td><?php echo remove_junk($last_asig['FK_AreaAsign']); ?></td> 
              <td><?php echo remove_junk($last_asig['FK_TituAsign']); ?></td> 
            </tr> 
          </tbody> 
        </table> 
        <?php endif; ?> 
      </div> 
    </div> 
  </div> 
</div> 
<?php include_once('layouts/footer.php'); ?>
