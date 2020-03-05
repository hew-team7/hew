<?php

session_start();
// セッションの値を初期化
$_SESSION = array();

// セッションを破棄
session_destroy();

header("location:./index.php");

?>