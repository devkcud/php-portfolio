<?php
require_once("../utils/gen.php");
require_once "../utils/db.php";
require_once("../utils/auth.php");

redirectNotLogged("login.php");

$userid = $_GET["id"];

$userquery = $db->prepare("SELECT * FROM person WHERE id = ? LIMIT 1");
$userquery->bind_param("s", $userid);
$userquery->execute();

if ($userquery->error != "") {
    echo "User not found.";
    return;
}

$user = $userquery->get_result()->fetch_assoc();

gen_head("Perfil de @" . $user["username"]);
?>

<div class="container p-4 m-auto">
    <h1 class="text-4xl"><?php echo $user["fullname"] ?></h1>
    <p>@<?php echo $user["username"] ?></p>
</div>