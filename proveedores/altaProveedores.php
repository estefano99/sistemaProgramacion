<?php
     session_start();
     include("../config/db.php");
     $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "" ; 
     $telefono = (isset($_POST["telefono"])) ? $_POST["telefono"] : "" ; 
     $cuit = (isset($_POST["cuit"])) ? $_POST["cuit"] : "" ; 

     $telefono = strval($telefono);

     function ValidateCUITCUIL($cuit)
	{
		if (strlen($cuit) != 13) return false;
		
		$rv = false;
		$resultado = 0;
		$cuit_nro = str_replace("-", "", $cuit);
		
		$codes = "6789456789";
		$cuit_long = intVal($cuit_nro);
		$verificador = intVal($cuit_nro[strlen($cuit_nro)-1]);
        
		$x = 0;
		
		while ($x < 10)
		{
			$digitoValidador = intVal(substr($codes, $x, 1));
			$digito = intVal(substr($cuit_nro, $x, 1));
			$digitoValidacion = $digitoValidador * $digito;
			$resultado += $digitoValidacion;
			$x++;
		}
		$resultado = intVal($resultado) % 11;
		$rv = $resultado == $verificador;
		return $rv;
	}

    $validacion = ValidateCUITCUIL($cuit);

	//Valido que no exista ese proveedores con esa cuit/cuil
    $consulta = $conexion -> prepare("SELECT nombre from proveedores where nombre = :nombre");
    $consulta -> bindParam("nombre",$nombre); 
    $consulta -> execute();
    $listaConsulta = $consulta -> fetch(PDO::FETCH_LAZY);

	//Si existe el cuit y si no esta repetido se ingresan los datos
     if ($validacion) {
		if (!$listaConsulta) {	
			$consulta = $conexion -> prepare("INSERT into proveedores(nombre,telefono,cuit,estado) values (:nombre,:telefono,:cuit,1)");
			$consulta -> bindParam(":nombre",$nombre);
			$consulta -> bindParam(":telefono",$telefono);
			$consulta -> bindParam(":cuit",$cuit);
			$consulta -> execute();
			header("location:proveedores.php");
		}else{
			$mensajeError = "Error. Proveedor ya existente.";
			header("location:proveedores.php?msge=$mensajeError");
		}
          
     }else{
          $mensaje = "Cuit mal ingresado";
          header("location:DarDeAlta.php?msg=$mensaje");
     }

?>