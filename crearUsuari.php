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

if ($_POST["metodo"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['organizacion'];
    $num_id = $_POST['uidNumber'];
    $grup = $_POST['gidNumber'];
    $dir_pers = $_POST['homeDirectory'];
    $sh = $_POST['loginShell'];
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $nom = $_POST['givenName'];
    $mobil = $_POST['mobile'];
    $adressa = $_POST['postalAddress'];
    $telefon = $_POST['telephoneNumber'];
    $titol = $_POST['title'];
    $descripcio = $_POST['description'];
    $objcl = [
        'inetOrgPerson',
        'organizationalPerson',
        'person',
        'posixAccount',
        'shadowAccount',
        'top'
    ];

    $domini = 'dc=fjeclot,dc=net';
    $opciones = [
        'host' => 'zends-damola.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];  

    $ldap = new Ldap($opciones);
    $ldap->bind();
    
    $nova_entrada = [];
    Attribute::setAttribute($nova_entrada, 'objectClass', $objcl);
    Attribute::setAttribute($nova_entrada, 'uid', $uid);
    Attribute::setAttribute($nova_entrada, 'uidNumber', $num_id);
    Attribute::setAttribute($nova_entrada, 'gidNumber', $grup);
    Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
    Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
    Attribute::setAttribute($nova_entrada, 'cn', $cn);
    Attribute::setAttribute($nova_entrada, 'sn', $sn);
    Attribute::setAttribute($nova_entrada, 'givenName', $nom);
    Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
    Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
    Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
    Attribute::setAttribute($nova_entrada, 'title', $titol);
    Attribute::setAttribute($nova_entrada, 'description', $descripcio);
    
    $dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';
    if($ldap->add($dn, $nova_entrada)) {
        echo "Usuari Creat";
    } else {
        echo "Error al crear el usuario";
    }
} else {
?>
<form method="POST">
<input type="hidden" name="metodo" value="POST">
    UID: <input type="text" name="uid"><br>
    Organización: <input type="text" name="organizacion"><br>
    uidNumber: <input type="text" name="uidNumber"><br>
    gidNumber: <input type="text" name="gidNumber"><br>
    homeDirectory: <input type="text" name="homeDirectory"><br>
    loginShell: <input type="text" name="loginShell"><br>
    cn: <input type="text" name="cn"><br>
    sn: <input type="text" name="sn"><br>
    givenName: <input type="text" name="givenName"><br>
    mobile: <input type="text" name="mobile"><br>
    postalAddress: <input type="text" name="postalAddress"><br>
    telephoneNumber: <input type="text" name="telephoneNumber"><br>
    title: <input type="text" name="title"><br>
    description: <input type="text" name="description"><br>
    <input type="submit">
</form>
<?php
}
?>
