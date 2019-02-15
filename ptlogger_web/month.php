<!DOCTYPE html>
<html>
	<head>
		<title>Meses</title>
	</head>
	<body>
		<?php
		
		# Reanudación de sesión:
		session_start();
		
		if (isset($_POST["firstyear"]) and isset($_POST["lastyear"])){
			$firstyear=$_POST["firstyear"];
			$lastyear=$_POST["lastyear"];
		} else{
			$firstyear=$_SESSION['firstyear'];
			$lastyear=$_SESSION['lastyear'];
		}
		
		# Definición de variables de sesión:
		$_SESSION['firstyear'] = $firstyear;
		$_SESSION['lastyear'] = $lastyear;
		
		if (isset($firstyear) and isset($lastyear) and ($firstyear<=$lastyear) and ($lastyear-$firstyear <= 2)){
			# Formulario de selección de meses inicial y final de la consulta:
			echo "<form method='post' action='days.php'>";
			if ($firstyear == date('Y')){
				echo "Selecciona meses inicial y final:</br>";
				echo "Mes inicial:";
				echo "<select name='firstmonth'></br>";
				for ($i = 1; $i <= date('m'); $i++){
					echo "<option value=".$i."/>".$i."</option>";
				}
				echo "</select><br>";
				echo "Mes final:";
				echo "<select name='lastmonth'>";
				for ($i = 1; $i <= date('m'); $i++){
					echo "<option value=".$i."/>".$i."</option>";
				}
				echo "</select><br>";
				echo "<input type='submit' value='Días ->'/><br>";
				echo "</form>";
				echo "<a href='year.php'>Volver</a>";
			} else {
				echo "Selecciona meses inicial y final:</br>";
				echo "Mes inicial:";
				echo "<select name='firstmonth'></br>";
				for ($i = 1; $i <= 12; $i++){
					echo "<option value=".$i.">".$i."</option>";
				}
				echo "</select><br>";
				echo "Mes final:";
				echo "<select name='lastmonth'>";
				for ($i = 1; $i <= 12; $i++){
					echo "<option value=".$i.">".$i."</option>";
				}
				echo "</select><br>";
				echo "<input type='submit' value='Días ->'/><br>";
				echo "</form>";
				echo "<a href='year.php'>Volver</a>";
			}
		} else {
			echo "La franja seleccionada no es válida o es demasiado grande";
			echo "<b>Nota: el año inicial no puede ser mayor que el año final, y la diferencia entre ambos no puede ser superior a dos años.</b>";
			echo "<a href='year.php'>Volver a intentarlo</a>";
		}
		?>
	</body>
</html>