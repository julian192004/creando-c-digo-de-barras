<?php
require_once("conexion/conexion.php");

$conexion = new Conexion();
$conectar = $conexion->conectar();

use Picqer\Barcode\BarcodeGeneratorPNG;

// Verifica si se ha enviado el formulario y se establece el registro
if ((isset($_POST["registro"])) && ($_POST["registro"] == "formu")) {

    // Obtiene los datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $id_lote = isset($_POST['id']) ? $_POST['id'] : '';
    $barrio = isset($_POST['barrio']) ? $_POST['barrio'] : '';
    $frente = isset($_POST['frente']) ? $_POST['frente'] : '';
    $ancho = isset($_POST['ancho']) ? $_POST['ancho'] : '';
    $dueño = isset($_POST['dueño']) ? $_POST['dueño'] : '';

    // Genera un código de barras único
    $codigo_barras = uniqid() . rand(1000, 9999);

    // Asegúrate de tener la ruta correcta hacia el autoloader de Composer
    require 'vendor/autoload.php';

    // Genera el código de barras en formato PNG
    $generator = new BarcodeGeneratorPNG();
    $codigo_barras_imagen = $generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128);

    // Guarda el código de barras en un archivo
    file_put_contents(__DIR__ . '/images/' . $codigo_barras . '.png', $codigo_barras_imagen);

    // Inserta los datos en la base de datos
    $insertsql = $conectar->prepare("INSERT INTO lote(id_lote, barrio, frente, ancho, dueño, cod_barras) VALUES (?, ?, ?, ?, ?, ?)");
    $insertsql->execute([$id_lote, $barrio, $frente, $ancho, $dueño, $codigo_barras]);

    // Recupera los datos de la base de datos para mostrarlos en la tabla
    $usua = $conectar->prepare("SELECT * FROM lote");
    $usua->execute();
    $asigna = $usua->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herramientas</title>
    <!-- Agrega los estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Crear lotes</h2>
        <br>
        <!-- Formulario para ingresar datos de los lotes -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id">ID del lote:</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="barrio">Nombre del barrio:</label>
                <input type="text" class="form-control" id="barrio" name="barrio" required>
            </div>
            <div class="form-group">
                <label for="frente">Frente del lote:</label>
                <input type="text" class="form-control" id="frente" name="frente" required>
            </div>
            <div class="form-group">
                <label for="ancho">Ancho del lote:</label>
                <input type="text" class="form-control" id="ancho" name="ancho" required>
            </div>
            <div class="form-group">
                <label for="dueño">Nombre del dueño del lote:</label>
                <input type="text" class="form-control" id="dueño" name="dueño" required>
            </div>
            <br>
            <!-- Botón para enviar el formulario -->
            <input type="submit" class="btn btn-success" value="Registrar">
            <!-- Campo oculto para indicar que se está enviando el formulario -->
            <input type="hidden" name="registro" value="formu">
        </form>
    </div>

    <div class="container mt-3">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr style="text-transform: uppercase;">
                    <th>Nombre</th>
                    <th>Código de barras</th>
                </tr>
            </thead>
            <tbody>
                <!-- Verifica si hay datos para mostrar -->
                <?php if (isset($asigna) && !empty($asigna)): ?>
                    <?php foreach ($asigna as $usua): ?>
                        <tr>
                        <td><?= $usua["dueño"] ?></td>
                            <td><img src="images/<?= $usua["cod_barras"] ?>.png" style="max-width: 400px;"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Muestra un mensaje si no hay datos -->
                    <tr>
                        <td colspan="2">No hay registros disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Agrega los scripts de Bootstrap al final del cuerpo del documento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
