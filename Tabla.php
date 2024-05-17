<?php
$area_seleccionada = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["area"])) {
        $area_seleccionada = $_POST["area"];
    }
    
    $datos = array_map('str_getcsv', file('./csv/datos24v3.csv'));
    
    $datos_area = array_filter($datos, function($fila) use ($area_seleccionada) {
        return $fila[0] === $area_seleccionada;
    });
}

?>

<!DOCTYPE html>
<html lang="es">
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TABLA DE GASTOS</title>
</head>
<body>

<h1>TABLA DE GASTOS</h1>

<form method="post">
    <label for="area">Seleccione un área:</label>
    <select name="area" id="area">
        <option value="Apartamento 1" <?php if ($area_seleccionada === "Apartamento 1") echo "selected"; ?>>Apartamento 1</option>
        <option value="Apartamento 2" <?php if ($area_seleccionada === "Apartamento 2") echo "selected"; ?>>Apartamento 2</option>
        <option value="Apartamento 3" <?php if ($area_seleccionada === "Apartamento 3") echo "selected"; ?>>Apartamento 3</option>
        <option value="Apartamento 4" <?php if ($area_seleccionada === "Apartamento 4") echo "selected"; ?>>Apartamento 4</option>
        <option value="Apartamento 5" <?php if ($area_seleccionada === "Apartamento 5") echo "selected"; ?>>Apartamento 5</option>
        <option value="Oficina 1" <?php if ($area_seleccionada === "Oficina 1") echo "selected"; ?>>Oficina 1</option>
        <option value="Oficina 2" <?php if ($area_seleccionada === "Oficina 2") echo "selected"; ?>>Oficina 2</option>
        <option value="Oficina 3" <?php if ($area_seleccionada === "Oficina 3") echo "selected"; ?>>Oficina 3</option>
        <option value="Oficina 4" <?php if ($area_seleccionada === "Oficina 4") echo "selected"; ?>>Oficina 4</option>
        <option value="Oficina 5" <?php if ($area_seleccionada === "Oficina 5") echo "selected"; ?>>Oficina 5</option>
    </select>
    <input type="submit" name="submit" value="Mostrar Consumo">
</form>

<?php
if (!empty($area_seleccionada)) {
    $csv_file = './csv/datos24v3.csv';

    if (file_exists($csv_file)) {
        if (($handle = fopen($csv_file, 'r')) !== false) {
            echo '<table>';
            echo '<tr><th>Área</th><th>Electricidad (kWh)</th><th>Agua (litros)</th><th>Gas (m3)</th><th>Fecha</th></tr>';
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row[0] === $area_seleccionada) {
                    echo '<tr>';
                    echo '<td>' . $row[0] . '</td>'; 
                    echo '<td>' . $row[1] . '</td>'; 
                    echo '<td>' . $row[2] . '</td>'; 
                    echo '<td>' . $row[3] . '</td>'; 
                    echo '<td>' . $row[4] . '</td>'; 
                    echo '</tr>';
                }
            }

            
            fclose($handle);

            echo '</table>';
        } else {
            echo 'Error al abrir el archivo CSV.';
        }
    } else {
        echo 'El archivo CSV no existe.';
    }
}
?>

</body>
</html>