<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$host = 'localhost';
$user = 'ss';
$password = '123123';
$db = 'ss';

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
$file_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM files WHERE id = :file_id");
$stmt->bindParam(':file_id', $file_id);
$stmt->execute();
$file = $stmt->fetch(PDO::FETCH_ASSOC);

if ($file && $file['user_id'] == $_SESSION['user_id']) {
    // 设置 headers，告诉浏览器这是一个文件下载的请求
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . basename($file['filename']) . "\"");

    // 读取并发送文件内容
    readfile($file['filepath']);
} else {
    echo "文件不存在或你没有权限下载这个文件。";
    exit();
}
?>
