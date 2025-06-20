<?php
header('Content-Type: application/json');

include_once 'config.php'; 


if (!$conn) {
    die(json_encode(['error' => 'Koneksi database gagal.']));
}

$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

$sql = "SELECT product_id, nama, price, gambar FROM product WHERE nama LIKE '%$q%' LIMIT 10";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);

?>