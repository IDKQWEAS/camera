<?php
session_start();

$response = [
    'success' => false,
    'message' => 'Gagal menambahkan produk, ID tidak ditemukan.'
];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Silakan login terlebih dahulu untuk menambahkan produk.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    } else {
        $_SESSION['cart'][$product_id]++;
    }

    $response['success'] = true;
    $response['message'] = 'Produk berhasil ditambahkan ke keranjang!';
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>