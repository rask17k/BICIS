<?php
require_once 'BiciElectrica.php';

function cargabicis() {
    $tabla = [];
    $fichero = fopen("Bicis.csv", "r");
    while (($datos = fgetcsv($fichero)) !== FALSE) {
        $bici = new BiciElectrica($datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
        if ($bici->operativa) {
            $tabla[] = $bici;
        }
    }
    fclose($fichero);
    return $tabla;
}

function mostrartablabicis($tabla) {
    $html = "<table><tr><th>ID</th><th>Coordenada X</th><th>Coordenada Y</th><th>Batería</th></tr>";
    foreach ($tabla as $bici) {
        $html .= "<tr><td>{$bici->id}</td><td>{$bici->coordx}</td><td>{$bici->coordy}</td><td>{$bici->bateria}%</td></tr>";
    }
    $html .= "</table>";
    return $html;
}

function bicimascercana($x, $y, $tabla) {
    $distancia_minima = PHP_FLOAT_MAX;
    $bici_cercana = null;
    foreach ($tabla as $bici) {
        $distancia = $bici->distancia($x, $y);
        if ($distancia < $distancia_minima) {
            $distancia_minima = $distancia;
            $bici_cercana = $bici;
        }
    }
    return $bici_cercana;
}

// Programa principal
$tabla = cargabicis();
if (!empty($_GET['coordx']) && !empty($_GET['coordy'])) {
    $biciRecomendada = bicimascercana($_GET['coordx'], $_GET['coordy'], $tabla);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MOSTRAR BICIS OPERATIVAS</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Listado de bicicletas operativas</h1>
    <?= mostrartablabicis($tabla); ?>
    <?php if (isset($biciRecomendada)) : ?>
        <h2>Bicicleta disponible más cercana es <?= $biciRecomendada ?></h2>
        <button onclick="history.back()">Volver</button>
    <?php else : ?>
        <h2>Indicar su ubicación:</h2>
        <form>
            Coordenada X: <input type="number" name="coordx"><br>
            Coordenada Y: <input type="number" name="coordy"><br>
            <input type="submit" value="Consultar">
        </form>
    <?php endif ?>
</body>
</html>