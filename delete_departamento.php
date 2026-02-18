<?php 
$page_title = 'Eliminar DEPARTAMENTO';
require_once('includes/load.php');
page_require_level(1);

// Variable para guardar el departamento temporalmente
$found_dpto = [];

/* ==========================================================
   PASO 1 → BUSCAR DEPARTAMENTO POR ID
   ========================================================== */
if(isset($_POST['search_pk'])){
    $PK_Dpto = (int)$_POST['PK_Dpto'];

    $sql = "SELECT * FROM GPP_DEPARTAMENTO WHERE PK_Dpto = {$PK_Dpto} LIMIT 1";
    $result = $db->query($sql);

    if($db->num_rows($result) == 0){
        $session->msg("d", "No existe un departamento con ID {$PK_Dpto}");
        redirect('delete_departamento.php', false);
    }

    $found_dpto = $db->fetch_assoc($result);
}

/* ==========================================================
   PASO 2 → CONFIRMAR Y ELIMINAR
   ========================================================== */
if(isset($_POST['delete_dpto'])){
    $PK_Dpto = (int)$_POST['PK_Dpto'];

    // Verificar si existe
    $check = $db->query("SELECT PK_Dpto FROM GPP_DEPARTAMENTO WHERE PK_Dpto = {$PK_Dpto} LIMIT 1");
    if($db->num_rows($check) == 0){
        $session->msg("d", "El departamento ya no existe.");
        redirect('delete_departamento.php', false);
    }

    // LLAMADA AL STORED PROCEDURE USANDO LA CONEXIÓN REAL
    $mysqli = $db->get_connection(); // Método público que devuelve $con
    $sql = "CALL gpp_universidad_p.SP_Eliminar_Departamento_Total({$PK_Dpto})";


    if($mysqli->multi_query($sql)){
        // Limpiar todos los resultados del procedure
        do {
            if($result = $mysqli->store_result()){
                $result->free();
            }
        } while($mysqli->more_results() && $mysqli->next_result());

        $session->msg("s", "Departamento y todas sus relaciones fueron eliminadas correctamente.");
    } else {
        $session->msg("d", "Error al eliminar el departamento: ".$mysqli->error);
    }

    redirect('delete_departamento.php', false);
}
?>

<?php include_once('layouts/headerDEP.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">

<?php if(empty($found_dpto)): ?>
<div style="
    position: fixed;
    top: 35%;
    left: 8%;
    width: 100%;
">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Buscar DEPARTAMENTO por ID</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="delete_departamento.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Dpto" required min="1">
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">Buscar</button>
                </form>
            </div>
        </div>
            <a href="departamento.php" class="btn btn-info float-btn-left">
                <i class="glyphicon glyphicon-th-large"></i> ATRAS
            </a>
    </div>
</div>
<?php endif; ?>

<?php if(!empty($found_dpto)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Eliminar DEPARTAMENTO ID <?php echo $found_dpto['PK_Dpto']; ?></strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered">
                    <tr><th>Nombre</th><td><?php echo $found_dpto['Nom_Dpto']; ?></td></tr>
                    <tr><th>Teléfono</th><td><?php echo $found_dpto['Tel_Dpto']; ?></td></tr>
                    <tr><th>Email</th><td><?php echo $found_dpto['Email_Dpto']; ?></td></tr>
                    <tr><th>Coordinador</th><td><?php echo $found_dpto['Coord_Dpto']; ?></td></tr>
                </table>

                <form method="post" action="delete_departamento.php"
                      onsubmit="return confirm('¿ESTÁS SEGURO? ESTA ACCIÓN NO SE PUEDE DESHACER');">
                    <input type="hidden" name="PK_Dpto" value="<?php echo $found_dpto['PK_Dpto']; ?>">
                    <button type="submit" name="delete_dpto" class="btn btn-danger">
                        Eliminar DEFINITIVAMENTE
                    </button>
                </form>

                <br>
                <a href="delete_departamento.php" class="btn btn-default">Cancelar</a>
                
            <a href="departamento.php" class="btn btn-info float-btn-left">
                <i class="glyphicon glyphicon-th-large"></i> ATRAS
            </a>
            </div>
        </div>
    </div>
<?php endif; ?>

</div>

<?php include_once('layouts/footer.php'); ?>
