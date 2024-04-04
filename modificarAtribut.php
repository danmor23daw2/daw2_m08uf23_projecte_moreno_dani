<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("location: login.php");
    exit();
}

if ($_POST["metodo"] == "PUT") {
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    $atributo = $_POST['atributo'];
    $nuevo_valor = $_POST['nuevo_valor'];
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
    
    $entrada = $ldap->getEntry($dn);
    
    if ($entrada) {
        Attribute::setAttribute($entrada, $atributo, $nuevo_valor);
        $ldap->update($dn, $entrada);
        echo "Atributo modificado";
    } else {
        echo "<b>Aquesta entrada no existeix</b><br><br>";
    }
} else {
    ?>
<form method="POST">
	<input type="hidden" name="metodo" value="PUT">
    UID: <input type="text" name="uid"><br>
    Organizació: <input type="text" name="organizacion"><br><br>
    Atribut a modificar:<br><br>
    <input type="radio" name="atributo" value="uidNumber"> uidNumber<br>
    <input type="radio" name="atributo" value="gidNumber"> gidNumber<br>
    <input type="radio" name="atributo" value="homeDirectory"> Directori personal<br>
    <input type="radio" name="atributo" value="loginShell"> Shell<br>
    <input type="radio" name="atributo" value="cn"> cn<br>
    <input type="radio" name="atributo" value="sn"> sn<br>
    <input type="radio" name="atributo" value="givenName"> givenName<br>
    <input type="radio" name="atributo" value="postalAddress"> Postal Address<br>
    <input type="radio" name="atributo" value="mobile"> mobile<br>
    <input type="radio" name="atributo" value="telephoneNumber"> telephoneNumber<br>
    <input type="radio" name="atributo" value="title"> title<br>
    <input type="radio" name="atributo" value="description"> description<br><br>
    Nou valor: <input type="text" name="nuevo_valor"><br>
    <input type="submit" value="Modificar">
</form>
<?php
}
?>

