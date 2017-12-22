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

$bdd = connectToDataBase();


if(isset($_POST['notificationID'])){
    $notificationID = $_POST['notificationID'];
    try{
    $bdd->query("UPDATE notification SET Processed=1 WHERE ID='$notificationID'");
    echo "SQL request worked";
    }catch(Exception $e){
        echo "SQL request failed: " . $e->getMessage();
    }
}

header("Location: ..\My_Wall.php");
exit();
