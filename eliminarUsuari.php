<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['organizacion'];
    $dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';

    $opciones = [
        'host' => 'zend-damola.fjeclot.net',
        'username' => 'cn=admin,dc=fjeclot,dc=net',
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',        
    ];

    $ldap = new Ldap($opciones);
    $ldap->bind();

    try {
        $ldap->delete($dn);
        echo "<b>Entrada esborrada</b><br>"; 
    } catch (Exception $e) {
        echo "<b>Aquesta entrada no existeix</b><br>";
    }
} else {
?>
<form method="post">
    UID: <input type="text" name="uid"><br>
    Organizació: <input type="text" name="organizacion"><br>
    <input type="submit" value="Eliminar">
</form>
<?php
}
?>
