<?php 
include 'db_test.php';
session_start();
$id=$_GET['id'];
$uid=$_SESSION['user_id'];
 $stmt = $conn->prepare("SELECT * FROM favorite where uid =$uid and fid =$id ");
   
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($user)){	
    $stmt = $conn->prepare("insert into favorite (uid,fid) values (:a,:s) ");
    $stmt->bindParam(':a', $uid);
    $stmt->bindParam(':s', $id);
    $stmt->execute();
   header("Location: index.php");
    }else{
  echo "<script>alert('I have already collected it');location.href='/index.php'</script>";die;
    }



 ?>