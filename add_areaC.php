<?php 
$page_title = 'Agregar ÁREA DE CONOCIMIENTO';
require_once('includes/load.php');
page_require_level(1);

// Variable para mostrar solo el último área agregada
$last_area = [];
?>

<?php
if(isset($_POST['add_area'])){
    $req_fields = array('Nom_Area','Descrip_Area','Coord_Area','FechCre_A','NumProf_A','FK_Dpto');
    validate_fields($req_fields);

    $Nom_Area     = remove_junk($db->escape($_POST['Nom_Area']));
    $Descrip_Area = remove_junk($db->escape($_POST['Descrip_Area']));
    $Coord_Area   = remove_junk($db->escape($_POST['Coord_Area']));
    $FechCre_A    = remove_junk($db->escape($_POST['FechCre_A']));
    $NumProf_A    = remove_junk($db->escape($_POST['NumProf_A']));
    $FK_Dpto      = remove_junk($db->escape($_POST['FK_Dpto']));

// Insertar el área en la base de datos
    if(empty($errors)){
        $sql  = "INSERT INTO GPP_AREA_CONOCIMIENTO ";
        $sql .= "(Nom_Area, Descrip_Area, Coord_Area, FechCre_A, NumProf_A, FK_Dpto) ";
        $sql .= "VALUES ('{$Nom_Area}', '{$Descrip_Area}', '{$Coord_Area}', '{$FechCre_A}', '{$NumProf_A}', '{$FK_Dpto}')";
        
        if($db->query($sql)){
            $session->msg("s", "Área de conocimiento agregada exitosamente.");
            // Traer solo el último área agregada
            $last_area_sql = "SELECT * FROM GPP_AREA_CONOCIMIENTO ORDER BY PK_Area DESC LIMIT 1";
            $last_area = $db->query($last_area_sql)->fetch_assoc();
        } else {
            $session->msg("d", "Lo siento, registro falló.");
        }
        redirect('add_areaC.php', false);
    } else {
        $session->msg("d", $errors);
        redirect('add_areaC.php', false);
    }
}
?>

<?php include_once('layouts/headerAREAC.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">

  <!-- FORMULARIO AGREGAR ÁREA DE CONOCIMIENTO -->
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Agregar ÁREA DE CONOCIMIENTO</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_areaC.php">
          <div class="form-group">
            <input type="text" class="form-control" name="Nom_Area" placeholder="Nombre del área" required>
            <input type="text" class="form-control" name="Descrip_Area" placeholder="Descripción" required>
            <input type="text" class="form-control" name="Coord_Area" placeholder="Coordinador" required>
            <input type="text" class="form-control" name="FechCre_A" placeholder="Fecha Creación" required>
            <input type="number" class="form-control" name="NumProf_A" placeholder="Número de Profesores" required>
            <input type="number" class="form-control" name="FK_Dpto" placeholder="ID Departamento" required>
          </div>
          <button type="submit" name="add_area" class="btn btn-primary">Agregar Área</button>
        </form>
      </div>
    </div>
  </div>

  <!-- TABLA SOLO DEL ÁREA AGREGADA -->
  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Área Agregada</span>
        </strong>
      </div>
      <a href="area_conocimiento.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
      </a>


      <div class="panel-body">
        <?php if(!empty($last_area)): ?>
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">ID</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Descripción</th>
              <th class="text-center">Coordinador</th>
              <th class="text-center">Fecha Creación</th>
              <th class="text-center">Num Profesores</th>
              <th class="text-center">ID Departamento</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center"><?php echo (int)$last_area['PK_Area']; ?></td>
              <td><?php echo remove_junk(ucfirst($last_area['Nom_Area'])); ?></td>
              <td><?php echo remove_junk(ucfirst($last_area['Descrip_Area'])); ?></td>
              <td><?php echo remove_junk(ucfirst($last_area['Coord_Area'])); ?></td>
              <td><?php echo remove_junk(ucfirst($last_area['FechCre_A'])); ?></td>
              <td><?php echo remove_junk($last_area['NumProf_A']); ?></td>
              <td><?php echo remove_junk($last_area['FK_Dpto']); ?></td>
            </tr>
          </tbody>
        </table>
        <?php else: ?>
          <p>No se ha agregado ningún área todavía.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
