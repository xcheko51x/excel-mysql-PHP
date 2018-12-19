<?php

// ABRE CONEXION CON LA BASE DE DATOS
$conexion = mysqli_connect("localhost", "root", ""); // Tus datos de conexion a la base de datos
mysqli_select_db($conexion, "pruebas"); // Tu base de datos

// CONSULTA
$sql = "SELECT * FROM usuarios"; // Consulta a la base de datos

// SE GUARDAN LOS RESULTADOS DE LA CONSULTA
$resultado = mysqli_query($conexion, $sql);

// SE CREA UN ARREGLO
$usuarios = array();

// SE ALMANCENAN LOS REGISTROS OBTENIDOS EN EL ARREGLO
while($registros = mysqli_fetch_assoc($resultado)) {
	$usuarios[] = $registros;
}

// CIERRA LA CONEXION A LA BASE DE DATOS
mysqli_close($conexion);

//////// EN LA SIGUIENTE SECCION ENTRA CUANDO SE OPRIME EL BOTON DE CREAR EXCEL
if(isset($_POST["exportar"])) { // VALIDA QUE SE OPRIMIO EL BOTON
	if(!empty($usuarios)) { // VALIDA QUE EL ARREGLO NO ESTE VACIO
		$filename = "usuarios.xls"; // NOMBRE DEL ARCHIVO QUE SE VA A GENERAR

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filename);

		$mostrar = false;

		foreach ($usuarios as $usuario) { // Recorrido e insercion de los registros en el Archivo
			if(!$mostrar) {
				echo implode("\t", array_keys($usuario)). "\n";
				$mostrar = true;
			}

			echo implode("\t", array_values($usuario)). "\n";
		}
	} else {
		echo "No hay datos a exportar.";
	}

	exit;
}

?>

<div align="center">
	<table border="1">
		<thead>
			<th> ID Usuario </th>
			<th> Nombre </th>
			<th> Telefono </th>
			<th> Email </th>
		</thead>
		<tbody>
			<?php foreach ($usuarios as $usuario) { ?>
				<tr>
					<td> <?php echo $usuario['idUsuario'] ?> </td>
					<td> <?php echo $usuario['nombre'] ?> </td>
					<td> <?php echo $usuario['telefono'] ?> </td>
					<td> <?php echo $usuario['email'] ?> </td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<br>
<div align="center">
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
		<button type="submit" name="exportar">
			CREAR EXCEL
		</button>
	</form>
</div>
