<!DOCTYPE html>
<html>
	<head>
		<title>Tipo Visualización</title>
	</head>
	<body>
		<?php
		
		# Reanudación de sesión:
		session_start();
		
		include 'funciones.php';
		
		if (isset($_POST["firstmonth"]) and isset($_POST["lastmonth"])){
			$firstmonth=$_POST["firstmonth"];
			$lastmonth=$_POST["lastmonth"];
		} else{
			$firstmonth=$_SESSION['firstmonth'];
			$lastmonth=$_SESSION['lastmonth'];
		}
		
		# Definición de variables de sesión:
		$_SESSION['firstmonth'] = $firstmonth;
		$_SESSION['lastmonth'] = $lastmonth;
		
		$firstyear=$_SESSION['firstyear'];
		$lastyear=$_SESSION['lastyear'];
		
		# Funciones para sacar el último día de los meses incial y final:
		$fmlastday=fmld($firstmonth);
		$lmlastday=lmld($lastmonth);
		
		if (isset($firstmonth) and isset($lastmonth)){
			if ($firstyear==$lastyear and $firstmonth>$lastmonth){
				echo "Error en la selección de meses.</br>";
				echo "<b>Nota: No se puede seleccionar un mes inicial superior al mes final dentro del mismo año.</b></br>";
				echo "<a href='month.php'>Volver a intentarlo</a>";
			}else if ($firstyear=date('Y') and $firstmonth==date('m')){
				# Formulario de selección de días:
				echo "<form method='post' action='visualizacion.php'>";
				echo "Selecciona días inicial y final:</br>";
				echo "Día inicial:";
				echo "<select name='firstday'></br>";
				for ($i = 1; $i <= date('d'); $i++){
					echo "<option value=".$i.">".$i."</option>";
				}
				echo "</select><br>";
				echo "Día final:";
				echo "<select name='lastday'>";
				for ($i = 1; $i <= date('d'); $i++){
					echo "<option value=".$i.">".$i."</option>";
				}
				echo "</select><br>";
				echo "<input type='submit' value='Tipo Visualización ->'/><br>";
				echo "</form>";
				echo "<a href='month.php'>Volver</a>";
			}else{
				# Formulario de selección de días:
				echo "<form method='post' action='visualizacion.php'>";
				echo "Selecciona días inicial y final:</br>";
				echo "Día inicial:";
				echo "<select name='firstday'></br>";
				for ($i = 1; $i <= $fmlastday; $i++){
					echo "<option value=".$i.">".$i."</option>";
				}
				echo "</select><br>";
				echo "Día final:";
				echo "<select name='lastday'>";
				for ($i = 1; $i <= $lmlastday; $i++){
					echo "<option value=".$i.">".$i."</option>";
				}
				echo "</select><br>";
				echo "<input type='submit' value='Tipo Visualización ->'/><br>";
				echo "</form>";
				echo "<a href='month.php'>Volver</a>";
			}
		}
		?>
	</body>
</html>