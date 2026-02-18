<?php
$page_title = 'Vista de DEPARTAMENTOS';
require_once('includes/load.php');
page_require_level(1);

// Traer todos los departamentos
$all_departamentos = find_all('GPP_DEPARTAMENTO');
?>
<?php include_once('layouts/headerDEP.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-eye-open"></span>
          Vista de DEPARTAMENTOS
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
              <!-- Si agregas campos dinámicos, también se muestran aquí -->
              <?php
              // Obtener todos los campos excepto PK y mostrar los extra
              $columns = $db->query("SHOW COLUMNS FROM GPP_DEPARTAMENTO");
              foreach($columns as $col){
                  if(!in_array($col['Field'], ['PK_Dpto','Nom_Dpto','FechCre_Dpto','Tel_Dpto','Email_Dpto','Coord_Dpto'])){
                      echo '<th class="text-center">'.$col['Field'].'</th>';
                  }
              }
              ?>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($all_departamentos as $dep): ?>
              <tr>
                <td><?php echo remove_junk(ucfirst($dep['Nom_Dpto'])); ?></td>
                <td><?php echo remove_junk(ucfirst($dep['Tel_Dpto'])); ?></td>
                <td><?php echo remove_junk(ucfirst($dep['Email_Dpto'])); ?></td>
                <td><?php echo remove_junk(ucfirst($dep['Coord_Dpto'])); ?></td>
                <?php
                // Mostrar valores de campos dinámicos
                foreach($columns as $col){
                    if(!in_array($col['Field'], ['PK_Dpto','Nom_Dpto','FechCre_Dpto','Tel_Dpto','Email_Dpto','Coord_Dpto'])){
                        $val = isset($dep[$col['Field']]) ? remove_junk($dep[$col['Field']]) : '';
                        echo '<td>'.$val.'</td>';
                    }
                }
                ?>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>
    </div>
  </div>



     <a href="departamento.php" class="btn btn-info float-btn-left">
         <i class="glyphicon glyphicon-th-large"></i> ATRAS
     </a>

</div>

<?php include_once('layouts/footer.php'); ?>
