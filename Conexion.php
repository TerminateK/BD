<?php

$link='mysql:host=localhost;dbname=bd';
$user='root';
$pw='';

try {
    $pdo= new PDO($link,$user,$pw);
    echo 'Wena culiao';
}

catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>