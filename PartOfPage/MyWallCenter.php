<?php

function printPublishingSection(){
    echo '
                <section>
                    <form method="post" action="Action/Publish.php">
                        <fieldset>
                            <legend>Post</legend>
                            <textarea rows="4" cols="50" name="article"></textarea><br>
                            <input class="btn btn-success" type="submit" value="Publish">
                        </fieldset>
                    </form>
                </section>
                ';
}
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
        echo "<article><div class='headerArticle'><div class='date'>";
        echo printRelativeTime($date);
        echo "</div><div class='author'>$pseudo</div></div>";
        if(strpos($content, "<script>")==-1) {
            echo "<div class='articleContent'>" .htmlspecialchars_decode(
                $content) . "</div></article>";
        }else{
            echo "<div class='articleContent'>" ./*htmlspecialchars_decode(*/
                $content/*)*/ . "</div></article>";
        }
        }
}

?>

<div class="Center">
    <section>
        <h1> Welcome <?php echo $_SESSION['Login']; ?></h1>
    </section>

    <section>
        <p><a href="https://drive.google.com/open?id=0B_1F55qsBnfIbFJxTDE5M015OVU">Testez dès à présent la nouvelle application mobile Hermes!</a></p>
    </section>

    <?php printPublishingSection() ?>

    <section>
        <?php printArticles(getArticles($bdd,$_SESSION['ID']), $bdd); ?>
    </section>
</div>