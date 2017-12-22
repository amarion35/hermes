<?php

session_start();

function errorNewLogin()
{
    if (isset($_GET['errorNewLogin'])) {
        if ($_GET['errorNewLogin']) {
            echo 'Your login is no longer available or is not in the correct format<br>';
        }
    }
}
function errorNewPassword()
{
    if (isset($_GET['errorNewPassword'])) {
        if ($_GET['errorNewPassword']) {
            echo 'Your password is not in the correct format<br>';
        }
    }
}
function errorNewMail()
{
    if (isset($_GET['errorNewMail'])) {
        if ($_GET['errorNewMail']) {
            echo 'There is already an account registered with this mail or this not in the correct format<br>';
        }
    }
}
function errorNewMailVerification()
{
    if (isset($_GET['errorNewMailVerification'])) {
        if ($_GET['errorNewMailVerification']) {
            echo 'There is an error in the mail verification<br>';
        }
    }
}
function errorNewCGU()
{
    if (isset($_GET['errorNewCGU'])) {
        if ($_GET['errorNewCGU']) {
            echo 'You have to accept CGU to register<br>';
        }
    }
}
function errorLogin()
{
    if (isset($_GET['errorLogin'])) {
        if ($_GET['errorLogin']) {
            echo 'Incorrect login or password <br>';
        }
    }
}
function successfullRegistration(){
    if(isset($_GET['registred'])){
        if($_GET['registred']==1){
            echo "You have been successfully registred";
        }
    }
}

if(isset($_SESSION['ID'])){
    header("location: My_Wall.php");
    exit();
}

?>

<!DOCTYPE html>

<html>

    <head>
        <?php include "PartOfPage/standardHead.html"; ?>
        <link rel="stylesheet" href="css/Accueil.css">
    </head>

    <body>


        <header>
            <h1 class="Hermes">Hermes</h1>
        </header>

        <div class="underHeader">
            <h1>Welcome</h1>
        </div>

        <p>Hermes is a social network where everyone is anonymous.
            Express yourself, share and chat with new people from everywhere!</p>

        <p>
            <?php successfullRegistration(); ?>
        </p>




        <div class="LogForms">
            <div class="LogForm">
                <form class="form" method="post" action="Action/CreateNewAccount.php">
                    <fieldset>
                            <legend>Create a new account</legend>
                            <div class="inForm">
                                <span class="Error"><?php errorNewLogin(); ?></span>
                                Login<br><input type="text" name="Login" placeholder="Your login.."><br>

                                <span class="Error"><?php errorNewPassword(); ?></span>
                                Password<br><input type="password" name="Password" placeholder="Your password.."><br>

                                <span class="Error"><?php errorNewMail(); ?></span>
                                E-mail<br><input type="text" name="Mail" placeholder="Your mail.."><br>

                                <span class="Error"><?php errorNewMailVerification(); ?></span>
                                Verify E-mail<br><input type="text" name="MailVerification" placeholder="Your mail.."><br>

                                <span class="Error"><?php errorNewCGU(); ?></span>
                                Accept CGU <input type="checkbox" name="CGU"><br>


                                <input class="submit" type="submit" value="Sign up" >
                            </div>
                    </fieldset>
                </form>
            </div>
            <div class="LogForm">
                <form class="form" method="post" action="Action/LogIn.php">
                    <fieldset>
                        <legend>Log in</legend>
                        <div class="inForm">
                            <?php errorLogin(); ?>
                            Login<br><input type="text" name="Login" placeholder="Your login.."><br>
                            Password<br><input type="password" name="Password" placeholder="Your password.."><br>
                            <input type="submit" value="Log in" >
                        </div>
                    </fieldset>
                </form>
            </div>

        </div>

        <p>
            <?php
                //$username = "root";
                //$password = "";
                //$host = "localhost";
                //$name = "hermes";
                $username = "u422732477_amari"; //hostinger identifiants
                $password = "ixoicu";
                $host = "mysql.hostinger.fr";
                $name = "u422732477_herme";

                try{
                    $bdd = new PDO("mysql:host=localhost;dbname=$name;charset=utf8", $username, $password);
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $reponseListUsers = $bdd->query('SELECT * FROM utilisateurs');
                    $reponseNbUsers = $bdd->query('SELECT COUNT(*) FROM utilisateurs');
                    $nbUsers = $reponseNbUsers->fetch();
                    echo '<section><h2>Already '.$nbUsers[0].' "real" users:</h2>';
                    //echo "Réponse requête SQL: ";
                    echo "<p>";
                    while($donnees = $reponseListUsers->fetch()) {
                        echo '<br>', $donnees['Login'];
                    }
                    echo "<br></p></section>";
                }catch(PDOException $e){
                    echo "Connection failed: " . $e->getMessage();
                }
            ?>
        </p>

    </body>

</html>