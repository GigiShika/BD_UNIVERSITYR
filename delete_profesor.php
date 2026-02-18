<?php
$page_title = 'Eliminar PROFESOR';
require_once('includes/load.php');
page_require_level(1);

// Variable para guardar el profesor temporalmente
$found_prof = [];

/* ==========================================================
   PASO 1 → BUSCAR PROFESOR POR ID
   ========================================================== */
if(isset($_POST['search_pk'])){
    $PK_Prof = (int)$_POST['PK_Prof'];

    // Buscar profesor
    $sql = "SELECT * FROM GPP_PROFESOR WHERE PK_Prof = '{$PK_Prof}' LIMIT 1";
    $result = $db->query($sql);

    if($db->num_rows($result) == 0){
        $session->msg("d", "No existe un profesor con ID {$PK_Prof}");
        redirect('delete_profesor.php', false);
    }

    $found_prof = $db->fetch_assoc($result);
}

/* ==========================================================
   PASO 2 → CONFIRMAR Y ELIMINAR
   ========================================================== */
if(isset($_POST['delete_prof'])){
    $PK_Prof = (int)$_POST['PK_Prof'];

    // Verificar existencia
    $check = $db->query("SELECT * FROM GPP_PROFESOR WHERE PK_Prof='{$PK_Prof}' LIMIT 1");
    if($db->num_rows($check) == 0){
        $session->msg("d", "El profesor ya no existe.");
        redirect('delete_profesor.php', false);
    }

    // Verificar referencias reales en GPP_PROF_TITU_ASIG
    $refs = $db->query("SELECT COUNT(*) AS total FROM GPP_PROF_TITU_ASIG WHERE FK_COD_PROF = '{$PK_Prof}'");
    $refs_count = $db->fetch_assoc($refs);

    if($refs_count['total'] > 0){
        $session->msg("d", "No se puede eliminar: el profesor está asociado a {$refs_count['total']} registro(s) de titulaciones/asignaturas.");
        redirect('delete_profesor.php', false);
    }

    // Eliminar
    $delete_sql = "DELETE FROM GPP_PROFESOR WHERE PK_Prof='{$PK_Prof}'";
    $delete = $db->query($delete_sql);

    if($delete && $db->affected_rows() > 0){
        $session->msg("s", "Profesor eliminado correctamente.");
        redirect('delete_profesor.php', false);
    } else {
        $session->msg("d", "Error al eliminar el profesor.");
        redirect('delete_profesor.php', false);
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

    <!-- =======================================
         FORMULARIO PASO 1: BUSCAR ID
         ======================================= -->
    <?php if(empty($found_prof)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-search"></span>
                    Buscar PROFESOR por ID
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="delete_profesor.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Prof" placeholder="ID del profesor" required min="1">
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">
                        Buscar
                    </button>
                </form>
            </div>
        </div>

       <a href="profesor.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
    </div>
    <?php endif; ?>


    <!-- =======================================
         PASO 2: MOSTRAR INFO Y CONFIRMAR
         ======================================= -->
    <?php if(!empty($found_prof)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-trash"></span>
                    Confirmar Eliminación del PROFESOR ID <?php echo $found_prof['PK_Prof']; ?>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nombre</th>
                        <td><?php echo remove_junk($found_prof['Nom_Prof']); ?></td>
                    </tr>
                    <tr>
                        <th>Especialidad</th>
                        <td><?php echo remove_junk($found_prof['Esp_Prof']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo remove_junk($found_prof['Email_Prof']); ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td><?php echo remove_junk($found_prof['Tel_Prof']); ?></td>
                    </tr>
                </table>

                <form method="post" action="delete_profesor.php" onsubmit="return confirm('¿ESTÁ SEGURO? Esta acción no se puede deshacer.');">
                    <input type="hidden" name="PK_Prof" value="<?php echo $found_prof['PK_Prof']; ?>">
                    <button type="submit" name="delete_prof" class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash"></span> Eliminar DEFINITIVAMENTE
                    </button>
                </form>

                <br>

                <a href="delete_profesor.php" class="btn btn-default">Cancelar</a>
                <a href="profesor.php" class="btn btn-info">Atrás</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php include_once('layouts/footer.php'); ?>
