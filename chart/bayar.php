<?php
session_start();

if (!isset($_SESSION['order'])) {
    header("Location: cart.php");
    exit;
}


unset($_SESSION['order']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil</title>
</head>
<body>
    <h1 style="text-align:center; color:green;">✅ Pembayaran berhasil!</h1>
    <p style="text-align:center;"><a href="../1landingpage.php">Kembali ke Beranda</a></p>
</body>
</html>
