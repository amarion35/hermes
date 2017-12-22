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
function addMessage($bdd, $message, $fromID, $toID){
    $max = 0;
    try{
        $response = $bdd->query('SELECT ID FROM messages');
        while($idList = $response->fetch()){
            $id = $idList['ID'];
            $id = str_replace("M","", $id);
            $id = intval($id);
            if($id>$max){
                $max=$id;
            }
        }
        $id = 'M'.($max+1);
        echo "<br>$id";
        echo "<br>article: ".$message;
        $formatedMessage = htmlspecialchars($message);
        echo "<br>formated: ".$formatedMessage;
        $bdd->query('INSERT INTO messages (ID, FromUser, ToUser, Content) VALUES ("'.$id.'", "'.$fromID.'", "'.$toID.'", "'.$formatedMessage.'")');
    }catch(Exception $e){
        echo "<br>Erreur requête SQL :".$e->getMessage();
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

echo "coucou<br>";
$message = false;
if(isset($_POST['message']) && isset($_POST['toID'])) {
    $message = $_POST['message'];
    $toID = $_POST['toID'];
    $bdd = connectToDataBase();
    $toLogin = getLoginFromId($toID, $bdd);
    echo "<br>message: $message<br>";
}else{
    header('Location: ..\Messaging.php');
    exit();
}

if($_SESSION['ID']!=$toID) {
    addMessage($bdd, $message, $_SESSION['ID'], $toID);
}else{
    header('Location: ..\Messaging.php');
    exit();
}


header('Location: ..\Messaging.php?User='.$toLogin);