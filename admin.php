<?php

$users = "admin";
$passwords = "qwerty";

$validated = ($_SERVER['PHP_AUTH_USER'] == $users) && ($_SERVER['PHP_AUTH_PW'] == $passwords);
if (!$validated) {
  header('WWW-Authenticate: Basic realm="My Realm"');
  header('HTTP/1.0 401 Unauthorized');
  die ("Not authorized");
}

if ($_POST["name"] && $_POST["content"] && $_GET["file"]) {
  $contents = file_get_contents ($_GET["file"]);
  $pattern = '/(<!-- editable '.$_POST["name"].' -->)([\s\S]*)(<!-- endeditable '.$_POST["name"].' -->)/i';
  $replacement = '${1}'.$_POST["content"].'${3}';
  $contents = preg_replace($pattern, $replacement, $contents);
  file_put_contents($_GET["file"], $contents);
} else {
  header('Location: /');
}

?>
