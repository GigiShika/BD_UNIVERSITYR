<?php
$page_title = 'Editar ASIGNATURA';
require_once('includes/load.php');
page_require_level(1);

// Variable para guardar la asignatura encontrada
$edited_item = [];

// Paso 1: Buscar asignatura por PK
if(isset($_POST['search_pk'])){
    $PK_Asign = remove_junk($db->escape($_POST['PK_Asign']));
    $sql_search = "SELECT * FROM GPP_ASIGNATURA WHERE PK_Asign='{$PK_Asign}' LIMIT 1";
    $result_search = $db->query($sql_search);

    if(!$result_search || $result_search->num_rows == 0){
        $session->msg("d", "No existe asignatura con ID {$PK_Asign}");
        redirect('edit_asignatura.php', false);
    } else {
        $edited_item = $result_search->fetch_assoc();
    }
}

// Paso 2: Guardar cambios
if(isset($_POST['edit_item'])){
    $Old_PK     = remove_junk($db->escape($_POST['Old_PK']));
    $Nom_Asign  = remove_junk($db->escape($_POST['Nom_Asign']));
    $HorasTeo   = remove_junk($db->escape($_POST['HorasTeo']));
    $HorasPrac  = remove_junk($db->escape($_POST['HorasPrac']));
    $Creditos   = remove_junk($db->escape($_POST['Creditos']));
    $Semestre   = remove_junk($db->escape($_POST['Semestre']));
    $Tipo_Asign = remove_junk($db->escape($_POST['Tipo_Asign']));

    $sql_update = "UPDATE GPP_ASIGNATURA SET  
                    Nom_Asign='{$Nom_Asign}',
                    HorasTeo='{$HorasTeo}',
                    HorasPrac='{$HorasPrac}',
                    Creditos='{$Creditos}',
                    Semestre='{$Semestre}',
                    Tipo_Asign='{$Tipo_Asign}'
                   WHERE PK_Asign='{$Old_PK}'";

    if($db->query($sql_update)){
        $session->msg("s", "Asignatura actualizada correctamente.");
        $edited_item = $db->query("SELECT * FROM GPP_ASIGNATURA WHERE PK_Asign='{$Old_PK}' LIMIT 1")->fetch_assoc();
    } else {
        $session->msg("d", "Error al actualizar la asignatura.");
        redirect('edit_asignatura.php', false);
    }
}
?>

<?php include_once('layouts/headerasignatura.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">

    <!-- FORMULARIO PASO 1 (Buscar asignatura) -->
    <?php if(empty($edited_item)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-search"></span> Buscar ASIGNATURA por ID</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_asignatura.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Asign" placeholder="ID de la asignatura" required>
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">Buscar</button>
                </form>
            </div>
            <a href="asignatura.php" class="btn btn-info float-btn-left">
              <i class="glyphicon glyphicon-th-large"></i> ATRAS
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- FORMULARIO PASO 2 (Editar asignatura) -->
    <?php if(!empty($edited_item)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-edit"></span> Editar ASIGNATURA</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_asignatura.php">

                    <!-- PK oculta -->
                    <input type="hidden" name="Old_PK" value="<?php echo $edited_item['PK_Asign']; ?>">

                    <div class="form-group">
                        <input type="text" class="form-control mb-1" name="Nom_Asign" value="<?php echo remove_junk($edited_item['Nom_Asign']); ?>" required>
                        <input type="number" class="form-control mb-1" name="HorasTeo" value="<?php echo remove_junk($edited_item['HorasTeo']); ?>" required>
                        <input type="number" class="form-control mb-1" name="HorasPrac" value="<?php echo remove_junk($edited_item['HorasPrac']); ?>" required>
                        <input type="number" class="form-control mb-1" name="Creditos" value="<?php echo remove_junk($edited_item['Creditos']); ?>" required>
                        <input type="number" class="form-control mb-1" name="Semestre" value="<?php echo remove_junk($edited_item['Semestre']); ?>" required>
                        <input type="text" class="form-control mb-1" name="Tipo_Asign" value="<?php echo remove_junk($edited_item['Tipo_Asign']); ?>" required>
                    </div>

                    <button type="submit" name="edit_item" class="btn btn-primary">Actualizar ASIGNATURA</button>
                </form>
            </div>

            <a href="asignatura.php" class="btn btn-info float-btn-left">
              <i class="glyphicon glyphicon-th-large"></i> ATRAS
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- TABLA DE RESULTADOS -->
<?php if(!empty($edited_item)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><span class="glyphicon glyphicon-th-list"></span> Asignatura Editada</strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Horas Teoría</th>
                            <th>Horas Práctica</th>
                            <th>Créditos</th>
                            <th>Semestre</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk($edited_item['Nom_Asign']); ?></td>
                            <td><?php echo remove_junk($edited_item['HorasTeo']); ?></td>
                            <td><?php echo remove_junk($edited_item['HorasPrac']); ?></td>
                            <td><?php echo remove_junk($edited_item['Creditos']); ?></td>
                            <td><?php echo remove_junk($edited_item['Semestre']); ?></td>
                            <td><?php echo remove_junk($edited_item['Tipo_Asign']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include_once('layouts/footer.php'); ?>
