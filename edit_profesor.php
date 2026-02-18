<?php
$page_title = 'Editar PROFESOR';
require_once('includes/load.php');
page_require_level(1);

$edited_profesor = [];

// Traer todas las áreas para el select
$areas = $db->query("SELECT PK_Area, Nom_Area, FK_Dpto FROM GPP_AREA_CONOCIMIENTO ORDER BY Nom_Area ASC");

// Paso 1: Buscar profesor por PK
if(isset($_POST['search_pk'])){
    $PK_Prof = remove_junk($db->escape($_POST['PK_Prof']));
    $result_search = $db->query("SELECT * FROM GPP_PROFESOR WHERE PK_Prof='{$PK_Prof}' LIMIT 1");

    if(!$result_search || $result_search->num_rows == 0){
        $session->msg("d", "No existe profesor con ID {$PK_Prof}");
        redirect('edit_profesor.php', false);
    } else {
        $edited_profesor = $result_search->fetch_assoc();
    }
}

// Paso 2: Guardar cambios
if(isset($_POST['edit_cat'])){
    $PK_Prof = remove_junk($db->escape($_POST['PK_Prof']));
    $Nom_Prof = remove_junk($db->escape($_POST['Nom_Prof']));
    $Email_Prof = remove_junk($db->escape($_POST['Email_Prof']));
    $Tel_Prof = remove_junk($db->escape($_POST['Tel_Prof']));
    $FK_AreaProf = remove_junk($db->escape($_POST['FK_AreaProf']));

    $sql_update = "UPDATE GPP_PROFESOR SET 
                    Nom_Prof='{$Nom_Prof}', 
                    Email_Prof='{$Email_Prof}', 
                    Tel_Prof='{$Tel_Prof}', 
                    FK_AreaProf='{$FK_AreaProf}'
                   WHERE PK_Prof='{$PK_Prof}'";

    if($db->query($sql_update)){
        $session->msg("s", "Profesor actualizado correctamente.");
        $edited_profesor = $db->query("SELECT * FROM GPP_PROFESOR WHERE PK_Prof='{$PK_Prof}' LIMIT 1")->fetch_assoc();
    } else {
        $session->msg("d", "Error al actualizar el profesor.");
        redirect('edit_profesor.php', false);
    }
}
?>

<?php include_once('layouts/headerPROF.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <!-- FORMULARIO PASO 1: INGRESAR PK -->
    <?php if(empty($edited_profesor)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-search"></span> Buscar PROFESOR por ID</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_profesor.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Prof" placeholder="ID del profesor" required>
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">Buscar</button>
                </form>
            </div>
        </div>

      <a href="profesor.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
      </a>

    </div>
    <?php endif; ?>

    <!-- FORMULARIO PASO 2: EDITAR CAMPOS -->
    <?php if(!empty($edited_profesor)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-edit"></span> Editar PROFESOR ID <?php echo $edited_profesor['PK_Prof']; ?></strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_profesor.php">
                    <input type="hidden" name="PK_Prof" value="<?php echo $edited_profesor['PK_Prof']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="Nom_Prof" value="<?php echo remove_junk($edited_profesor['Nom_Prof']); ?>" placeholder="Nombre" required>
                        <input type="email" class="form-control" name="Email_Prof" value="<?php echo remove_junk($edited_profesor['Email_Prof']); ?>" placeholder="Email" required>
                        <input type="text" class="form-control" name="Tel_Prof" value="<?php echo remove_junk($edited_profesor['Tel_Prof']); ?>" placeholder="Teléfono" required>

                        <select name="FK_AreaProf" class="form-control" required>
                            <option value="">Selecciona Área</option>
                            <?php
                            $areas = $db->query("SELECT PK_Area, Nom_Area, FK_Dpto FROM GPP_AREA_CONOCIMIENTO ORDER BY Nom_Area ASC");
                            while($area = $areas->fetch_assoc()):
                                $dpto = $db->query("SELECT Nom_Dpto FROM GPP_DEPARTAMENTO WHERE PK_Dpto='{$area['FK_Dpto']}' LIMIT 1")->fetch_assoc();
                            ?>
                            <option value="<?php echo $area['PK_Area']; ?>" <?php if($edited_profesor['FK_AreaProf']==$area['PK_Area']) echo 'selected'; ?>>
                                <?php echo $area['Nom_Area'] . " (" . $dpto['Nom_Dpto'] . ")"; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>

                    </div>
                    <button type="submit" name="edit_cat" class="btn btn-primary">Actualizar PROFESOR</button>
                </form>
            </div>

        <a href="edit_profesor.php" class="btn btn-info float-btn-left">
            <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>

        </div>
    </div>
    <?php endif; ?>
</div>

<!-- TABLA DEL PROFESOR EDITADO -->
<?php if(!empty($edited_profesor)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th-list"></span> Profesor Editado</strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Área</th>
                            <th class="text-center">Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucfirst($edited_profesor['Nom_Prof'])); ?></td>
                            <td><?php echo remove_junk($edited_profesor['Email_Prof']); ?></td>
                            <td><?php echo remove_junk($edited_profesor['Tel_Prof']); ?></td>
                            <?php
                                $area = $db->query("SELECT Nom_Area, FK_Dpto FROM GPP_AREA_CONOCIMIENTO WHERE PK_Area='{$edited_profesor['FK_AreaProf']}'")->fetch_assoc();
                                $dpto = $db->query("SELECT Nom_Dpto FROM GPP_DEPARTAMENTO WHERE PK_Dpto='{$area['FK_Dpto']}'")->fetch_assoc();
                            ?>
                            <td><?php echo remove_junk($area['Nom_Area']); ?></td>
                            <td><?php echo remove_junk($dpto['Nom_Dpto']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include_once('layouts/footer.php'); ?>
