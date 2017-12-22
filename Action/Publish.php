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
function addArticle($bdd, $article, $userId){
    $max = 0;
    try{
        $response = $bdd->query('SELECT ID FROM articles');
        while($idList = $response->fetch()){
            $id = $idList['ID'];
            $id = str_replace("A","", $id);
            $id = intval($id);
            if($id>$max){
                $max=$id;
            }
        }
        $id = 'A'.($max+1);
        echo "<br>$id";
        echo "<br>article: ".$article;
        $formatedArticle = htmlspecialchars($article);
        echo "<br>formated: ".$formatedArticle;
        $bdd->query('INSERT INTO articles (ID, UserID, Content) VALUES ("'.$id.'", "'.$userId.'", "'.$formatedArticle.'")');
    }catch(Exception $e){
        echo "<br>Erreur requête SQL :".$e->getMessage();
    }
}

$article = false;
if(isset($_POST['article'])) {
    $article = $_POST['article'];
    echo "<br>article: $article<br>";
}else{
    header('Location: ..\My_Wall.php');
    exit();
}

$bdd = connectToDataBase();
addArticle($bdd, $article, $_SESSION['ID']);


header('Location: ..\My_Wall.php');
exit();