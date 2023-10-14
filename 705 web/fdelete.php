<?php 
include 'db_test.php';
$id=$_GET['id'];
 $stmt = $conn->prepare("delete from favorite WHERE id = :id ");
    $stmt->bindParam(':id', $id);
  
    $stmt->execute();
   header("Location: index.php");


 ?>