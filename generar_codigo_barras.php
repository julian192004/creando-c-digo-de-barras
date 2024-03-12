<?php

require_once __DIR__ . '/vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorHTML;

// Crear instancia del generador de códigos de barras
$generator = new BarcodeGeneratorHTML();

// Consultar datos de la tabla lote (suponiendo que estés utilizando algún framework o PDO para interactuar con la base de datos)
// Aquí deberías tener el código para obtener los datos del lote

// Ejemplo de datos de prueba
$id_lote = 1;
$barrio = "Barrio Ejemplo";
$frente = 10;
$ancho = 15;
$dueño = "Dueño Ejemplo";

// Concatenar los datos para generar el código de barras
$datos_para_codigo_barras = $id_lote . '|' . $barrio . '|' . $frente . '|' . $ancho . '|' . $dueño;

// Generar el código de barras
$codigo_barras_html = $generator->getBarcode($datos_para_codigo_barras, $generator::TYPE_CODE_128, 2, 60);

// Mostrar el código de barras
echo $codigo_barras_html;
