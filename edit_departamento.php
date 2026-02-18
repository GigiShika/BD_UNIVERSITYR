<?php
$page_title = 'Editar DEPARTAMENTO';
require_once('includes/load.php');
page_require_level(1);

// Variable para guardar el departamento que se va a editar
$edited_departamento = [];

// Paso 1: Buscar departamento por PK
if(isset($_POST['search_pk'])){
    $PK_Dpto = remove_junk($db->escape($_POST['PK_Dpto']));
    $sql_search = "SELECT * FROM GPP_DEPARTAMENTO WHERE PK_Dpto='{$PK_Dpto}' LIMIT 1";
    $result_search = $db->query($sql_search);

    if($result_search->num_rows == 0){
        $session->msg("d", "No existe departamento con ID {$PK_Dpto}");
        redirect('edit_departamento.php', false);
    } else {
        $edited_departamento = $result_search->fetch_assoc();
    }
}

// Paso 2: Guardar cambios del departamento
if(isset($_POST['edit_cat'])){
    $PK_Dpto = remove_junk($db->escape($_POST['PK_Dpto']));
    $Nom_Dpto = remove_junk($db->escape($_POST['Nom_Dpto']));
    $FechCre_Dpto = remove_junk($db->escape($_POST['FechCre_Dpto']));
    $Tel_Dpto = remove_junk($db->escape($_POST['Tel_Dpto']));
    $Email_Dpto = remove_junk($db->escape($_POST['Email_Dpto']));
    $Coord_Dpto = remove_junk($db->escape($_POST['Coord_Dpto']));

    $sql_update = "UPDATE GPP_DEPARTAMENTO SET 
                    Nom_Dpto='{$Nom_Dpto}', 
                    FechCre_Dpto='{$FechCre_Dpto}', 
                    Tel_Dpto='{$Tel_Dpto}', 
                    Email_Dpto='{$Email_Dpto}', 
                    Coord_Dpto='{$Coord_Dpto}'
                   WHERE PK_Dpto='{$PK_Dpto}'";

    if($db->query($sql_update)){
        $session->msg("s", "Departamento actualizado correctamente.");
        $edited_departamento = $db->query("SELECT * FROM GPP_DEPARTAMENTO WHERE PK_Dpto='{$PK_Dpto}' LIMIT 1")->fetch_assoc();
    } else {
        $session->msg("d", "Error al actualizar el departamento.");
        redirect('edit_departamento.php', false);
    }
}
?>

<?php include_once('layouts/headerDEP.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <!-- FORMULARIO PASO 1: INGRESAR PK -->
    <?php if(empty($edited_departamento)): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-search"></span>
                    Buscar DEPARTAMENTO por ID
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_departamento.php">
                    <div class="form-group">
                        <input type="number" class="form-control" name="PK_Dpto" placeholder="ID del departamento" required>
                    </div>
                    <button type="submit" name="search_pk" class="btn btn-info">Buscar</button>
                </form>
            </div>
      <a href="departamento.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
      </a>

        </div>
    </div>
    <?php endif; ?>

    <!-- FORMULARIO PASO 2: EDITAR CAMPOS -->
    <?php if(!empty($edited_departamento)): ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-edit"></span>
                    Editar DEPARTAMENTO ID <?php echo $edited_departamento['PK_Dpto']; ?>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_departamento.php">
                    <input type="hidden" name="PK_Dpto" value="<?php echo $edited_departamento['PK_Dpto']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="Nom_Dpto" value="<?php echo remove_junk($edited_departamento['Nom_Dpto']); ?>" required>
                        <input type="text" class="form-control" name="Tel_Dpto" value="<?php echo remove_junk($edited_departamento['Tel_Dpto']); ?>" required>
                        <input type="text" class="form-control" name="Email_Dpto" value="<?php echo remove_junk($edited_departamento['Email_Dpto']); ?>" required>
                        <input type="text" class="form-control" name="Coord_Dpto" value="<?php echo remove_junk($edited_departamento['Coord_Dpto']); ?>" required>
                    </div>
                    <button type="submit" name="edit_cat" class="btn btn-primary">Actualizar DEPARTAMENTO</button>
                </form>
            </div>
        <a href="departamento.php" class="btn btn-info float-btn-left">
          <i class="glyphicon glyphicon-th-large"></i> ATRAS
        </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- TABLA DEL DEPARTAMENTO EDITADO -->
<?php if(!empty($edited_departamento)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th-list"></span>
                    Departamento Editado
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>

                            <th class="text-center">Nombre</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Coordinador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucfirst($edited_departamento['Nom_Dpto'])); ?></td>
                            <td><?php echo remove_junk(ucfirst($edited_departamento['Tel_Dpto'])); ?></td>
                            <td><?php echo remove_junk(ucfirst($edited_departamento['Email_Dpto'])); ?></td>
                            <td><?php echo remove_junk(ucfirst($edited_departamento['Coord_Dpto'])); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
        </div>

    </div>

<?php endif; ?>

<?php include_once('layouts/footer.php'); ?>
