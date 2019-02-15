<!DOCTYPE html>
<html>
	<head>
		<title>Visualización</title>
	</head>
	<body>
		<?php
		
		# Reanudación de sesión:
		session_start();
		
		# Llamada a los archivos con variables y funciones:
		include 'variables.php';
		include 'funciones.php';
		
		# Función de conexión:
		$con=conect($location,$user,$password,$db);
		
		if (!$con){
		echo "No se ha podido conectar a la base de datos. Inténtelo de nuevo.";
		exit;
		}
		
		# Definición de variables con el valor de variables de sesión:
		$firstday=$_SESSION['firstday'];
		$lastday=$_SESSION['lastday'];
		$device=$_SESSION['device'];
		$medicion=$_SESSION['medicion'];
		$firstyear=$_SESSION['firstyear'];
		$lastyear=$_SESSION['lastyear'];
		$firstmonth=$_SESSION['firstmonth'];
		$lastmonth=$_SESSION['lastmonth'];
		$representacion=$_POST["representacion"];
		
		# Función de consulta de datos a DB:
		$datos=data($device,$medicion,$firstyear,$lastyear,$firstmonth,$lastmonth,$firstday,$lastday,$con);
		
		if (!$datos){	
			echo "No ha sido posible consultar los datos.";
			exit;
		}
		
			if (isset($representacion)){
				echo "<a href='index.html'>Cerrar Sesión</a></br>";
				echo "<a href='visualizacion.php'>Volver</a></br>";
				if ($representacion == "grafica"){
					$i=0;
					$count=0;
					while ($fila=mysqli_fetch_assoc($datos)){
						$valoresArray[$i]=$fila["value_data"];
						#OBTENEMOS EL TIMESTAMP
						$time=$fila["value_date"];
						$date = new DateTime($time);
						#ALMACENAMOS EL TIMESTAMP EN EL ARRAY
						$timeArray[$i] = $date->getTimestamp()*1000;
						$i++;
						$count++;
					};
					?>
					<script src='https://code.jquery.com/jquery.js'></script>
						<!-- Importo el archivo Javascript de Highcharts directamente desde su servidor -->
					<script src='http://code.highcharts.com/stock/highstock.js'></script>
					<script src='http://code.highcharts.com/modules/exporting.js'></script>
					
					<div id='contenedor'></div>
					<script>
					chartCPU = new Highcharts.StockChart({
						chart: {
							renderTo: 'contenedor'
							//defaultSeriesType: 'spline'
						},
						rangeSelector : {
							enabled: false
						},
						title: {
							text: 'Gráfica'
						},
						xAxis: {
							type: 'datetime'
							//tickPixelInterval: 150,
							//maxZoom: 20 * 1000
						},
						yAxis: {
							minPadding: 0.2,
							maxPadding: 0.2,
							title: {
								text: 'Valores',
								margin: 10
							}
						},
						series: [{
							name: 'valor',
							data: (function() {
								var data = [];
									<?php
									for($i = 0 ;$i<$count;$i++){
									?>
										data.push([<?php echo $timeArray[$i];?>,<?php echo $valoresArray[$i];?>]);
									<?php } ?>
								return data;
							})()
						}],
						credits: {
							enabled: false
						}
					});
					</script>
		<?php
				}
				if ($representacion == "tabla"){
					echo "<table border=1>";
					echo "<tr>";
					echo "<th>".$medicion."</th>";
					echo "<th>Fecha</th>";
					echo "</tr>";
					while ($fila=mysqli_fetch_assoc($datos)){
						echo "<tr>";
						echo "<td>".$fila["value_data"]."</td>";
						echo "<td>".$fila["value_date"]."</td>";
						echo "</tr>";
					};
					echo "</table>";
				}
			}
		mysqli_close($con);
		?>
	</body>
</html>