<?php


function printFriends($id, $bdd){
    try{
        $reponseListUsers = $bdd->query("SELECT utilisateurs.* 
                                                      FROM utilisateurs INNER JOIN friends 
                                                      ON (utilisateurs.ID = friends.user1 
                                                        OR utilisateurs.ID = friends.user2) 
                                                      WHERE (friends.user1 = '$id' 
                                                        OR friends.user2 = '$id')");
        echo "<p class='user'>";
        while($donnees = $reponseListUsers->fetch()) {
            if($donnees['Login']!=$_SESSION['Login']) {
                $login = $donnees['Login'];
                $friendID = $donnees['ID'];
                echo "<a href='Wall.php?login=".$login."'>".$login."</a><br>";
            }
        }
        echo "</p>";
    }catch(PDOException $e){
        echo "SQL request failed: " . $e->getMessage();
    }
}
function resultFromFriendRequest(){
    if(isset ($_GET['u'])){
        switch($_GET['u']){
            case '0':
                echo "<div class='Success'>Friend request sent</div>";
                break;
            case '1':
                echo "<div class='Error'>User not found</div>";
                break;
            case '2':
                echo "<div class='Error'>You are already friends</div>";
                break;
            case '3':
                echo "<div class='Error'>You are already waiting for a response from this user</div>";
                break;
            default:
                break;
        }
    }
}

$myLogin = getLoginFromId($_SESSION['ID'], $bdd);
?>

<div class="LeftSide">
    <div class="Menu">
        <a href="My_Wall.php">News</a><br>
        <a href="Wall.php?login=<?php echo $myLogin; ?>">My wall</a><br>
        <a href="Messaging.php">Messages</a>
    </div>

    <div class="Friends">
        <?php resultFromFriendRequest(); ?>
        <form method="post" action="Action/AskFriend.php">
            <input type="text" name="friendLogin">
            <br>
            <input class="btn btn-primary" type="submit" value="Add friend">
        </form>
        <h4>Friends</h4>
        <?php printFriends($_SESSION['ID'], $bdd); ?>
    </div>
</div>