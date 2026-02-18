<?php
$page_title = 'Eliminar ÁREA DE CONOCIMIENTO';
require_once('includes/load.php');
page_require_level(1);

// Variable donde se almacenará el área encontrada
$found_area = [];

/* ==========================================================
   PASO 1 → BUSCAR ÁREA POR ID
   ========================================================== */
if(isset($_POST['search_pk'])){
    $PK_Area = (int)$_POST['PK_Area'];

    // Buscar área
    $sql = "SELECT * FROM GPP_AREA_CONOCIMIENTO WHERE PK_Area = '{$PK_Area}' LIMIT 1";
    $result = $db->query($sql);

    if($db->num_rows($result) == 0){
        $session->msg("d", "No existe un área con ID {$PK_Area}");
        redirect('delete_areaC.php', false);
    }

    $found_area = $db->fetch_assoc($result);
}

/* ==========================================================
   PASO 2 → CONFIRMAR Y ELIMINAR
   ========================================================== */
if(isset($_POST['delete_area'])){
    $PK_Area = (int)$_POST['PK_Area'];

    // Verificar existencia
    $check = $db->query("SELECT * FROM GPP_AREA_CONOCIMIENTO WHERE PK_Area='{$PK_Area}' LIMIT 1");
    if($db->num_rows($check) == 0){
        $session->msg("d", "El área ya no existe.");
        redirect('delete_areaC.php', false);
    }

    // Verificar profesores asociados
    $profesores = $db->query("SELECT COUNT(*) AS total FROM GPP_PROFESOR WHERE FK_AreaProf='{$PK_Area}'");
    $prof_count = $db->fetch_assoc($profesores);
    if($prof_count['total'] > 0){
        $session->msg("d", "No se puede eliminar: tiene {$prof_count['total']} profesor(es) asociado(s).");
        redirect('delete_areaC.php', false);
    }

    // Verificar asignaturas asociadas
    $asignaturas = $db->query("SELECT COUNT(*) AS total FROM GPP_ASIGNATURA WHERE FK_AreaAsign='{$PK_Area}'");
    $asig_count = $db->fetch_assoc($asignaturas);
    if($asig_count['total'] > 0){
        $session->msg("d", "No se puede eliminar: tiene {$asig_count['total']} asignatura(s) asociada(s).");
        redirect('delete_areaC.php', false);
    }

    // Eliminar área
    $delete_sql = "DELETE FROM GPP_AREA_CONOCIMIENTO WHERE PK_Area='{$PK_Area}'";
    $delete = $db->query($delete_sql);

    if($delete && $db->affected_rows() > 0){
        $session->msg("s", "Área de conocimiento eliminada correctamente.");
        redirect('delete_areaC.php', false);
    } else {
        $session->msg("d", "Error al eliminar el área.");
        redirect('delete_areaC.php', false);
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

    <!-- =======================================
         FORMULARIO PASO 1: BUSCAR ID
         ======================================= -->
    <?php if(empty($found_area)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-search"></span>
                    Buscar ÁREA por ID
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="delete_areaC.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Area"
                               placeholder="ID del área" required min="1">
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">
                        Buscar
                    </button>
                </form>
            </div>
        </div>
        <a href="area_conocimiento.php" class="btn btn-info float-btn-left">
            <i class="glyphicon glyphicon-th-large"></i> ATRÁS
        </a>
    </div>
    <?php endif; ?>


    <!-- =======================================
         PASO 2: MOSTRAR INFO Y CONFIRMAR
         ======================================= -->
    <?php if(!empty($found_area)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">

            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-trash"></span>
                    Confirmar Eliminación del ÁREA ID <?php echo $found_area['PK_Area']; ?>
                </strong>
            </div>

            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nombre</th>
                        <td><?php echo $found_area['Nom_Area']; ?></td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td><?php echo $found_area['Descrip_Area']; ?></td>
                    </tr>
                    <tr>
                        <th>Coordinador</th>
                        <td><?php echo $found_area['Coord_Area']; ?></td>
                    </tr>
                    <tr>
                        <th>Departamento</th>
                        <td><?php echo $found_area['FK_Dpto']; ?></td>
                    </tr>
                </table>

                <form method="post" action="delete_areaC.php"
                      onsubmit="return confirm('¿ESTÁ SEGURO? Esta acción no se puede deshacer.');">

                    <input type="hidden" name="PK_Area" value="<?php echo $found_area['PK_Area']; ?>">

                    <button type="submit" name="delete_area" class="btn btn-danger">
                        <span class="glyphicon glyphicon-trash"></span>
                        Eliminar DEFINITIVAMENTE
                    </button>
                </form>

                <br>
                <a href="delete_areaC.php" class="btn btn-default">Cancelar</a>
                <a href="area_conocimiento.php" class="btn btn-info">Atrás</a>

            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php include_once('layouts/footer.php'); ?>
