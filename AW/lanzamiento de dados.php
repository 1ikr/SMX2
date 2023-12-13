<?php
$numLanzamientos = 0;
$resultados = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0);
$porcentajes = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numLanzamientos = isset($_POST["numLanzamientos"]) ? intval($_POST["numLanzamientos"]) : 0;

    if ($numLanzamientos > 0) {
        for ($i = 0; $i < $numLanzamientos; $i++) {
            $resultado = rand(1, 6);
            $resultados[$resultado]++;
        }

        foreach ($resultados as $numero => $frecuencia) {
            $porcentaje = ($frecuencia / $numLanzamientos) * 100;
            $porcentajes[$numero] = $porcentaje;
        }
    } else {
        echo "Por favor, ingresa un número válido de lanzamientos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanzamiento de Dado</title>
</head>
<body>

<h2>Simulador de Lanzamiento de Dado</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="numLanzamientos">Número de lanzamientos (1-1000): </label>
    <input type="number" name="numLanzamientos" id="numLanzamientos" min="1" max="1000" required>
    <input type="submit" value="Simular">
</form>

<?php
if ($numLanzamientos > 0) {
    echo "<h3>Resultados después de $numLanzamientos lanzamientos:</h3>";
    foreach ($porcentajes as $numero => $porcentaje) {
        echo "Número $numero: $porcentaje%<br>";
    }
}
?>

</body>
</html>
