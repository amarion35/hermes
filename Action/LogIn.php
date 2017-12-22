<!DOCTYPE>
<?php

session_start();

function connectToDataBase(){
    //$username = "root";
    //$password = "";
    //$host = "localhost";
    //$name = "hermes";
    $username = "u422732477_amari";
    $password = "ixoicu";
    $host = "mysql.hostinger.fr";
    $name = "u422732477_herme";
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
function verifyLogin($login, $password, $bdd){
    try{
        $response = $bdd->query("SELECT ID FROM utilisateurs WHERE Login='$login' AND Mot_de_passe='$password'");
        while($id = $response->fetch()){
            return $id['ID'];
        }
        return false;
    }catch(Exception $e){
        echo "Erreur requête SQL :".$e->getMessage();
        return false;
    }
}
function getData($col, $id, $bdd){
    try{
        $response = $bdd->query("SELECT $col FROM utilisateurs WHERE ID='$id'");
        while($id = $response->fetch()){
            return $id['ID'];
        }
        return false;
    }catch(Exception $e){
        echo "Erreur requête SQL :".$e->getMessage();
        return false;
    }
}


echo "<br>Hello<br>";
$login = false;
$password = false;
if(isset($_POST['Login'])){
    $login = $_POST['Login'];
}else{
    header("Location: ..\Bienvenue.php?errorLogin=1");
    exit();
}
if(isset($_POST['Password'])){
    $password = $_POST['Password'];
}else{
    header("Location: ..\Bienvenue.php?errorLogin=1");
    exit();
}

$bdd = connectToDataBase();
$id = false;
$id = verifyLogin($login, $password, $bdd);

if($id==false){
    echo "<br>id is false<br>";
    header("Location: ..\Bienvenue.php?errorLogin=1");
    exit();
}
echo "<br>Hello<br>";
$_SESSION['ID'] = $id;
$_SESSION['Login'] = $login;
$_SESSION['Pseudo'] = getData('Pseudo', $id, $bdd);
header("Location: ..\My_Wall.php");
exit();

?>