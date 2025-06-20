<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../signin.php');
    exit;
}

if (isset($_POST['selected_products']) && is_array($_POST['selected_products']) && !empty($_POST['selected_products'])) {
    $selected_product_ids = $_POST['selected_products'];
} else {
    $_SESSION['checkout_message'] = ['type' => 'error', 'text' => 'Anda belum memilih produk untuk di-checkout.'];
    header("Location: cart.php");
    exit();
}

if (isset($_POST['payment_method']) && !empty($_POST['payment_method'])) {
    $payment_method_id = intval($_POST['payment_method']);
} else {
    $_SESSION['checkout_message'] = ['type' => 'error', 'text' => 'Anda belum memilih metode pembayaran.'];
    header("Location: cart.php");
    exit();
}


mysqli_begin_transaction($conn);

try {
    $total_amount = 0;
    $products_to_checkout = [];
    $ids_placeholder = implode(',', array_fill(0, count($selected_product_ids), '?'));
    $types = str_repeat('i', count($selected_product_ids));
    
    $query_products = "SELECT product_id, price, stok_quantity, nama FROM product WHERE product_id IN ($ids_placeholder)";
    $stmt_products = mysqli_prepare($conn, $query_products);
    mysqli_stmt_bind_param($stmt_products, $types, ...$selected_product_ids);
    mysqli_stmt_execute($stmt_products);
    $result_products = mysqli_stmt_get_result($stmt_products);

    while ($product = mysqli_fetch_assoc($result_products)) {
        $qty_in_cart = $_SESSION['cart'][$product['product_id']];
        
        if ($product['stok_quantity'] < $qty_in_cart) {
            throw new Exception("Stok untuk produk '". $product['nama'] ."' tidak cukup.");
        }
        
        $products_to_checkout[] = [
            'id' => $product['product_id'],
            'price' => $product['price'],
            'qty' => $qty_in_cart
        ];
        $total_amount += $product['price'] * $qty_in_cart;
    }
    mysqli_stmt_close($stmt_products);

    
    $user_id = $_SESSION['user_id'];
    $status = 'Pending'; 
    $order_date = date('Y-m-d H:i:s'); 

    $insert_order_query = "INSERT INTO orders (user_id, payment_method_id, order_date, total_amount, status) VALUES (?, ?, ?, ?, ?)";
    $stmt_order = mysqli_prepare($conn, $insert_order_query);
    mysqli_stmt_bind_param($stmt_order, "iisis", $user_id, $payment_method_id, $order_date, $total_amount, $status);
    mysqli_stmt_execute($stmt_order);
    $new_order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt_order);


    foreach ($products_to_checkout as $item) {
        $insert_item_query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt_item = mysqli_prepare($conn, $insert_item_query);
        mysqli_stmt_bind_param($stmt_item, "iiid", $new_order_id, $item['id'], $item['qty'], $item['price']);
        mysqli_stmt_execute($stmt_item);
        mysqli_stmt_close($stmt_item);

    }


    mysqli_commit($conn);

    foreach ($selected_product_ids as $id) {
        unset($_SESSION['cart'][intval($id)]);
    }

    $_SESSION['checkout_message'] = ['type' => 'success', 'text' => 'Checkout berhasil! Pesanan Anda (ID: #'.$new_order_id.') sedang diproses.'];
    header('Location: cart.php');
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    $_SESSION['checkout_message'] = ['type' => 'error', 'text' => 'Checkout gagal: ' . $e->getMessage()];
    header('Location: cart.php');
    exit;
}
?>