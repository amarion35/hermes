<?php

session_start();
if(!isset($_SESSION['ID'])){
    header("location: Bienvenue.php");
    exit();
}
function connectToDataBase(){
    $username = "root";
    $password = "";
    $host = "localhost";
    $name = "hermes";
    try {
        $bdd = new PDO("mysql:host=$host;dbname=$name;charset=utf8", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully<br>";
        //echo "<br>";
    }
    catch(PDOException $e){
        //echo "Connection failed: " . $e->getMessage();
    }
    return $bdd;
}
$bdd = connectToDataBase();

date_default_timezone_set('Africa/Bissau');//Timezone of the server used by Hostinger
function userLoginExist($login, $bdd){
    try {
        $response = $bdd->query("SELECT ID FROM utilisateurs WHERE Login='$login'");
        $ID = "";
        while ($id = $response->fetch()) {
            $ID = $id['ID'];
        }
        if($ID==""){
            //echo "User not found";
            return false;
        }else {
            return ($ID);
        }
    }catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
    echo "User not found";
    return false;
}
function getIdFromLogin($login, $bdd){
    try{
        $response = $bdd->query("SELECT * FROM utilisateurs WHERE Login='$login'");
        $user = $response->fetch();
        return ($user['ID']);
    }catch(Exception $e){
        echo "SQL query failed: " . $e->getMessage();
        return false;
    }
}
function getLoginFromId($id, $bdd){
    try{
        $response = $bdd->query("SELECT * FROM utilisateurs WHERE ID='$id'");
        $user = $response->fetch();
        return ($user['Login']);
    }catch(Exception $e){
        echo "SQL query failed: " . $e->getMessage();
        return false;
    }
}
function printRelativeTime($date)
{
    $datetime = new DateTime($date);
    $datetimeNow = new DateTime('now');
    $diff = $datetimeNow->diff($datetime);
    //2017-05-03 15:49:41
    $Y = intval($diff->format('%Y'));
    $m = intval($diff->format('%m'));
    $d = intval($diff->format('%d'));
    $H = intval($diff->format('%H'));
    $i = intval($diff->format('%i'));
    $s = intval($diff->format('%s'));
    //return "$Y-$m-$d $H:$i:$s";
    if ($Y > 1) {
        return $Y . " years";
    } elseif ($Y > 0) {
        return $Y . " year";
    } elseif ($m > 1) {
        return $m . " months";
    } elseif ($m > 0) {
        return $m . " month";
    } elseif ($d > 1) {
        return $d . " days";
    } elseif ($d > 0) {
        return $d . " day";
    } elseif ($H > 0) {
        return $H . "h";
    } elseif ($i > 0) {
        return $i . "min";
    } elseif ($s > 0) {
        return $s . "s";
    } else {
        return "Less than a minute";
    }
}


?>


