<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = basename($_SERVER['PHP_SELF']);
    header("Location: signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CAMERRA</title>
    <link rel="stylesheet" href="style_dashboard.css" />
</head>
<body>

    <header class="hero-section">
        <div class="hero-content">
            <div class="product-images">
                <div class="image-placeholder main-product">
                    <img src="img/fujifilm1.jpg" alt="Gambar Produk Utama" class="main-product-image" />
                </div>
            </div>

            <div class="text-content">
                <img src="img/logo.png" alt="Ikon camera" class="camera-icon" />
                <p class="sub-headline">Solusi Kamera Profesional</p>
                <h1>Abadikan Momen dengan Kualitas Terbaik</h1>
                <p class="description">
                    Temukan koleksi kamera DSLR & mirrorless terbaik hanya di CAMERRA. Cocok untuk semua level, dari pemula hingga profesional.
                </p>
                <a class="shop-now-button" href="1landingpage.php">
                    BELANJA SEKARANG
                </a>
            </div>
        </div>
    </header>

</body>
</html>
