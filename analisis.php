<!DOCTYPE html>
<html>
<head>
    <title>Análisis y Métricas Clave del Consumo de Energia,Luz y Agua</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px; 
            margin: 0; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center;
            min-height: 100vh; 
            background-image: url('./imagenes/tabla.jpg'); 
            background-size: cover; 
        }
        h1 {
            color: white; 
        }

        form {
            border: 1px solid #ddd; 
            border-radius: 10px; 
            padding: 20px; 
            background-color: rgba(255, 255, 255, 0.8); 
            margin-bottom: 20px; 
            width: 80%; 
            max-width: 400px; 
        }

        form label {
            display: block; 
            margin-bottom: 10px; 
        }

        form select {
            width: 100%; 
            padding: 8px; 
            border-radius: 5px; 
            border: 1px solid #ccc;
            background-color: #fff; 
        }

        form input[type="submit"] {
            width: 100%; 
            padding: 10px; 
            border: none; 
            border-radius: 5px; 
            background-color: #007bff;
            color: #fff; 
            cursor: pointer; 
            transition: background-color 0.3s; 
        }

        form input[type="submit"]:hover {
            background-color: #0056b3; 
        }
        table {
            border-collapse: collapse; 
            width: 80%; 
            max-width: 800px; 
            background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 10px; 
            overflow: hidden; 
        }

        th, td {
            padding: 8px; 
            border: 1px solid #ddd; 
            text-align: left; 
        }

        th {
            background-color: #f2f2f2; 
        }
    </style>
</head>
<body>
    <h1>Análisis y Métricas Clave del Consumo de Energía,Agua y Luz</h1>

    <form method="post" action="">
        <label for="area">Seleccione un área:</label>
        <select name="area" id="area">
            <option value="Apartamento 1" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 1') echo 'selected="selected"'; ?>>Apartamento 1</option>
            <option value="Apartamento 2" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 2') echo 'selected="selected"'; ?>>Apartamento 2</option>
            <option value="Apartamento 3" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 3') echo 'selected="selected"'; ?>>Apartamento 3</option>
            <option value="Apartamento 4" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 4') echo 'selected="selected"'; ?>>Apartamento 4</option>
            <option value="Apartamento 5" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 5') echo 'selected="selected"'; ?>>Apartamento 5</option>
            <option value="Oficina 1" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 1') echo 'selected="selected"'; ?>>Oficina 1</option>
            <option value="Oficina 2" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 2') echo 'selected="selected"'; ?>>Oficina 2</option>
            <option value="Oficina 3" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 3') echo 'selected="selected"'; ?>>Oficina 3</option>
            <option value="Oficina 4" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 4') echo 'selected="selected"'; ?>>Oficina 4</option>
            <option value="Oficina 5" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 5') echo 'selected="selected"'; ?>>Oficina 5</option>
        </select>
        <input type="submit" class="boton" value="Mostrar Consumo">
    </form>

    <?php
    function calcularTendenciaCentral($array) {
        $counter = array_count_values($array);
        arsort($counter);
        $most_common = key($counter);
        return $most_common;
    }
    function calcularPromedioConFormato($array) {
        $promedio = array_sum($array) / count($array);
        return number_format($promedio, 2); 
    }

    function calcularDesviacionEstandarConFormato($array) {
        $media = array_sum($array) / count($array);
        $sumatoria = 0;
        foreach ($array as $valor) {
            $sumatoria += pow($valor - $media, 2);
        }
        $varianza = $sumatoria / count($array);
        $desviacion = sqrt($varianza);
        return number_format($desviacion, 2); 
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['area'])) {
            $area = $_POST['area'];
            $archivo = fopen("./csv/datos24v3.csv", "r");
            $electricidad = [];
            $agua = [];
            $gas = [];
            while (($datos = fgetcsv($archivo, 1000, ",")) !== FALSE) {
                if ($datos[0] == $area) {
                    $electricidad[] = intval($datos[1]);
                    $agua[] = intval($datos[2]);
                    $gas[] = intval($datos[3]);
                }
            }
            fclose($archivo);
            echo "<h2 style='color: white;'>Análisis del Consumo para " . $_POST['area'] . "</h2>";
            echo '<table>';
            echo '<tr><th>Métrica</th><th>Electricidad </th><th>Agua (lt)</th><th>Gas</th></tr>';
            echo '<tr><td>Tendencia Central</td><td>' . calcularTendenciaCentral($electricidad) . '</td><td>' . calcularTendenciaCentral($agua) . '</td><td>' . calcularTendenciaCentral($gas) . '</td></tr>';
            echo '<tr><td>Promedio</td><td>' . calcularPromedioConFormato($electricidad) . '</td><td>' . calcularPromedioConFormato($agua) . '</td><td>' . calcularPromedioConFormato($gas) . '</td></tr>';
            echo '<tr><td>Desviación Estándar</td><td>' . calcularDesviacionEstandarConFormato($electricidad) . '</td><td>' . calcularDesviacionEstandarConFormato($agua) . '</td><td>' . calcularDesviacionEstandarConFormato($gas) . '</td></tr>';
            echo '</table>';
        } else {
            echo "<p>No se ha seleccionado ningún área.</p>";
        }
    }

    
    ?>

</body>
</html>
