<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username     = $_POST['username'];
    $email        = $_POST['email'];
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, email) 
            VALUES ('$username', '$password', '$email')";

    if (mysqli_query($conn, $query)) {
        $message = "Registrasi berhasil!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CAMERRA - Sign Up</title>
    <link rel="stylesheet" href="style_signin.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inria+Sans&display=swap" rel="stylesheet">
  
  
</head>
<body>
    <div class="akun">
        <h1 class="akun-text">Sign Up</h1>
        <?php if (!empty($message)): ?>
            <p style="color: white; text-align:center;"><?= $message ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input class="text" type="text" name="username" placeholder="Username" required>
            <input class="text" type="email" name="email" placeholder="Email" required>
            <input class="text" type="password" name="password" placeholder="Password" required>
            <button class="cta" type="submit">Sign Up</button>
        </form>

        <p class="akun-desc">
            Already Registered? <a href="signin.php" style="color:#FEF9E1; text-decoration: underline;">Sign In</a>
        </p>

        
    </div>
</body>
</html>
