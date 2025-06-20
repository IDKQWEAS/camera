<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$message = 'salah kawan'; 

$stmt_select = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
$stmt_select->bind_param("i", $user_id);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
$user_data = $result_select->fetch_assoc();
$old_profile_picture = $user_data['profile_picture'] ?? null; 
$stmt_select->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_profile'])) {
    $address = $_POST['address'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';

    
    $update_fields = [];
    $bind_types = "";
    $bind_params = [];

    if (!empty(trim($address))) {
        $update_fields[] = "address = ?";
        $bind_types .= "s";
        $bind_params[] = $address;
    }

    if (!empty(trim($phone_number))) {
        $update_fields[] = "phone_number = ?";
        $bind_types .= "s";
        $bind_params[] = $phone_number;
    }

    $profile_picture_path = $old_profile_picture; 
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['profile_image']['name'];
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpeg", "jpg", "png", "gif");

        if (in_array($file_ext, $allowed_extensions) === false) {
            $message = "Ekstensi file tidak diizinkan. Silakan unggah file JPG, JPEG, PNG, atau GIF.";
            $_SESSION['message'] = $message;
            header("Location: profile.php");
            exit();
        }

        if ($file_size > 2097152) { 
            $message = "Ukuran file terlalu besar. Maksimal 2MB.";
            $_SESSION['message'] = $message;
            header("Location: profile.php");
            exit();
        }

        $upload_dir = "images/"; 
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); 
        }

        
        $new_file_name = uniqid('profile_', true) . '.' . $file_ext;
        $destination = $upload_dir . $new_file_name;
        $profile_picture_path = $destination; 

        if (move_uploaded_file($file_tmp, $destination)) {
            if (!empty($old_profile_picture) && file_exists($old_profile_picture)) {
                unlink($old_profile_picture); 
            }
            $message = "Gambar profil berhasil diunggah. ";
            $update_fields[] = "profile_picture = ?";
            $bind_types .= "s";
            $bind_params[] = $profile_picture_path;
        } else {
            $message = "Gagal mengunggah gambar. ";
        }
    }

    if (!empty($update_fields)) {
        $sql_query = "UPDATE users SET " . implode(", ", $update_fields) . " WHERE user_id = ?";
        $bind_types .= "i"; 
        $bind_params[] = $user_id; 

        $stmt = $conn->prepare($sql_query);
        
        call_user_func_array([$stmt, 'bind_param'], array_merge([$bind_types], $bind_params));

        if ($stmt->execute()) {
            $message .= "Data profil berhasil diperbarui!";
            $_SESSION['message'] = $message; 
        } else {
            $message = "Error saat memperbarui data: " . htmlspecialchars($stmt->error);
            $_SESSION['message'] = $message; 
        }
        $stmt->close();
    } else {
        if (empty($message)) { 
            $message = "Tidak ada perubahan yang dilakukan.";
        }
        $_SESSION['message'] = $message;
    }

    header("Location: profile.php");
    exit();
} else {
    header("Location: profile.php");
    exit();
}
?>