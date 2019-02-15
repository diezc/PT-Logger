<?php
	function conect($www, $usr, $pass, $ddbb){
		$con=mysqli_connect($www, $usr, $pass, $ddbb);
		return $con;
	}
	
	function confirm($usr,$pass,$con){
		$confirmacion="select user_email from users
		where user_email LIKE '".$usr."'";
		$confirmado=mysqli_query($con,$confirmacion);
			
		if ($confirmado){
			$contraseña="select user_password from users
			where user_email='".$usr."'";
			$passwd=mysqli_query($con,$contraseña);
			$cif=mysqli_fetch_assoc($passwd);
			$cifrada=$cif["user_password"];
			$pass=addslashes($pass);
			if (password_verify($pass, $cifrada)){
				$correct=0;
			}else{
				$correct=1;
			}
		}else{
			$correct=1;
		}
		return $correct;
	}
	
	function dispositivos($correo,$con){
		$devicecon="select device_id from devices,users 
		where users.user_id=devices.user_id
		and users.user_email LIKE '".$correo."'";
				
		$devices=mysqli_query($con,$devicecon);
		return $devices;
	}
	
	function measure($device,$con){
		$measurecon="select distinct type_name from value_types,logged_values,devices 
		where devices.device_id=logged_values.device_id
		and value_types.type_id=logged_values.value_type
		and devices.device_id='".$device."'";
		$medidas=mysqli_query($con,$measurecon);
		return $medidas;
	}
	
	function data($device,$medicion,$firstyear,$lastyear,$firstmonth,$lastmonth,$firstday,$lastday,$con){
		$datacon="select value_data,value_date from logged_values,value_types
		where value_types.type_id=logged_values.value_type
		and logged_values.device_id='".$device."'
		and value_types.type_name='".$medicion."'
		and logged_values.value_date between '".$firstyear."-".$firstmonth."-".$firstday." 00:00:00' and '".$lastyear."-".$lastmonth."-".$lastday." 23:59:59'";
		$datos=mysqli_query($con,$datacon);
		return $datos;
	}
	
	function fmld($firstmonth){
		switch($firstmonth){
				case 1:
				case 3:
				case 5:
				case 7:
				case 8:
				case 10:
				case 12:
					$fmlastday=31;
				case 2:
					if (date('L')==1){
						$fmlastday=29;
					}else{
						$fmlastday=28;
					}
				case 4:
				case 6:
				case 9:
				case 11:
					$fmlastday=30;
		}
		return $fmlastday;
	}
	
	function lmld($lastmonth){
		switch($lastmonth){
				case 1:
				case 3:
				case 5:
				case 7:
				case 8:
				case 10:
				case 12:
					$lmlastday=31;
				case 2:
					if (date('L')==1){
						$lmlastday=29;
					}else{
						$lmlastday=28;
					}
				case 4:
				case 6:
				case 9:
				case 11:
					$lmlastday=30;
		}
		return $lmlastday;
	}
	
?>