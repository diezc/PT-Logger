<!DOCTYPE html>
<html>
	<head>
		<title>Medidas</title>
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
		
		if (isset($_POST["device"])){
			$device=$_POST["device"];
		} else{
			$device=$_SESSION['device'];
		}
		
		# Definición de variable de sesión:
		$_SESSION['device'] = $device;
		
		if (isset($device)){
		
			# Función de consulta de tipos de medida a DB:
			$medidas=measure($device,$con);
					
			if (!$medidas){	
				echo "No ha sido posible consultar los tipos de mediciones.";
				exit;
			}
			
			# Formulario de selección de tipo de medida:
			echo "<form method='post' action='year.php'>";
			echo "Elige la medida a consultar:</br>";
			echo "<select name='medicion'>";
			while ($fila=mysqli_fetch_assoc($medidas)){
				echo "<option name='medicion' value=".$fila["type_name"].">".$fila["type_name"]."</option></br>";
			};
			echo "</select><br>";
			echo "<input type='submit' value='Siguiente ->'/><br>";
			echo "</form>";
			echo "<a href='devices.php'>Volver</a>";	
		}
		mysqli_close($con);
		?>
</body>
</html>