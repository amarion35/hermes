<?php

/*function printMessagingFriends($id, $bdd){
    echo "
    
    <div class='MessagingContact'>
        <div class='MessagingSearch'>
            Select user:<br>
            <form method='post' action='Messaging.php'>
                <input type='text' name='MessagingFriend'>
                <input type='submit' value='New message'>
            </form>
        </div>
    ";
    try{
        $reponseListUsers = $bdd->query("SELECT DISTINCT * FROM utilisateurs WHERE ID IN( SELECT FromUser FROM messages WHERE FromUser='$id' OR ToUser='$id' ORDER BY Date DESC )");

        while($donnees = $reponseListUsers->fetch()) {
            if($donnees['Login']!=$_SESSION['Login']) {
                $login = $donnees['Login'];
                $friendID = $donnees['ID'];

                $responseListMessages = $bdd->query("SELECT * FROM messages WHERE (FromUser='$id' AND ToUser='$friendID') OR (FromUser='$friendID' AND ToUser='$id') ORDER BY Date DESC");
                $donnees = $responseListMessages->fetch();
                $messageID = $donnees['ID'];
                $FromUser = $donnees['FromUser'];
                $ToUser = $donnees['ToUser'];
                $Content = $donnees['Content'];
                $Date = $donnees['Date'];
                if($FromUser==$_SESSION['ID']){
                    $FromUser = "Me";
                }else{
                    $FromUser = $login;
                }
                if($messageID!="") {
                    echo "
                        <a href='Messaging.php?'></a>
                        <div class='LastFriendMessage'>
                        <div class='LastFriendMessageHeader'>
                            <div class='date'>
                                ".printRelativeTime($Date)."
                            </div>
                            <a href='Wall.php?login=" . $login . "'>" . $login . "</a>
                        </div>
                        <div class='LastFriendMessageContent'>
                            $FromUser: $Content
                        </div>
                        </div>
                    ";
                }
            }
        }

        echo "</div>";
    }catch(PDOException $e){
        echo "SQL request failed: " . $e->getMessage();
    }
}*/
function printMessagingFriends($id, $bdd){
    echo "
        <div class='MessagingContact'>
            <div class='MessagingSearch'>
                Select user:<br>
                <form method='post' action='Messaging.php'>
                    <input type='text' name='MessagingFriend'>
                    <input type='submit' value='New message'>
                </form>
            </div>
            <div class='LastConversations'>
    ";
    try{
        $reponseMessages = $bdd->query("SELECT * FROM messages WHERE FromUser='$id' OR ToUser='$id' ORDER BY Date DESC");
        $conversationsAlreadyPrinted = ["$id"];
        while($message = $reponseMessages->fetch()){
            $messageID = $message['ID'];
            $fromUser = $message['FromUser'];
            $toUser = $message['ToUser'];
            $date = $message['Date'];
            $content = $message['Content'];
            $autorRegistred = in_array("$fromUser", $conversationsAlreadyPrinted);
            $recipientRegistred = in_array("$toUser", $conversationsAlreadyPrinted);
            $oneNotRegistred = !$autorRegistred||!$recipientRegistred;
            if($oneNotRegistred){
                if(!$autorRegistred){
                    array_push($conversationsAlreadyPrinted, "$fromUser");
                }
                if (!$recipientRegistred){
                    array_push($conversationsAlreadyPrinted, "$toUser");
                }
                if ($fromUser==$_SESSION['ID']){
                    $correspondentID = $toUser;
                }else{
                    $correspondentID = $fromUser;
                }
                $correspondentLogin = getLoginFromID($correspondentID, $bdd);
                $fromLogin = getLoginFromID($fromUser, $bdd);
                if($messageID!="") {
                    echo "
                        <div class='LastFriendMessage' correspondentLogin='$correspondentLogin'>
                        <div class='LastFriendMessageHeader'>
                            <div class='date'>
                                ".printRelativeTime($date)."
                            </div>
                            <a href='Wall.php?login=" . $correspondentLogin . "'>" . $correspondentLogin . "</a>
                        </div>
                        <div class='LastFriendMessageContent'>
                            $fromLogin: $content
                        </div>
                        </div>
                    ";
                }
            }else{
            }

        }

        echo "</div>
            </div>";
    }catch(PDOException $e){
        echo "SQL request failed: " . $e->getMessage();
    }
}
function printConversationHeader($login){

    echo $login;

}
function printMessages($id, $correspondent, $bdd){

    $response = $bdd->query("SELECT * FROM utilisateurs WHERE ID='$id'");
    $user = $response->fetch();
    $login = $user['Login'];
    echo "<div class='ConversationHeader'>";
        printConversationHeader($correspondent);
    echo "</div>";
    echo "<div class='Conversation'>";
        if($_SESSION['ID']!=getIdFromLogin($correspondent, $bdd)) {
            printConversation($_SESSION['ID'], getIdFromLogin($correspondent, $bdd), $bdd);
        }
    echo "</div>";
    if($_SESSION['ID']!=getIdFromLogin($correspondent, $bdd)) {
        printSendingZone(getIdFromLogin($correspondent, $bdd));
    }


}
function printMessage($message, $bdd){
    $date = $message['Date'];
    $idAutor = $message['FromUser'];
    $loginAutor = getLoginFromId($idAutor, $bdd);
    $content = $message['Content'];
    if($idAutor!=$_SESSION['ID']) {
            echo "<div class='MessageLeft'>";
        }else{
            echo "<div class='MessageRight'>";
        }
        echo "<div class='Message'>";
            echo "<div class='MessageHeader'>";
                echo "<div class='MessageDate'>";
                    echo "<div class='date'>";
                        echo printRelativeTime($date);
                    echo "</div>";
                echo "</div>";
                echo "<div class='MessageAutor'>";
                    echo $loginAutor;
                echo "</div>";
            echo "</div>";
            echo "<div class='MessageContent'>";
                echo $content;
            echo "</div>";
        echo "</div>";
    echo "</div>";
}
function printConversation($id, $IdCorrespondent, $bdd){
    try{
        $response = $bdd->query("SELECT * FROM messages WHERE (FromUser='$id' AND ToUser='$IdCorrespondent') OR (FromUser='$IdCorrespondent' AND ToUser='$id') ORDER BY Date");
        while($message = $response->fetch()){
            printMessage($message, $bdd);
        }
    }catch(Exception $e){
        echo "SQL request failed: " . $e->getMessage();
    }
}
function printSendingZone($toID){
    echo "<div class='MessageSendingZone'>";
        echo "<form method='post' action='Action/SendMessage.php'>";
            echo "<textarea  name='message' class='MessageTextArea'></textarea>";
            echo "<input type='hidden' name='toID' value='$toID'>";
            echo "<input type='submit' value='Send' class='MessageSendButton'>";
        echo "</form>";
    echo "</div>";
}

?>


<div class="Center">
    <section>
        <h1> Messaging </h1>
    </section>


    <?php
    if(isset($_GET['ID'])){
        printPublishingSection();
    }
    ?>
    <div class="MessagingWindow">
        <?php printMessagingFriends($_SESSION['ID'], $bdd); ?>
        <div class="Messaging">
            <?php printMessages($_SESSION['ID'], $correspondent, $bdd); ?>
        </div>
    </div>

    <script>
        $(".LastFriendMessage").click(function(){
            var correspondentLogin = $(this).attr('correspondentLogin');
            var url = 'Messaging.php';
            var form = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="MessagingFriend" value="' + correspondentLogin + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        });
        $(".LastFriendMessage").hover(
        function()
        {
            $(this).css("background", "#a7a8c3");
        },
        function(){
            var color = $(".LastFriendMessage").css("background");
            $(this).css("background", color);
        }
        );
    </script>

</div>