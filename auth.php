<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

session_start();

if ($_POST['cts'] && $_POST['adm']){
   $opciones = [
        'host' => 'zend-damola.fjeclot.net',
        'username' => "cn=admin,dc=fjeclot,dc=net",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
   ];  
   $ldap = new Ldap($opciones);
   $dn='cn='.$_POST['adm'].',dc=fjeclot,dc=net';
   $ctsnya=$_POST['cts'];
   try{
       $ldap->bind($dn,$ctsnya);
       $_SESSION['authenticated'] = true;
       header("location: menu.php");
       exit();
   } catch (Exception $e){
       echo "<b>Contrasenya incorrecta</b><br><br>";         
   }
}

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
?>

<html>
<head>
    <title>AUTENTICACIÓ AMB LDAP</title>
</head>
<body>
    <a href="/proyectoM08uf23/index.php">Torna a la pàgina inicial</a>
    <h2>Iniciar sesión</h2>
    <form method="post">
        <label for="adm">Admin:</label><br>
        <input type="text" id="adm" name="adm"><br>
        <label for="cts">Contrasenya:</label><br>
        <input type="password" id="cts" name="cts"><br><br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>

<?php
} else {
    header("location: menu.php");
    exit();
}
?>
