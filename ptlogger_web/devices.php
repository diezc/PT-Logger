<!DOCTYPE html>
<html>
	<head>
		<title>Dispositivos</title>
	</head>
	<body>
		<?php
		
		# Inicio de sesión:
		session_start();
		
		if (isset($_POST["correo"]) and isset($_POST["passwd"])){
			$correo=$_POST["correo"];
			$pass=$_POST["passwd"];
		} else{
			$correo=$_SESSION['correo'];
			$pass=$_SESSION['pass'];
		}
		
		$_SESSION['correo']=$correo;
		$_SESSION['pass']=$pass;
		
		$length=strlen($pass);
		
		# Llamada a los archivos con variables y funciones:
		include 'variables.php';
		include 'funciones.php';
		
		# Función de conexión:
		$con=conect($location,$user,$password,$db);
	
		if (!$con){
			echo "No se ha podido conectar a la base de datos. Inténtelo de nuevo.";
			exit;
		}
		
		# Función de confirmación de usuario:
		$confirmacion=confirm($correo,$pass,$con);
		
		if ($confirmacion == 0 and $length>=8 and $length<=20){
		
			# Función de consulta de dispositivos a DB:
			$devices=dispositivos($correo,$con);
	
			if (!$devices){	
				echo "No se han encontrado dispositivos.";
				exit;
			}
		
			# Formulario de selección de dispositivo:
			echo "<form method='post' action='mediciones.php'>";
			echo "Selecciona un dispositivo:</br> ";
			echo "<select name='device'>";
			while ($fila=mysqli_fetch_assoc($devices)){
				echo "<option name='device' value=".$fila["device_id"].">".$fila["device_id"]."</option></br>";
			};
			echo "</select><br>";
			echo "<input type='submit' value='Siguiente ->'/><br>";
			echo "</form>";
			echo "<a href='index.html'>Volver</a>";
		}else{
			echo "Usuario o contraseña incorrectos.<br>";
			echo "<a href='index.html'>Volver a intentarlo</a>";
		}
		
		mysqli_close($con);
		?>
</body>
</html>