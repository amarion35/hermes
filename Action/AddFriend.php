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
function userLoginExist($login, $bdd){
    try {
        $response = $bdd->query("SELECT ID FROM utilisateurs WHERE Login='$login'");
        while ($id = $response->fetch()) {
            $ID = $id['ID'];
        }
        if($ID==""){
            echo "User not found";
            return false;
        }else {
            echo "<br>User found: $ID";
            return ($ID);
        }
    }catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
    echo "User not found";
    return false;
}
function friendship($ID1, $ID2, $bdd){
    try{
        $response = $bdd->query("SELECT * FROM friends WHERE (user1='$ID1' AND user2='$ID2') OR (user1='$ID2' AND user2='$ID1')");
        while ($friendship = $response->fetch()){
            if($friendship['ID']!=null){
                echo("Friendship already exist");
                return true;
            }
        }
        echo "<br>No friendship detected<br>";
        return false;
    }
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        return true;
    }
    return true;
}
function addFriendshipRelation($ID1, $ID2, $bdd){
    $max = 0;
    try{
        $response = $bdd->query('SELECT ID FROM friends');
        while($idList = $response->fetch()){
            $id = $idList['ID'];
            //echo "<br>$id";
            $id = str_replace("F","", $id);
            $id = intval($id);
            if($id>$max){
                $max=$id;
            }
        }
        $id = 'F'.($max+1);
        $bdd->query("INSERT INTO friends(ID, user1, user2) VALUES ('$id', '$ID1', '$ID2')");
        echo "Friendship relation created";
        return true;
    }
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
    return false;
}
function createNotification($bdd, $userID, $type, $argument){
    echo "This function create new Notification";
    $max = 0;
    try{
        $response = $bdd->query('SELECT ID FROM notification');
        while($idList = $response->fetch()){
            $id = $idList['ID'];
            //echo "<br>$id";
            $id = str_replace("N","", $id);
            $id = intval($id);
            if($id>$max){
                $max=$id;
            }
        }
        $id = 'N'.($max+1);
        $bdd->query("INSERT INTO notification (ID, UserID, Type, Argument, Processed) VALUES ('$id', '$userID', '$type', '$argument', 0)");
        echo "Notification created";
        return true;
    }
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
    return false;
}
function removeNotification($bdd, $id){
    echo "This is the remove notification function";
    try{
        $bdd->query("UPDATE notification SET Processed=1 WHERE ID='$id'");
        echo "SQL request worked";
    }catch(Exception $e){
        echo "SQL request failed: " . $e->getMessage();
    }

}


$bdd = connectToDataBase();
if (isset($_POST['friendLogin'])){
    if(isset($_POST['notificationID'])) {
        $notificationID = $_POST['notificationID'];
        $friendID = userLoginExist($_POST['friendLogin'], $bdd);
        if ($friendID == false) {
            header('Location: ..\My_Wall.php?u=1');
            exit();
        }
        if (!friendship($_SESSION['ID'], $friendID, $bdd)) {
            addFriendshipRelation($_SESSION['ID'], $friendID, $bdd);
            createNotification($bdd, $_SESSION['ID'], "NewFriendship", $friendID);
            createNotification($bdd, $friendID, "NewFriendship", $_SESSION['ID']);
            removeNotification($bdd, $notificationID);
            /*
            try {
                $bdd->query("UPDATE notification SET Processed=1 WHERE ID='$id'");
                echo "SQL request worked";
            } catch (Exception $e) {
                echo "SQL request failed: " . $e->getMessage();
            }*/

        }
        else{
            removeNotification($bdd, $notificationID);
            header('Location: ..\My_Wall.php?u=2');
            exit();
        }
    }
}


header('Location: ..\My_Wall.php');
exit();