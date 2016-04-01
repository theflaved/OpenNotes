<?php
session_start();

include "mongotools.php";
include 'login.html';

$usersWorker = new mongoWorker('users');

$email = $password = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = hash("sha512", $_POST["password"]);
    $userId = $usersWorker->idGetter($email);

    if($_COOKIE["attempts"] < 3){
        if ($userId == null) {
            echo "
        <script>
        loginFailEvent();
        </script>";
        } else {
            $user = $usersWorker->docGetter($userId);
            if($user["pword"] == $password){
                echo '<script>UIkit.modal.alert("I'm alive! Reading from bd success")</script>';
            } else {
                echo '
        <script>
        loginFailEvent();
        </script>';
            }
        }
    } else {
        echo '<script>loginFailEvent()</script>';
    }
}

mongoWorker::usersAdd("some@mail.com", "somepassword5", "Alexander T.5");
echo '</body></html>';
?>