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
function friendshipAsked($ID1, $ID2, $bdd){
    try{
        $response = $bdd->query("SELECT * FROM notification WHERE UserID='$ID1' AND Type='FriendshipRequest' AND Argument='$ID2' AND Processed=0");
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
function askFriendshipRelation($ID1, $ID2, $bdd){
    $max = 0;
    try{
        $response = $bdd->query('SELECT ID FROM notification');
        while($idList = $response->fetch()){
            $id = $idList['ID'];
            echo "<br>$id";
            $id = str_replace("N","", $id);
            $id = intval($id);
            if($id>$max){
                $max=$id;
            }
        }
        $id = 'F'.($max+1);
        $bdd->query("INSERT INTO notification(ID, UserID, Type, Argument, Processed) VALUES ('$id', '$ID2', 'FriendshipRequest', '$ID1', 0)");
        echo "Friendship relation asked";
        return true;
    }
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
    return false;
}


$bdd = connectToDataBase();
if (isset($_POST['friendLogin'])){
    $friendID = userLoginExist($_POST['friendLogin'], $bdd);
    if($friendID==false){
        header('Location: ..\My_Wall.php?u=1');
        exit();
    }
    if (!friendship($_SESSION['ID'], $friendID, $bdd)){
        if(!friendshipAsked($friendID, $_SESSION['ID'], $bdd)){
            askFriendshipRelation($_SESSION['ID'], $friendID, $bdd);
        }
        else{
            header('Location: ..\My_Wall.php?u=3');
            exit();
        }
    }
    else{
        header('Location: ..\My_Wall.php?u=2');
        exit();
    }
}

header('Location: ..\My_Wall.php?u=0');
exit();