<?php
session_start();

// 连接到 MySQL 数据库
 $host = 'localhost';
    $user = 'ss';
    $password = '123123';
    $db = 'ss';

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);

// 处理用户注册
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 检查用户名是否已存在
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "用户名已存在，请选择其他用户名。";
    } else {
        // 将用户信息插入到 users 表
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        echo "注册成功！";
    }
}

// 处理用户登录
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 检查用户名和密码是否匹配
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // 登录成功，将用户信息保存到 session 中
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: personalHome.php");
    } else {
        echo "用户名或密码错误。";
    }
}

// 处理文件上传
if (isset($_POST['upload'])) {
    $filename = $_FILES['file']['name'];
    $filepath = 'uploads/' . $filename;
    $user_id = $_SESSION['user_id'];

    // 将文件信息插入到 files 表
    $stmt = $conn->prepare("INSERT INTO files (filename, filepath, user_id) VALUES (:filename, :filepath, :user_id)");
    $stmt->bindParam(':filename', $filename);
    $stmt->bindParam(':filepath', $filepath);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    move_uploaded_file($_FILES['file']['tmp_name'], $filepath);

    echo "文件上传成功！";
}

// 处理文件删除
if (isset($_GET['delete'])) {
    $file_id = $_GET['delete'];

    // 根据文件 ID 查询文件信息
    $stmt = $conn->prepare("SELECT * FROM files WHERE id = :file_id");
    $stmt->bindParam(':file_id', $file_id);
    $stmt->execute();
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        // 删除文件
        unlink($file['filepath']);

        // 删除文件记录
        $stmt = $conn->prepare("DELETE FROM files WHERE id = :file_id");
        $stmt->bindParam(':file_id', $file_id);
        $stmt->execute();

        echo "文件删除成功！";
    } else {
        echo "文件不存在。";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>文件管理系统</title>
</head>
<body>
<h1>欢迎使用文件管理系统</h1>

<?php if (isset($_SESSION['username'])): ?>
    <p>当前用户：<?php echo $_SESSION['username']; ?></p>
    <a href="logout.php">退出登录</a>
    <br><br>
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
        echo $file['filename'] . ' <a href="index.php?delete=' . $file['id'] . '">删除</a><br>';
    }
    ?>
<?php else: ?>
    <h2>用户注册</h2>
    <form method="post">
        <input type="text" name="username" placeholder="用户名" required><br>
        <input type="password" name="password" placeholder="密码" required><br>
        <input type="submit" name="register" value="注册">
    </form>
    <br>
    <h2>用户登录</h2>
    <form method="post">
        <input type="text" name="username" placeholder="用户名" required><br>
        <input type="password" name="password" placeholder="密码" required><br>
        <input type="submit" name="login" value="登录">
    </form>
<?php endif; ?>
</body>
</html>
