<?php
$page_title = 'Editar TITULACIÓN';
require_once('includes/load.php');
page_require_level(1);

$edited_item = [];

// Paso 1: Buscar titulación por PK
if(isset($_POST['search_pk'])){
    $PK = remove_junk($db->escape($_POST['PK_Titulacion']));
    $result_search = $db->query("SELECT * FROM GPP_TITULACION WHERE PK_Titu='{$PK}' LIMIT 1");

    if(!$result_search || $result_search->num_rows == 0){
        $session->msg("d", "No existe titulación con ID {$PK}");
        redirect('edit_titulacion.php', false);
    } else {
        $edited_item = $result_search->fetch_assoc();
    }
}

// Paso 2: Guardar cambios
if(isset($_POST['edit_item'])){
    $Dur_Titu = remove_junk($db->escape($_POST['Dur_Titu']));
    $CredTot_Titu = remove_junk($db->escape($_POST['CredTot_Titu']));
    $Tipo_Titu = remove_junk($db->escape($_POST['Tipo_Titu']));
    $Coord_Titu = remove_junk($db->escape($_POST['Coord_Titu']));

    $sql_update = "UPDATE GPP_TITULACION SET 
                    Dur_Titu='{$Dur_Titu}',
                    CredTot_Titu='{$CredTot_Titu}',
                    Tipo_Titu='{$Tipo_Titu}',
                    Coord_Titu='{$Coord_Titu}'
                   WHERE PK_Titu='{$PK}'";

    if($db->query($sql_update)){
        $session->msg("s", "Titulación actualizada correctamente.");
        $edited_item = $db->query("SELECT * FROM GPP_TITULACION WHERE PK_Titu='{$PK}' LIMIT 1")->fetch_assoc();
    } else {
        $session->msg("d", "Error al actualizar la titulación.");
        redirect('edit_titulacion.php', false);
    }
}
?>

<?php include_once('layouts/headerTITU.php'); ?>

<div class="row">
    <div class="col-md-12"><?php echo display_msg($msg); ?></div>
</div>

<div class="row">
    <!-- FORMULARIO PASO 1: INGRESAR PK -->
    <?php if(empty($edited_item)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-search"></span> Buscar TITULACIÓN por ID</strong></div>
            <div class="panel-body">
                <form method="post" action="">
                    <input type="number" class="form-control" name="PK_Titulacion" placeholder="ID de la titulación" required>
                    <button type="submit" name="search_pk" class="btn btn-info mt-2">Buscar</button>
                </form>
            </div>
        </div>

        <a href="titulacion.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
    </div>
    <?php endif; ?>

    <!-- FORMULARIO PASO 2: EDITAR CAMPOS -->
    <?php if(!empty($edited_item)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-edit"></span> Editar TITULACIÓN ID <?php echo $edited_item['PK_Titu']; ?></strong></div>
            <div class="panel-body">
                <form method="post" action="">
                    <input type="hidden" name="PK_Titulacion" value="<?php echo $edited_item['PK_Titu']; ?>">

                    <input type="number" class="form-control mb-1" name="Dur_Titu" value="<?php echo remove_junk($edited_item['Dur_Titu']); ?>" placeholder="Duración" required>
                    <input type="number" class="form-control mb-1" name="CredTot_Titu" value="<?php echo remove_junk($edited_item['CredTot_Titu']); ?>" placeholder="Créditos Totales" required>
                    <input type="text" class="form-control mb-1" name="Tipo_Titu" value="<?php echo remove_junk($edited_item['Tipo_Titu']); ?>" placeholder="Tipo de Titulación" required>
                    <input type="text" class="form-control mb-1" name="Coord_Titu" value="<?php echo remove_junk($edited_item['Coord_Titu']); ?>" placeholder="Coordinador" required>

                    <button type="submit" name="edit_item" class="btn btn-primary">Actualizar Titulación</button>
                </form>
            </div>
        </div>
        <a href="titulacion.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- TABLA TITULACIÓN EDITADA -->
<?php if(!empty($edited_item)): ?>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Titulación Editada</strong></div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Duración</th>
                            <th>Créditos Totales</th>
                            <th>Tipo</th>
                            <th>Coordinador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk($edited_item['Dur_Titu']); ?></td>
                            <td><?php echo remove_junk($edited_item['CredTot_Titu']); ?></td>
                            <td><?php echo remove_junk($edited_item['Tipo_Titu']); ?></td>
                            <td><?php echo remove_junk($edited_item['Coord_Titu']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include_once('layouts/footer.php'); ?>
