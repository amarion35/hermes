<?php

function getNotification($bdd, $id){
    try{
        $response = $bdd->query("SELECT *
                                    FROM notification
                                    WHERE UserId = '$id'
                                    ORDER BY Date DESC");
    }catch(Exception $e){
        echo "SQL query failed: " . $e->getMessage();
        return false;
    }
    return $response;
}
function printFriendshipRequest($notif, $bdd){
    $notificationID = $notif['ID'];
    $date = $notif['Date'];
    $askerID = $notif['Argument'];
    $processed = $notif['Processed'];
    try {
        $response2 = $bdd->query("SELECT Pseudo FROM utilisateurs WHERE ID='$askerID'");
        while ($uid = $response2->fetch()) {
            $pseudo = $uid['Pseudo'];
        }
        if ($processed == 0) {
            echo "
            <div class='notification'>
                <div class='notifcationDate'>$date</div>
                <div class='notificationText'>
                    You received a friendship request from $pseudo<br>
                    Do you want to accept?
                </div>
                <form class='notificationButton' method='post' action='Action/AddFriend.php'>
                    <input type='hidden' name='notificationID' value='$notificationID'>
                    <input type='hidden' name='friendLogin' value='$pseudo'>
                    <input type='submit' value='Yes'>
                </form>
                
                <form class='notificationButton' method='post' action='Action/RemoveNotification.php'>
                    <input type='hidden' name='notificationID' value='$notificationID'>
                    <input type='submit' value='No'>
                </form>
                
            </div>
            
         ";

        }
    }catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
function printNewFriendship($notif, $bdd){
    $notificationID = $notif['ID'];
    $date = $notif['Date'];
    $askerID = $notif['Argument'];
    $processed = $notif['Processed'];
    try {
        $response2 = $bdd->query("SELECT Pseudo FROM utilisateurs WHERE ID='$askerID'");

        while($uid = $response2->fetch()){
            $pseudo = $uid['Pseudo'];
        }
        echo "
        <div class='notification'>
            <div class='notificationText'>
                $pseudo and you are now friends
            </div>
        </div>
        
        ";

    }catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
    }

}
function printNotifications($notifications, $bdd){
    while($notif = $notifications->fetch()){
        $date = $notif['Date'];
        $type = $notif['Type'];
        $userId = $notif['UserID'];
        $argument = $notif['Argument'];
        $processed = $notif['Processed'];
        if($processed==0) {
            switch ($type) {
                case 'FriendshipRequest':
                    printFriendshipRequest($notif, $bdd);
                    break;
                case 'NewFriendship':
                    printNewFriendship($notif, $bdd);
                    break;
                default:
                    break;

            }
        }
    }
}

?>

<div class="RightSide">
    <div class="Notifications">
        <h3>Notifications</h3>
        <?php
        printNotifications(getNotification($bdd, $_SESSION['ID']), $bdd);
        ?>
    </div>
</div>