<?php
session_start();
include 'config.php';

$message = ''; // Inisialisasi variabel pesan

// (BAGIAN BARU) Periksa apakah ada pesan yang dikirim dari halaman lain
if (isset($_SESSION['login_message'])) {
    $message = $_SESSION['login_message'];
    unset($_SESSION['login_message']); // Hapus pesan setelah diambil agar tidak muncul lagi
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) >= 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            if (isset($_SESSION['redirect_to'])) {
                $go = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header("Location: $go");
            } else {
                header("Location: 1landingpage.php");
            }
            exit();
        } else {
            // Pesan error ini akan menimpa pesan 'login_message', dan itu benar.
            $message = "Password salah!";
        }
    } else {
        $message = "Username tidak ditemukan!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>CAMERRA - Sign In</title>
    <script src="https://kit.fontawesome.com/488d622bc0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_signin.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inria+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <div class="akun">
        <h1 class="akun-text">Sign In</h1>
        <?php if (!empty($message)): ?>
            <p style="color: white; text-align:center; padding: 0 15px;"><?= $message ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input class="text" type="text" name="username" placeholder="Username" required>
            <input class="text" type="password" name="password" placeholder="Password" required>
            <button class="cta" type="submit">Sign In</button>
        </form>

        <p class="akun-desc">Belum punya akun? <a href="signup.php" style="color:#FEF9E1; text-decoration: none;">Daftar</a></p>

    </div>
</body>
</html>