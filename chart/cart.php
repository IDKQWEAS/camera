<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_message'] = "Anda harus login terlebih dahulu untuk melihat keranjang.";
    $_SESSION['redirect_to'] = 'chart/cart.php';
    header("Location: ../signin.php");
    exit();
}



$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$productIds = array_keys($cart);
$products = [];

if (!empty($productIds)) {
    $ids = implode(",", array_map('intval', $productIds));
    $query = "SELECT * FROM product WHERE product_id IN ($ids)";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
}

$payment_methods = [];
$payment_query = "SELECT * FROM payment_methods WHERE is_active = 1";
$payment_result = mysqli_query($conn, $payment_query);
if ($payment_result) {
    while ($row = mysqli_fetch_assoc($payment_result)) {
        $payment_methods[] = $row;
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($action === 'increment' && isset($cart[$id])) {
        $cart[$id]++;
    } elseif ($action === 'decrement' && isset($cart[$id]) && $cart[$id] > 1) {
        $cart[$id]--;
    }
    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="style_cart.css">
    <style>
        button:disabled {
            background-color: #e0e0e0 !important;
            color: #a0a0a0 !important;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 20px;">
    <a href="../1landingpage.php" style="flex: 1;"><img src="../img/home-icon.png" alt="Home" style="width: 30px; height: 30px;"></a>
    <div style="flex: 2; text-align: center;"><h1 style="margin: 0;">Keranjang</h1></div>
    <div style="flex: 1;"></div>
</div>

<form id="cartForm" action="checkout.php" method="post">

    <?php if (isset($_SESSION['checkout_message'])): ?>
        <div class="checkout-message <?= $_SESSION['checkout_message']['type']; ?>">
            <?= htmlspecialchars($_SESSION['checkout_message']['text']); ?>
        </div>
        <?php unset($_SESSION['checkout_message']); ?>
    <?php endif; ?>

    <div class="cart-container">
        <?php if (empty($products) && empty($cart)) : ?>
            <p style="text-align:center;">Keranjang kosong. <a href="../1landingpage.php">Belanja sekarang</a></p>
        <?php else : ?>
            <?php
            $total = 0;
            foreach ($products as $product) :
                if (!isset($cart[$product['product_id']])) continue;

                $id = $product['product_id'];
                $qty = $cart[$id];
                $price = $product['price'];
                $subtotal = $qty * $price;
                $total += $subtotal;
            ?>
            <div class="cart-item">
                <div class="item-selection">
                    <input type="checkbox" name="selected_products[]" value="<?= $id; ?>" class="product-checkbox">
                </div>
                
                <img src="../img/<?= htmlspecialchars($product['gambar']); ?>" alt="<?= htmlspecialchars($product['nama']); ?>">
                <div class="item-info">
                    <h3><?= htmlspecialchars($product['nama']); ?></h3>
                    <p>Rp <?= number_format($price, 0, ',', '.'); ?></p>
                    <p style="font-size: 14px; color: gray;">Subtotal: Rp <?= number_format($subtotal, 0, ',', '.'); ?></p>
                </div>
                <div class="quantity-controls">
                    <form action="cart.php?action=decrement" method="post" style="display:inline;"><input type="hidden" name="id" value="<?= $id; ?>"><button type="submit" formmethod="post">-</button></form>
                    <span><?= $qty ?></span>
                    <form action="cart.php?action=increment" method="post" style="display:inline;"><input type="hidden" name="id" value="<?= $id; ?>"><button type="submit" formmethod="post" <?= ($qty >= $product['stok_quantity']) ? 'disabled' : '' ?>>+</button></form>
                </div>
                <form method="post" action="remove_from_cart.php" style="display:inline;"><input type="hidden" name="id" value="<?= $id; ?>"><button type="submit" class="remove-btn" formmethod="post">🗑️</button></form>
            </div>
            <?php endforeach; ?>

            <div class="total-section" style="text-align:center; margin-top:20px;">
                <h3>Total Keseluruhan: Rp <?= number_format($total, 0, ',', '.'); ?></h3>
            </div>

            <div class="checkout-section">
                <div class="checkout-actions">
                    <select name="payment_method" id="paymentMethodSelect" class="payment-select" required>
                        <option value="" selected hidden>Pilih Metode Pembayaran</option>
                        <?php foreach ($payment_methods as $method) : ?>
                            <option value="<?= htmlspecialchars($method['id']); ?>"><?= htmlspecialchars($method['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" id="checkoutButton" disabled>Checkout</button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</form>

<script>
    const paymentSelect = document.getElementById('paymentMethodSelect');
    const checkoutButton = document.getElementById('checkoutButton');
    const checkboxes = document.querySelectorAll('.product-checkbox');

    function validateCheckout() {
        const isPaymentSelected = paymentSelect.value !== '';
        const isAnyProductSelected = Array.from(checkboxes).some(cb => cb.checked);
        
        checkoutButton.disabled = !(isPaymentSelected && isAnyProductSelected);
    }

    paymentSelect.addEventListener('change', validateCheckout);
    checkboxes.forEach(cb => cb.addEventListener('change', validateCheckout));

    validateCheckout();
</script>

</body>
</html>