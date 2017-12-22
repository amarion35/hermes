<?php
include 'PartOfPage/ConnectedServices.php';


if(!isset($_SESSION['ID'])){
    header("location: Bienvenue.php");
    exit();
}

if (isset($_GET['login'])){
    $hostLogin = $_GET['login'];
    $hostID = getIDFromLogin($hostLogin, $bdd);
}
?>

<!DOCTYPE html>

<html>

    <head>
        <?php include "PartOfPage/standardHead.html"; ?>
        <link rel="stylesheet" href="css/Wall.css">
    </head>

        <body>
            <?php include 'PartOfPage/Header.php'; ?>
            <?php include 'PartOfPage/MobileButtons.php'; ?>
            <div class="midder">
                    <?php include 'PartOfPage/LeftSide.php'; ?>
                    <?php include 'PartOfPage/WallCenter.php'; ?>
                    <?php include 'PartOfPage/RightSide.php'; ?>
            </div>
            <?php include 'PartOfPage/Footer.php' ?>


    </body>
</html>

