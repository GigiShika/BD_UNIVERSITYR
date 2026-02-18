<?php
$page_title = 'Editar PROFESOR';
require_once('includes/load.php');
page_require_level(3);

$edited_profesor = [];

// Paso 1: Buscar profesor por PK
if(isset($_POST['search_pk'])){
    $PK_Prof = remove_junk($db->escape($_POST['PK_Prof']));
    $result_search = $db->query("SELECT * FROM GPP_PROFESOR WHERE PK_Prof='{$PK_Prof}' LIMIT 1");

    if(!$result_search || $result_search->num_rows == 0){
        $session->msg("d", "No existe profesor con ID {$PK_Prof}");
        redirect('edit_profesorprof.php', false);
    } else {
        $edited_profesor = $result_search->fetch_assoc();
    }
}

// Paso 2: Guardar cambios
if(isset($_POST['edit_cat'])){
    $PK_Prof = remove_junk($db->escape($_POST['PK_Prof']));
    $Email_Prof = remove_junk($db->escape($_POST['Email_Prof']));
    $Tel_Prof = remove_junk($db->escape($_POST['Tel_Prof']));

    $sql_update = "UPDATE GPP_PROFESOR SET 
                    Email_Prof='{$Email_Prof}', 
                    Tel_Prof='{$Tel_Prof}' 
                   WHERE PK_Prof='{$PK_Prof}'";

    if($db->query($sql_update)){
        $session->msg("s", "Profesor actualizado correctamente.");
        $edited_profesor = $db->query("SELECT * FROM GPP_PROFESOR WHERE PK_Prof='{$PK_Prof}' LIMIT 1")->fetch_assoc();
    } else {
        $session->msg("d", "Error al actualizar el profesor.");
        redirect('edit_profesorprof.php', false);
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
                <form method="post" action="edit_profesorprof.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Prof" placeholder="ID del profesor" required>
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">Buscar</button>
                </form>
            </div>
        </div>

        <a href="profesorprof.php" class="btn btn-info float-btn-left">
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
                <form method="post" action="edit_profesorprof.php">
                    <input type="hidden" name="PK_Prof" value="<?php echo $edited_profesor['PK_Prof']; ?>">
                    <div class="form-group">
                        <input type="email" class="form-control" name="Email_Prof" value="<?php echo remove_junk($edited_profesor['Email_Prof']); ?>" placeholder="Email" required>
                        <input type="text" class="form-control" name="Tel_Prof" value="<?php echo remove_junk($edited_profesor['Tel_Prof']); ?>" placeholder="Teléfono" required>
                    </div>
                    <button type="submit" name="edit_cat" class="btn btn-primary">Actualizar PROFESOR</button>
                    <a href="profesorprof.php" class="btn btn-info float-btn-left">
                        <i class="glyphicon glyphicon-th-large"></i> ATRAS
                    </a>
                </form>
            </div>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucfirst($edited_profesor['Nom_Prof'])); ?></td>
                            <td><?php echo remove_junk($edited_profesor['Email_Prof']); ?></td>
                            <td><?php echo remove_junk($edited_profesor['Tel_Prof']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include_once('layouts/footer.php'); ?>
