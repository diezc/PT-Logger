<!DOCTYPE html>
<html>
	<head>
		<title>Años</title>
	</head>
	<body>
		<?php
		
		# Reanudación de sesión:
		session_start();
		
		if (isset($_POST["medicion"])){
			$medicion=$_POST["medicion"];
		} else{
			$medicion=$_SESSION['medicion'];
		}
		
		# Definición de variable de sesión:
		$_SESSION['medicion'] = $medicion;
		
		if (isset($medicion)){
			
			# Formulario de selección de años inicial y final de la consulta:
			echo "<form method='post' action='month.php'>";
			echo "Selecciona franja de años:</br>";
			echo "<select name='firstyear'></br>";
			for ($i = 2017; $i <= date('Y'); $i++){
				echo "<option value=".$i.">".$i."</option>";
			}
			echo "</select><br>";
			echo "<select name='lastyear'>";
			for ($i = 2017; $i <= date('Y'); $i++){
				echo "<option value=".$i.">".$i."</option>";
			}
			echo "</select><br>";
			echo "<input type='submit' value='Meses ->'/><br>";
			echo "</form>";
			echo "<a href='mediciones.php'>Volver</a>";
				
		}
		?>
	</body>
</html>