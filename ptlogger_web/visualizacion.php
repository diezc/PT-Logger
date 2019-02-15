<!DOCTYPE html>
<html>
	<head>
		<title>Tipo Visualización</title>
	</head>
	<body>
		<?php
		
		# Reanudación de sesión:
		session_start();
		
		if (isset($_POST["firstday"]) and isset($_POST["lastday"])){
			$firstday=$_POST["firstday"];
			$lastday=$_POST["lastday"];
		} else{
			$firstday=$_SESSION['firstday'];
			$lastday=$_SESSION['lastday'];
		}
		
		# Definición de variables de sesión:
		$_SESSION['firstday'] = $firstday;
		$_SESSION['lastday'] = $lastday;
		
		$firstyear=$_SESSION['firstyear'];
		$lastyear=$_SESSION['lastyear'];
		$firstmonth=$_SESSION['firstmonth'];
		$lastmonth=$_SESSION['lastmonth'];
		
		if (isset($firstday) and isset($lastday)){
			if ($firstyear==$lastyear and $firstmonth==$lastmonth and $firstday>$lastday){
				echo "Error en la selección de días.</br>";
				echo "<b>Nota: No se puede seleccionar un día inicial superior al día final dentro del mismo año y el mismo mes.</b></br>";
				echo "<a href='days.php'>Volver a intentarlo</a>";
			}else{
				# Formulario de selección de salida de datos:
				echo "<form method='post' action='table_graph.php'>";
				echo "Selecciona método de salida de datos:</br> ";
				echo "<select name='representacion'>";
				echo "<option value='grafica'>Gráfica</option>";
				echo "<option value='tabla'>Tabla</option>";
				echo "</select><br>";
				echo "<input type='submit' value='Visualizacion ->'/><br>";
				echo "</form>";
				echo "<a href='days.php'>Volver</a>";
			}
		}
		?>
	</body>
</html>