<?php include "PartOfPage/ConnectedServices.php"; ?>




<?php


if(!isset($_SESSION['ID'])){
    header("location: Bienvenue.php");
    exit();
}
if(isset($_GET['User'])){
    $correspondent = $_GET['User'];
}else{
    $correspondent = getLoginFromId($_SESSION['ID'], $bdd);
}
if(isset($_POST['MessagingFriend'])){
    if(userLoginExist($_POST['MessagingFriend'], $bdd)) {
        $correspondent = $_POST['MessagingFriend'];
    }
    else{
        $correspondent = getLoginFromId($_SESSION['ID'], $bdd);
    }
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
        <?php include 'PartOfPage/MobileButtonsMessaging.php'; ?>


        <div class="midder">
            <?php include 'PartOfPage/LeftSide.php'; ?>
            <?php include 'PartOfPage/MessagingCenter.php'; ?>
            <?php include 'PartOfPage/RightSide.php'; ?>
        </div>
        <?php include 'PartOfPage/Footer.php' ?>
    </body>

</html>