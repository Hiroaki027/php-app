<?php
require_once('functions.php');

createData($_POST);
header('Location: ./index.php');

//header関数でリダイレクト先を指定し遷移
?>