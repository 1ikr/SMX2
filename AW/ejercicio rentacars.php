<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio Rentacar</title>
</head>

<body>

    <header>
        <h1>Explorador de Alquiler de VehÃ­culos</h1>
    </header>

    <main>

        <?php
        $url = "https://catalegdades.caib.cat/resource/rjfm-vxun.xml";
        if (!$xml = file_get_contents($url)) {
            echo "No se pudo cargar la URL";
        } else {
            $xml = simplexml_load_string($xml);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $filtered_data = array_filter($xml->xpath('//row'), function ($row) {
                $municipio_filtro = isset($_POST['municipio']) ? $_POST['municipio'] : '';
                $codigo_postal_filtro = isset($_POST['codigo_postal']) ? $_POST['codigo_postal'] : '';
                $nombre_filtro = isset($_POST['nombre']) ? $_POST['nombre'] : '';

                $matches_municipio = !$municipio_filtro || strtolower($row->municipi) == strtolower($municipio_filtro);
                $matches_codigo_postal = !$codigo_postal_filtro || strpos(strtolower($row->adre_a_de_l_establiment), strtolower($codigo_postal_filtro)) !== false;
                $matches_nombre = !$nombre_filtro || stripos(strtolower($row->nom_explotador_s), strtolower($nombre_filtro)) !== false;

                return $matches_municipio && $matches_codigo_postal && $matches_nombre;
            });
        } else {
            $filtered_data = $xml->xpath('//row');
        }

        $municipios = array_unique($xml->xpath('//row/municipi'));
        sort($municipios);

        $codigos_postales = array();
        foreach ($xml->xpath('//row/adre_a_de_l_establiment') as $codigo_postal) {
            preg_match('/(\d{5})/', $codigo_postal, $matches);
            $codigo_postal_value = isset($matches[1]) ? $matches[1] : '';
            $codigos_postales[$codigo_postal_value] = true;
        }
        ksort($codigos_postales);
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>Municipio:</label>
            <div>
                <?php
                foreach ($municipios as $municipio) {
                    echo "<input type='radio' name='municipio' value='$municipio'> $municipio";
                }
                ?>
            </div>

            <label for="codigo_postal">CÃ³digo Postal:</label>
            <select name="codigo_postal">
                <option value="">Todos</option>
                <?php
                foreach ($codigos_postales as $codigo_postal => $_) {
                    echo "<option value='$codigo_postal'>$codigo_postal</option>";
                }
                ?>
            </select>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre">

            <input type="submit" value="Buscar">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Licencia de rentacar</th>
                    <th>Nombre comercial</th>
                    <th>DirecciÃ³n completa</th>
                    <th>CÃ³digo Postal</th>
                    <th>Municipio</th>
                    <th>NÃºmero de vehÃ­culos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($filtered_data as $row) {
                    preg_match('/(\d{5})/', $row->adre_a_de_l_establiment, $matches);
                    $codigo_postal = isset($matches[1]) ? $matches[1] : '';

                    echo "<tr>";
                    echo "<td>" . $row->signatura . "</td>";
                    echo "<td>" . $row->denominaci_comercial . "</td>";
                    echo "<td>" . $row->adre_a_de_l_establiment . "</td>";
                    echo "<td>" . $codigo_postal . "</td>";
                    echo "<td>" . $row->municipi . "</td>";
                    echo "<td>" . $row->nombre_de_vehicles . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </main>

</body>

</html>
