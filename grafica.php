<!DOCTYPE html>
<html>
<head>
    <title>Visualización de Consumo de Energía</title>
    <link rel="stylesheet" href="./css/chartist.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        #seleccionar-area {
            background-color: #007bff; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        #seleccionar-area:hover {
            background-color: #0056b3;
        }

       
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

       
        form {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Visualización y Análisis de Consumo de Energía, Agua y Luz</h1>

        <form method="post">
        <label for="area">Seleccione un área:</label>
        <select name="area" id="area">
        <option value="Apartamento 1" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 1') echo 'selected'; ?>>Apartamento 1</option>
            <option value="Apartamento 2" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 2') echo 'selected'; ?>>Apartamento 2</option>
            <option value="Apartamento 3" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 3') echo 'selected'; ?>>Apartamento 3</option>
            <option value="Apartamento 4" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 4') echo 'selected'; ?>>Apartamento 4</option>
            <option value="Apartamento 5" <?php if(isset($_POST['area']) && $_POST['area'] == 'Apartamento 5') echo 'selected'; ?>>Apartamento 5</option>
            <option value="Oficina 1" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 1') echo 'selected'; ?>>Oficina 1</option>
            <option value="Oficina 2" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 2') echo 'selected'; ?>>Oficina 2</option>
            <option value="Oficina 3" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 3') echo 'selected'; ?>>Oficina 3</option>
            <option value="Oficina 4" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 4') echo 'selected'; ?>>Oficina 4</option>
            <option value="Oficina 5" <?php if(isset($_POST['area']) && $_POST['area'] == 'Oficina 5') echo 'selected'; ?>>Oficina 5</option>
        </select>
        <input type="submit" class="boton" value="Mostrar Consumo">
    </form>
   
        
    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['area'])) {
        
            $area_seleccionada = $_POST["area"];

          
            $datos = array_map('str_getcsv', file('./csv/datos24v3.csv'));
            
            $datos_area = array_filter($datos, function($fila) use ($area_seleccionada) {
                return $fila[0] === $area_seleccionada;
            });

            $fechas = array_column($datos_area, 4);
            $electricidad = array_column($datos_area, 1);
            $agua = array_column($datos_area, 2);
            $gas = array_column($datos_area, 3);

            $fechas = array_slice($fechas, -10); 
            $electricidad = array_slice($electricidad, -10);
            $agua = array_slice($agua, -10);
            $gas = array_slice($gas, -10);
            echo '<canvas id="myChart" width="800" height="400"></canvas>';
            echo '<script>
                var ctx = document.getElementById("myChart").getContext("2d");
                var myChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ' . json_encode($fechas) . ',
                        datasets: [{
                            label: "Electricidad (kWh)",
                            data: ' . json_encode($electricidad) . ',
                            borderColor: "rgba(255, 99, 132, 1)",
                            borderWidth: 2,
                            fill: false
                        }, {
                            label: "Agua (litros)",
                            data: ' . json_encode($agua) . ',
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 2,
                            fill: false
                        }, {
                            label: "Gas (m^3)",
                            data: ' . json_encode($gas) . ',
                            borderColor: "rgba(255, 206, 86, 1)",
                            borderWidth: 2,
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                </script>';
        } else {
            echo "<p>No se ha seleccionado ningún área.</p>";
        }
    }
    
    ?>
</body>
</html>