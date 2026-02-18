<?php
$page_title = 'Eliminar ASIGNATURA';
require_once('includes/load.php');
page_require_level(1);

// Variable donde se guardará la asignatura encontrada
$found_asig = [];

/* ==========================================================
   PASO 1 → BUSCAR ASIGNATURA POR ID
   ========================================================== */
if(isset($_POST['search_pk'])){
    $PK_Asign = (int)$_POST['PK_Asign'];

    // Buscar asignatura
    $sql = "SELECT * FROM GPP_ASIGNATURA WHERE PK_Asign = '{$PK_Asign}' LIMIT 1";
    $result = $db->query($sql);

    if($db->num_rows($result) == 0){
        $session->msg("d", "No existe una asignatura con ID {$PK_Asign}");
        redirect('delete_asignatura.php', false);
    }

    $found_asig = $db->fetch_assoc($result);
}

/* ==========================================================
   PASO 2 → CONFIRMAR Y ELIMINAR
   ========================================================== */
if(isset($_POST['delete_asig'])){
    $PK_Asign = (int)$_POST['PK_Asign'];

    // Verificar que exista
    $check = $db->query("SELECT * FROM GPP_ASIGNATURA WHERE PK_Asign='{$PK_Asign}' LIMIT 1");
    if($db->num_rows($check) == 0){
        $session->msg("d", "La asignatura ya no existe.");
        redirect('delete_asignatura.php', false);
    }

    // Verificar si está asignada a algún grupo
    $grupo_check = $db->query("SELECT COUNT(*) AS total FROM GPP_GRUPO WHERE FK_Asign='{$PK_Asign}'");
    $grupo_count = $db->fetch_assoc($grupo_check);

    if($grupo_count['total'] > 0){
        $session->msg("d", "No se puede eliminar: está asignada a {$grupo_count['total']} grupo(s).");
        redirect('delete_asignatura.php', false);
    }

    // Eliminar asignatura
    $delete_sql = "DELETE FROM GPP_ASIGNATURA WHERE PK_Asign='{$PK_Asign}'";
    $delete = $db->query($delete_sql);

    if($delete && $db->affected_rows() > 0){
        $session->msg("s", "Asignatura eliminada correctamente.");
        redirect('delete_asignatura.php', false);
    } else {
        $session->msg("d", "Error al eliminar la asignatura.");
        redirect('delete_asignatura.php', false);
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

    <!-- =======================================
         FORMULARIO PASO 1: BUSCAR POR ID
         ======================================= -->
    <?php if(empty($found_asig)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-search"></span>
                    Buscar ASIGNATURA por ID
                </strong>
            </div>

            <div class="panel-body">
                <form method="post" action="delete_asignatura.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Asign"
                               placeholder="ID de asignatura" min="1" required>
                    </div>

                    <button type="submit" name="search_pk" class="btn btn-info">
                        Buscar
                    </button>
                </form>
            </div>
        </div>

        <a href="asignatura.php" class="btn btn-info float-btn-left">
            <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
    </div>
    <?php endif; ?>


    <!-- =======================================
         FORMULARIO PASO 2: CONFIRMAR
         SOLO APARECE SI SE ENCONTRÓ ASIGNATURA
         ======================================= -->
    <?php if(!empty($found_asig)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">

            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-trash"></span>
                    Confirmar Eliminación de ASIGNATURA ID <?php echo $found_asig['PK_Asign']; ?>
                </strong>
            </div>

            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nombre</th>
                        <td><?php echo $found_asig['Nom_Asign']; ?></td>
                    </tr>
                    <tr>
                        <th>Horas Teoría</th>
                        <td><?php echo $found_asig['HorasTeo']; ?></td>
                    </tr>
                    <tr>
                        <th>Horas Práctica</th>
                        <td><?php echo $found_asig['HorasPrac']; ?></td>
                    </tr>
                    <tr>
                        <th>Créditos</th>
                        <td><?php echo $found_asig['Creditos']; ?></td>
                    </tr>
                    <tr>
                        <th>Semestre</th>
                        <td><?php echo $found_asig['Semestre']; ?></td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td><?php echo $found_asig['Tipo_Asign']; ?></td>
                    </tr>
                </table>

                <form method="post" action="delete_asignatura.php"
                      onsubmit="return confirm('¿ESTÁ SEGURO? Esta acción no se puede deshacer.');">

                    <input type="hidden" name="PK_Asign" value="<?php echo $found_asig['PK_Asign']; ?>">

                    <button type="submit" name="delete_asig" class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash"></span>
                        Eliminar DEFINITIVAMENTE
                    </button>
                </form>

                <br>
                <a href="delete_asignatura.php" class="btn btn-default">Cancelar</a>
                <a href="asignatura.php" class="btn btn-info">Atrás</a>

            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php include_once('layouts/footer.php'); ?>
