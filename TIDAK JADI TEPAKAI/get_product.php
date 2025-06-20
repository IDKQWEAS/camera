<?php
header('Content-Type: application/json');

// Sertakan file konfigurasi database
include_once 'config.php'; // Sesuaikan path jika config.php berada di direktori lain

// $conn sudah tersedia dari config.php

// Periksa koneksi (walaupun sudah ada di config.php, ini bisa jadi double check)
if (!$conn) {
    die(json_encode(['error' => 'Koneksi database gagal.']));
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Siapkan kueri SQL
// Mengambil 'product_id', 'nama', 'price', dan 'gambar' dari tabel 'product'
if ($searchTerm) {
    $stmt = $conn->prepare("SELECT product_id, nama, price, gambar FROM product WHERE nama LIKE ? LIMIT 20");
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("s", $searchTerm);
} else {
    // Jika searchTerm kosong, tampilkan semua produk (dibatasi 20 untuk performa)
    $stmt = $conn->prepare("SELECT product_id, nama, price, gambar FROM product LIMIT 20");
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

$stmt->close();
mysqli_close($conn); // Tutup koneksi setelah selesai
?>