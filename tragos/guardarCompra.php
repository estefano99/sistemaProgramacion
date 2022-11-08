<?php
session_start();

if (!isset($_SESSION["user"]) or $_SESSION["tipoUser"] == 2) {
	header('Location: listaCompras.php');
}

	// leer datos de usuario y contraseña de la base de datos
include("configBD.php");

	// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
} else {
	echo "Connected successfully";
}
echo "<br>";

$id_prod = $_POST['idProducto'];
$id_cantidad = $_POST['cantidad'];

	$sql = "INSERT INTO `compras` (`fecha`,  `id_proveedor`, `borrado_compra`) VALUES ('$_POST[fecha]', '$_POST[idProveedor]', '$_POST[borradoCompra]')";

	if (mysqli_query($conn, $sql)) {
		$last_id = mysqli_insert_id($conn);
		for ($i=0; $i < count($id_prod); $i++) { 
			$sql1 = "INSERT INTO `compra_prod` (`id_compra`, `id_producto`,  `cantidad`) VALUES ($last_id, ".$id_prod[$i].", ".$id_cantidad[$i].")";
		
	    
			if (mysqli_query($conn, $sql1)) {
				$sql2 = "UPDATE `productos` SET `stock`= stock+$id_cantidad[$i] WHERE id_producto =".$id_prod[$i];

				if (mysqli_query($conn, $sql2)) {
					echo "New record created successfully";
					header('Location: listaCompras.php');
				}else {
					echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
					header('Location: nuevoCompra.php?error=1');
				}

			}else {
				echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
				header('Location: nuevoCompra.php?error=1');
			}
		}
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header('Location: nuevoCompra.php?error=1');
	}

	mysqli_close($conn);

		?>