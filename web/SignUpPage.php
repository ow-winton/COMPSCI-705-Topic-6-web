<?php 
include 'db_test.php'; 
if(!empty($_POST)){
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

        header("Location: LoginPage.php");
    }
}

 ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <script defer src="./index.js"></script>
    <title>Sign Up</title>
  </head>
  <body>
    <div class="container">
      <div class="left-side">
        <form action="#" id="form" method="post">
          <h1 class="title">Sign Up</h1>
          <div class="external-links">
            <a href="#" id="facebook"
              ><i class="bi bi-facebook"></i>Sign Up with Facebook</a
            >
            <a href="#" id="google"
              ><i class="bi bi-google"></i>Sign Up with Google</a
            >
          </div>
          <div class="or-section">
            <hr />
            <h4>Or</h4>
            <hr />
          </div>
          <div class="input-control">
            <label for="username">Username</label> <br />
            <input
              type="text"
              name="username"
              id="username"
              placeholder="Username..."
              class="form-control mt-1"
            />
            <div class="error"></div>
          </div>
          <div class="input-control">
            <label for="email">Email</label> <br />
            <input
              type="email"
              name="email"
              id="email"
              placeholder="Email..."
              class="form-control mt-1"
            />
            <div class="error"></div>
          </div>
          <div class="input-control">
            <label for="password">Password</label> <br />
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Password..."
              class="form-control mt-1"
            />
            <div class="error"></div>
          </div>
          <div class="input-control">
            <label for="username">Confirm Password</label>
            <input
              type="password"
              name="password2"
              id="password2"
              placeholder="Password..."
              class="form-control mt-1"
            />
            <div class="error"></div>
          </div>
          <div class="remember-forgot mt-1">
            <label for="remember">
              <input
                type="checkbox"
                name="remember"
                id="remember"
                class="form-check-input"
              />
              Remember me</label
            >
            <a href="#">Forgot password?</a>
          </div>
          <div class="submit">
            <input type="submit" value="Sign up" />
          </div>
          <div class="login-link mt-2">
            <p>
              Already have an account? Click here to
              <a href="./LoginPage.php">Log in</a>
            </p>
          </div>
        </form>
      </div>
      <div class="right-side">
        <img src="./Images/AI_Generated_Image.jpg" alt="" />
      </div>
    </div>
  </body>
</html>
