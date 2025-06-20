<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan di URL.");
}

$id = (int) $_GET['id']; 

$query = "DELETE FROM users WHERE user_id = $id";

if (mysqli_query($conn, $query)) {
    header("Location: read_users.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
