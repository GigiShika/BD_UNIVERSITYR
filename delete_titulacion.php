<?php
$page_title = 'Eliminar TITULACIÓN';
require_once('includes/load.php');
page_require_level(1);

// Variable para guardar la titulación encontrada temporalmente
$found_titu = [];

/* ==========================================================
   PASO 1 → BUSCAR TITULACIÓN POR ID
   ========================================================== */
if (isset($_POST['search_pk'])) {
    $PK_Titu = (int)$_POST['PK_Titu'];

    // Buscar titulación
    $sql = "SELECT * FROM GPP_TITULACION WHERE PK_Titu = '{$PK_Titu}' LIMIT 1";
    $result = $db->query($sql);

    if ($db->num_rows($result) == 0) {
        $session->msg("d", "No existe una titulación con ID {$PK_Titu}");
        redirect('delete_titulacion.php', false);
    }

    $found_titu = $db->fetch_assoc($result);
}

/* ==========================================================
   PASO 2 → CONFIRMAR Y ELIMINAR
   ========================================================== */
if (isset($_POST['delete_titu'])) {
    $PK_Titu = (int)$_POST['PK_Titu'];

    // Verificar existencia
    $check = $db->query("SELECT * FROM GPP_TITULACION WHERE PK_Titu = '{$PK_Titu}' LIMIT 1");
    if ($db->num_rows($check) == 0) {
        $session->msg("d", "La titulación ya no existe.");
        redirect('delete_titulacion.php', false);
    }

    // Verificar referencias en GPP_PROF_TITU_ASIG (no permitir borrado si existen)
    $refs = $db->query("SELECT COUNT(*) AS total FROM GPP_PROF_TITU_ASIG WHERE FK_COD_TITULO = '{$PK_Titu}'");
    $refs_count = $db->fetch_assoc($refs);

    if ($refs_count['total'] > 0) {
        $session->msg("d", "No se puede eliminar: tiene {$refs_count['total']} referencia(s) en profesores/titulaciones/asignaturas.");
        redirect('delete_titulacion.php', false);
    }

    // Si no hay referencias, eliminar
    $delete_sql = "DELETE FROM GPP_TITULACION WHERE PK_Titu = '{$PK_Titu}'";
    $delete = $db->query($delete_sql);

    if ($delete && $db->affected_rows() > 0) {
        $session->msg("s", "Titulación eliminada correctamente.");
        redirect('delete_titulacion.php', false);
    } else {
        $session->msg("d", "Error al eliminar la titulación.");
        redirect('delete_titulacion.php', false);
    }
}

?>

<?php include_once('layouts/headerTITU.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">

    <!-- =======================================
         FORMULARIO PASO 1: BUSCAR ID
         ======================================= -->
    <?php if (empty($found_titu)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-search"></span>
                    Buscar TITULACIÓN por ID
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="delete_titulacion.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Titu" placeholder="ID de la titulación" required min="1">
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">
                        Buscar
                    </button>
                </form>
            </div>
        </div>

        <a href="titulacion.php" class="btn btn-info float-btn-left">
            <i class="glyphicon glyphicon-th-large"></i> ATRÁS
        </a>
    </div>
    <?php endif; ?>


    <!-- =======================================
         PASO 2: MOSTRAR INFO Y CONFIRMAR
         ======================================= -->
    <?php if (!empty($found_titu)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">

            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-trash"></span>
                    Confirmar Eliminación de TITULACIÓN ID <?php echo $found_titu['PK_Titu']; ?>
                </strong>
            </div>

            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Duración</th>
                        <td><?php echo $found_titu['Dur_Titu']; ?> semestres</td>
                    </tr>
                    <tr>
                        <th>Créditos Totales</th>
                        <td><?php echo $found_titu['CredTot_Titu']; ?></td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td><?php echo ucfirst($found_titu['Tipo_Titu']); ?></td>
                    </tr>
                    <tr>
                        <th>Coordinador</th>
                        <td><?php echo $found_titu['Coord_Titu']; ?></td>
                    </tr>
                </table>

                <form method="post" action="delete_titulacion.php" onsubmit="return confirm('¿ESTÁ SEGURO? Esta acción no se puede deshacer.');">
                    <input type="hidden" name="PK_Titu" value="<?php echo $found_titu['PK_Titu']; ?>">
                    <button type="submit" name="delete_titu" class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash"></span> Eliminar DEFINITIVAMENTE
                    </button>
                </form>

                <br>
                <a href="delete_titulacion.php" class="btn btn-default">Cancelar</a>
                <a href="titulacion.php" class="btn btn-info">Atrás</a>

            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php include_once('layouts/footer.php'); ?>
