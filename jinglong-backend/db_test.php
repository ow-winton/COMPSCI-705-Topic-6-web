<?php
//    $host = 'sql210.bytecluster.com';
//    $user = 'if0_34966954';
//    $password = 'CbyXRcHCPk';
//    $db = 'if0_34966954_cs705_web_app_db';
    $host = '172.23.60.213';
    $user = 'root';
    $password = 'passwordforroot';
    $db = 'cs705_db';

    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
