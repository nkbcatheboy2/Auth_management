<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body style="display:flex; align-items:center; justify-content:center; height:100vh;">
    <div class="card" style="width:400px; text-align:center;">
        <h1 style="margin-bottom:20px;">ESPL Login</h1>
        <?php
        if(isset($_POST['login'])){
            $u = mysqli_real_escape_string($conn, $_POST['user']);
            $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$u'");
            if($row = mysqli_fetch_assoc($res)){
                if(password_verify($_POST['pass'], $row['password'])){
                    $_SESSION['role'] = $row['role']; $_SESSION['user'] = $row['username'];
                    header("Location: dashboard.php");
                } else { echo "<p style='color:red;'>Wrong Password</p>"; }
            } else { echo "<p style='color:red;'>User Not Found</p>"; }
        }
        ?>
        <form method="POST">
            <input type="text" name="user" placeholder="Username" required style="margin-bottom:10px;">
            <input type="password" name="pass" placeholder="Password" required style="margin-bottom:20px;">
            <button type="submit" name="login" class="btn-main">Login to Dashboard</button>
        </form>
    </div>
</body>
</html>
