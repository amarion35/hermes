<!DOCTYPE>

<html>
<?php

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
function verifyLogin($login, $bdd){
    if(strlen($login)>10){
        echo "<br>Login too long";
        return true;
    }elseif(strlen($login)<1){
        echo "<br>Login too short";
        return true;
    }
    elseif($login=="Admin"){
        echo "<br>You can/'t log as admin";
        return true;
    }
    try{
        $response = $bdd->query('SELECT Login FROM utilisateurs');
        while($loginsList = $response->fetch()){
            //echo $loginsList['Login']."<br>";
            if($loginsList['Login']==$login){
                echo "<br>Login already used";
                return true;
            }
        }
        return false;
    }catch(Exception $e){
        echo "Erreur requête SQL :".$e->getMessage();
        return false;
    }
}
function verifyPassword($password){
    if(strlen($password)>10){
        echo "<br>Password too long";
        return true;
    }
    if(strlen($password)<5){
        echo "<br>Password too short";
        return true;
    }
    return false;
}
function verifyMail($mail, $bdd){
    if(strlen($mail)>150){
        echo "<br>E-mail too long";
        return true;
    }
    try{
        $response = $bdd->query('SELECT Mail FROM utilisateurs');
        while($loginsList = $response->fetch()){
            //echo $loginsList['Mail']."<br>";
            if($loginsList['Mail']==$mail){
                echo "<br>Mail already used";
                return true;
            }
        }
        return false;
    }catch(Exception $e){
        echo "Erreur requête SQL :".$e->getMessage();
        return false;
    }

}
function verifyMailVerification($mail, $mailVerification){
    if($mailVerification!=$mail){
        return true;
    }
    return false;
}
function dicoParametersChecker($parameter){
    $parameterChecks = array();
    foreach ($parameter as $para){
        $parameterChecks[$para] = false;
        if(!isset($_POST[$para])||$_POST[$para]==""){
            //echo $para." is not set<br>";
            $parameterChecks[$para] = true;
            //echo "parameterChecks[$para] = ".$parameterChecks[$para]."<br>";
        }
    }
    return $parameterChecks;
}
function verifyAllAndBuildUrl($parameterChecks)
{

    $url = "";
    foreach ($parameterChecks as $index => $error) {
        //echo $check;
        //echo("index = " . $index . " -------------- check = " . $check . "<br>");
        //header('Location: ..\Bienvenue.php?bug='.$check);
        if ($error) {
            $_POST['errorNew' . $index] = $error;
            //echo "_POST[" . 'errorNew' . $index . "] = " . $_POST['errorNew' . $index] . "<br>";
            $url = $url . 'errorNew' . $index . "=" . $error . "&";
        }
    }
    return $url;
}
function addUser($bdd){
    $max = 0;
    try{
        $response = $bdd->query('SELECT ID FROM utilisateurs');
        while($idList = $response->fetch()){
            $id = $idList['ID'];
            echo "<br>$id";
            $id = str_replace("#","", $id);
            $id = intval($id);
            if($id>$max){
                $max=$id;
            }
        }
        $id = '#'.($max+1);
        echo "<br>$id";

        $bdd->query('INSERT INTO utilisateurs (ID, Login, Mot_de_passe, Mail, Pseudo) VALUES ("'.$id.'", "'.$_POST['Login'].'", "'.$_POST['Password'].'","'.$_POST['Mail'].'", "'.$_POST['Login'].'")');
    }catch(Exception $e){
        echo "<br>Erreur requête SQL :".$e->getMessage();
    }
}

$bdd = connectToDataBase();
$parameter = ["Login","Password","Mail","MailVerification","CGU"];
$parameterChecks = dicoParametersChecker($parameter);
$parameterChecks['Login'] = verifyLogin($_POST['Login'], $bdd);
$parameterChecks['Password'] = verifyPassword($_POST['Password']);
$parameterChecks['Mail'] = verifyMail($_POST['Mail'], $bdd);
$parameterChecks['Mail'] = verifyMailVerification($_POST['Mail'],$_POST['MailVerification']);
$url_Parameters = verifyAllAndBuildUrl($parameterChecks);
addUser($bdd);





if($url_Parameters!=""){
    header('Location: ..\Bienvenue.php?'.$url_Parameters);
    exit();
}else{
    header('Location: ..\Bienvenue.php?registred=1');
    exit();
}

?>

</html>
