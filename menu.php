<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("location: login.php");
    exit();
}
?>

<html>
	<head>
		<title>
			PÀGINA WEB DEL MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP
		</title>
	</head>
	<body>
		<h2> MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP damola</h2>
		<a href="http://zend-damola.fjeclot.net/proyecto/seleccioUsuari.php">Mostrar Usuari</a>
		<br><br>
		<a href="http://zend-damola.fjeclot.net/proyecto/crearUsuari.php">Crear Usuari</a>
        <a href="http://zend-damola.fjeclot.net/proyecto/modificarAtribut.php">Modificar Atribut</a>
        <a href="http://zend-damola.fjeclot.net/proyecto/eliminarUsuari.php">Eliminar Usuari</a>
        <br><br>
		<a href="http://zend-damola.fjeclot.net/proyecto/index.php">Torna a la pàgina inicial</a>
	</body>
</html>
