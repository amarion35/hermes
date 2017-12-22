<?php

function getArticles($bdd, $id){
    try{
        $response = $bdd->query("SELECT *
                                    FROM articles
                                    WHERE UserID IN (
                                                    SELECT ID
                                                    FROM utilisateurs
                                                    WHERE ID IN(
                                                                SELECT user1
                                                                FROM friends
                                                                WHERE user1='$id' OR user2='$id'
                                                                )
                                                          OR ID IN (
                                                                SELECT user2
                                                                FROM friends
                                                                WHERE user1='$id' OR user2='$id'
                                                                )
                                    )
                                    OR UserID = '$id'
                                    ORDER BY Date DESC");
    }catch(Exception $e){
        echo "SQL query failed: " . $e->getMessage();
        return false;
    }
    return $response;
}
function printArticles($articles, $bdd){
    while($art = $articles->fetch()){
        $date = $art['Date'];
        $content = $art['Content'];
        $userId = $art['UserID'];
        $response2 = $bdd->query("SELECT Pseudo FROM utilisateurs WHERE ID='$userId'");
        while($uid = $response2->fetch()){
            $pseudo = $uid['Pseudo'];
            if($userId == $_SESSION['ID']){
                $pseudo = "Me";
            }
        }
        echo "<article><h4 class='headerArticle'><div class='date'>$date</div><div class='author'>$pseudo</div></h4>";
        echo "<div class='articleContent'><p id='article'>".htmlspecialchars_decode($content)."</p></div></article>";
    }
}
function getArticlesFrom($bdd, $id){
    try{
        $response = $bdd->query("SELECT *
                                    FROM articles
                                    WHERE UserID = '$id'
                                    ORDER BY Date DESC");
    }catch(Exception $e){
        echo "SQL query failed: " . $e->getMessage();
        return false;
    }
    return $response;
}

?>

<div class="Center">
    <section>
        <h1> <?php echo $hostLogin; ?>'s wall</h1>
    </section>


    <!--<section>
        <form method="post" action="Action/Publish.php">
            <fieldset>
                <legend>Post</legend>
                <textarea rows="4" cols="50" name="article"></textarea><br>
                <input type="submit" value="Publish">
            </fieldset>
        </form>
    </section>-->

    <section>
        <?php
        $bdd = connectToDataBase();
        printArticles(getArticlesFrom($bdd,$hostID), $bdd);

        ?>
    </section>
</div>