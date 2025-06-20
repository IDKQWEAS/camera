<?php
session_start();
require_once '../config.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];


// var_dump($cart); // Debugging: tampilkan isi keranjang
// return;

$productIds = array_keys($cart);
$products = [];

if (!empty($productIds)) {
    $ids = implode(",", array_map('intval', $productIds));
    $query = "SELECT * FROM product WHERE product_id IN ($ids)";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <link rel="stylesheet" href="style_cart.css">
    <script>
function changeQty(id, delta) {
    const qtySpan = document.getElementById('qty-' + id);
    let qty = parseInt(qtySpan.innerText);
    qty += delta;
    if (qty < 1) qty = 1;
    qtySpan.innerText = qty;
}
</script>

</head>
<body>
<body>
<div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 20px;">
    <!-- Kiri: Icon rumah -->
    <a href="../1landingpage.php" style="flex: 1;">
        <img src="../img/home-icon.png" alt="Home" style="width: 30px; height: 30px;">
    </a>

    <!-- Tengah: Judul -->
    <div style="flex: 2; text-align: center;">
        <h1 style="margin: 0;">Keranjang</h1>
    </div>

    <!-- Kanan: Kosong (agar judul tetap di tengah) -->
    <div style="flex: 1;"></div>
</div>


<div class="cart-container">
    <?php if (empty($products)) : ?>
        <p style="text-align:center;">Keranjang kosong. <a href="../1landingpage.php">Belanja sekarang</a></p>
    <?php else : ?>
        <?php
        foreach ($products as $product) :
            $id = $product['product_id'];
            $qty = $cart[$id]; // permasalahan
            $price = $product['price'];
        ?>
        <div class="cart-item">
            <img src="../img/<?= $product['gambar']; ?>" alt="<?= $product['nama']; ?>">
            <div class="item-info">
                <h3><?= $product['nama']; ?></h3>
                <p>Rp <?= number_format($price, 0, ',', '.'); ?></p>
            </div>
            <div class="quantity-controls">
                <button type="button" onclick="changeQty(<?= $id ?>, -1)">−</button>
                <span id="qty-<?= $id ?>"><?= $qty ?></span>
                <button type="button" onclick="changeQty(<?= $id ?>, 1)">+</button>
            </div>


            <form method="post" action="remove_from_cart.php" style="margin:0;">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <button type="submit" class="remove-btn">🗑️</button>
            </form>
        </div>
        <?php endforeach; ?>

        <div class="checkout-section">
            <form action="checkout.php" method="post">
                <button type="submit">Checkout</button>
            </form>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
