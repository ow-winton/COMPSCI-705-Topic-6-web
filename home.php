<?php
session_start();

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// 连接到 MySQL 数据库
$host = '172.23.60.213';
$user = 'root';
$password = 'passwordforroot';
$db = 'cs705_db';

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);

// 处理文件标签
if (isset($_POST['add_tag'])) {
    $file_id = $_POST['file_id'];
    $tag_name = $_POST['tag_name'];

    // 检查标签是否已存在
    $stmt = $conn->prepare("SELECT * FROM tags WHERE tag_name = :tag_name");
    $stmt->bindParam(':tag_name', $tag_name);
    $stmt->execute();
    $tag = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tag) {
        // 标签已存在，直接插入关联记录
        $tag_id = $tag['id'];
    } else {
        // 标签不存在，先插入到 tags 表，再插入关联记录
        $stmt = $conn->prepare("INSERT INTO tags (tag_name) VALUES (:tag_name)");
        $stmt->bindParam(':tag_name', $tag_name);
        $stmt->execute();

        $tag_id = $conn->lastInsertId();
    }

    // 插入关联记录到 file_tags 表
    $stmt = $conn->prepare("INSERT INTO file_tags (file_id, tag_id) VALUES (:file_id, :tag_id)");
    $stmt->bindParam(':file_id', $file_id);
    $stmt->bindParam(':tag_id', $tag_id);
    $stmt->execute();

    echo "标签添加成功！";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>文件管理系统 - 主页</title>
</head>
<body>
<h1>欢迎回来，<?php echo $_SESSION['username']; ?>！</h1>

<h2>上传文件</h2>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <input type="submit" name="upload" value="上传">
</form>
<br>
<h2>文件列表</h2>
<?php
// 查询当前用户的文件列表
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM files WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($files as $file) {
    echo $file['filename'] . ' <a href="index.php?delete=' . $file['id'] . '">删除</a>';

    // 查询文件的标签列表
    $stmt = $conn->prepare("SELECT t.tag_name FROM tags t JOIN file_tags ft ON t.id = ft.tag_id WHERE ft.file_id = :file_id");
    $stmt->bindParam(':file_id', $file['id']);
    $stmt->execute();
    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tags as $tag) {
        echo ' <span style="background-color: lightgray; padding: 2px;">' . $tag['tag_name'] . '</span>';
    }

    // 添加标签表单
    echo '
        <form method="post">
            <input type="hidden" name="file_id" value="' . $file['id'] . '">
            <input type="text" name="tag_name" placeholder="标签名" required>
            <input type="submit" name="add_tag" value="添加标签">
        </form>';

    echo '<br>';
}
?>
<br>
<a href="index.php">返回</a>
</body>
</html>
