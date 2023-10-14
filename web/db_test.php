<?php
//    $host = 'sql210.bytecluster.com';
//    $user = 'if0_34966954';
//    $password = 'CbyXRcHCPk';
//    $db = 'if0_34966954_cs705_web_app_db';
    $host = 'sql210.infinityfree.com';
    $user = 'if0_34966954';
    $password = 'CbyXRcHCPk';
    $db = 'if0_34966954_cs705_web_app_db';
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
