<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = 'C:/xampp/htdocs/menus/uploads/products/';

    echo "Probando ruta: " . realpath($targetDir) . "<br>";
    echo "is_dir: " . (is_dir($targetDir) ? "Sí existe" : "No existe") . "<br>";
    echo "is_writable: " . (is_writable($targetDir) ? "Tiene permisos" : "No tiene permisos") . "<br>";

    if (!is_dir($targetDir)) {
        echo "La carpeta no existe.";
        exit;
    }
    if (!is_writable($targetDir)) {
        echo "La carpeta no tiene permisos de escritura.";
        exit;
    }

    $targetFile = $targetDir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo "Archivo subido correctamente: " . htmlspecialchars(basename($_FILES['file']['name']));
    } else {
        echo "Error al subir el archivo.";
    }
} else {
?>
<form method="POST" enctype="multipart/form-data">
    Selecciona un archivo para subir:
    <input type="file" name="file" required>
    <input type="submit" value="Subir Archivo">
</form>
<?php
}
?>

