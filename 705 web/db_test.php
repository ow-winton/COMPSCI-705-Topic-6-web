<?php
//    $host = 'sql210.bytecluster.com';
//    $user = 'if0_34966954';
//    $password = 'CbyXRcHCPk';
//    $db = 'if0_34966954_cs705_web_app_db';
    $host = 'localhost';
    $user = 'root';
    $password = '123';
    $db = '112';
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
