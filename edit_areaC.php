<?php
$page_title = 'Editar ÁREA DE CONOCIMIENTO';
require_once('includes/load.php');
page_require_level(1);

// Variable para guardar el área que se va a editar
$edited_area = [];

// Paso 1: Buscar área por PK
if(isset($_POST['search_pk'])){
    $PK_Area = remove_junk($db->escape($_POST['PK_Area']));
    $sql_search = "SELECT * FROM GPP_AREA_CONOCIMIENTO WHERE PK_Area='{$PK_Area}' LIMIT 1";
    $result_search = $db->query($sql_search);

    if($result_search->num_rows == 0){
        $session->msg("d", "No existe área con ID {$PK_Area}");
        redirect('edit_areaC.php', false);
    } else {
        $edited_area = $result_search->fetch_assoc();
    }
}

// Paso 2: Guardar cambios del área
if(isset($_POST['edit_area'])){
    $PK_Area      = remove_junk($db->escape($_POST['PK_Area']));
    $Nom_Area     = remove_junk($db->escape($_POST['Nom_Area']));
    $Descrip_Area = remove_junk($db->escape($_POST['Descrip_Area']));
    $Coord_Area   = remove_junk($db->escape($_POST['Coord_Area']));
    $FechCre_A    = remove_junk($db->escape($_POST['FechCre_A']));
    $NumProf_A    = remove_junk($db->escape($_POST['NumProf_A']));
    $FK_Dpto      = remove_junk($db->escape($_POST['FK_Dpto']));

    $sql_update = "UPDATE GPP_AREA_CONOCIMIENTO SET 
                    Nom_Area='{$Nom_Area}', 
                    Descrip_Area='{$Descrip_Area}', 
                    Coord_Area='{$Coord_Area}', 
                    FechCre_A='{$FechCre_A}', 
                    NumProf_A='{$NumProf_A}', 
                    FK_Dpto='{$FK_Dpto}'
                   WHERE PK_Area='{$PK_Area}'";

    if($db->query($sql_update)){
        $session->msg("s", "Área de conocimiento actualizada correctamente.");
        $edited_area = $db->query("SELECT * FROM GPP_AREA_CONOCIMIENTO WHERE PK_Area='{$PK_Area}' LIMIT 1")->fetch_assoc();
    } else {
        $session->msg("d", "Error al actualizar el área.");
        redirect('edit_areaC.php', false);
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
    <!-- FORMULARIO PASO 1: INGRESAR PK -->
    <?php if(empty($edited_area)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-search"></span>
                    Buscar ÁREA DE CONOCIMIENTO por ID
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_areaC.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Area" placeholder="ID del área" required>
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">Buscar</button>
                </form>
            </div>

         <a href="area_conocimiento.php" class="btn btn-info float-btn-left">
             <i class="glyphicon glyphicon-th-large"></i> ATRAS
         </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- FORMULARIO PASO 2: EDITAR CAMPOS -->
    <?php if(!empty($edited_area)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-edit"></span>
                    Editar ÁREA DE CONOCIMIENTO ID <?php echo $edited_area['PK_Area']; ?>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_areaC.php">
                    <input type="hidden" name="PK_Area" value="<?php echo $edited_area['PK_Area']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="Nom_Area" value="<?php echo remove_junk($edited_area['Nom_Area']); ?>" required>
                        <input type="text" class="form-control" name="Descrip_Area" value="<?php echo remove_junk($edited_area['Descrip_Area']); ?>" required>
                        <input type="text" class="form-control" name="Coord_Area" value="<?php echo remove_junk($edited_area['Coord_Area']); ?>" required>
                        <input type="text" class="form-control" name="FechCre_A" value="<?php echo remove_junk($edited_area['FechCre_A']); ?>" required>
                        <input type="number" class="form-control" name="NumProf_A" value="<?php echo remove_junk($edited_area['NumProf_A']); ?>" required>
                        <input type="number" class="form-control" name="FK_Dpto" value="<?php echo remove_junk($edited_area['FK_Dpto']); ?>" required>
                    </div>
                    <button type="submit" name="edit_area" class="btn btn-primary">Actualizar Área</button>
                </form>
            </div>

            <a href="view_areaC.php" 
              class="btn btn-info submenu-toggle"
              style="
                  position: fixed;
                  top: 90%;
                  right: 20px;
                  transform: translateY(-50%);
                  z-index: 9999;
                  display: block;
                  color: #ffffff;
                  font-weight: bold;
                  font-size: 14px;
                  padding: 12px 20px;
                  border-left: 4px solid #0b34ff;
                  border-radius: 4px;
                  text-decoration: none;
                  background: rgba(27, 39, 53, 0.6);">
              <i class="glyphicon glyphicon-th-large"></i>
              Mostrar Áreas
            </a>

            <a href="home.php" 
              class="btn btn-info submenu-toggle"
              style="
                  position: fixed;
                  top: 90%;
                  left: 280px;
                  transform: translateY(-50%);
                  z-index: 9999;
                  display: block;
                  color: #ffffff;
                  font-weight: bold;
                  font-size: 14px;
                  padding: 12px 20px;
                  border-left: 4px solid #0b34ff;
                  border-radius: 4px;
                  text-decoration: none;
                  background: rgba(27, 39, 53, 0.6);">
              <i class="glyphicon glyphicon-th-large"></i>
              HOME
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- TABLA DEL ÁREA EDITADA -->
<?php if(!empty($edited_area)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th-list"></span>
                    Área Editada
                </strong>
            </div>
            <div class="panel-body">
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
                            <td class="text-center"><?php echo $edited_area['PK_Area']; ?></td>
                            <td><?php echo remove_junk(ucfirst($edited_area['Nom_Area'])); ?></td>
                            <td><?php echo remove_junk(ucfirst($edited_area['Descrip_Area'])); ?></td>
                            <td><?php echo remove_junk(ucfirst($edited_area['Coord_Area'])); ?></td>
                            <td><?php echo remove_junk(ucfirst($edited_area['FechCre_A'])); ?></td>
                            <td><?php echo remove_junk($edited_area['NumProf_A']); ?></td>
                            <td><?php echo remove_junk($edited_area['FK_Dpto']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include_once('layouts/footer.php'); ?>
