<?php
session_start();
include 'config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

// Ambil data user berdasarkan session user_id
$query = "SELECT * FROM users WHERE user_id = $id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User tidak ditemukan.");
}

// Proses update jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape data input untuk keamanan
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $address      = mysqli_real_escape_string($conn, $_POST['address']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    // Query update data user
    $update = "UPDATE users SET 
                username = '$username',
                email = '$email',
                address = '$address',
                phone_number = '$phone_number'
               WHERE user_id = $id";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href = 'update_user.php';</script>";
        exit;
    } else {
        echo "Error updating: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #6d2323;
            font-family: Arial, sans-serif;
            color: #fef9e1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            display: flex;
            align-items: center;
            gap: 40px;
        }
        .profile-picture {
            width: 250px;
            height: 250px;
            background-color: #fef9e1;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-picture i {
            font-size: 100px;
            color: #6d2323;
        }
        .profile-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 320px;
        }
        .profile-form h1 {
            margin-bottom: 10px;
            font-size: 36px;
            font-weight: bold;
            color: #fef9e1;
        }
        .profile-form label {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
            color: #fef9e1;
            display: block;
        }
        .profile-form input {
            background-color: #fef9e1;
            color: #6d2323;
            border: none;
            padding: 12px 15px;
            border-radius: 20px;
            font-size: 16px;
            outline: none;
            width: 100%;
            box-sizing: border-box;
        }
        .profile-buttons {
            margin-top: 20px;
            display: flex;          
            gap: 15px;             
        }
        .profile-buttons button {
            flex: 1;                
            background-color: #fef9e1;
            color: #6d2323;
            border-radius: 15px;
            padding: 12px 0;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            border: none;
            transition: background 0.3s;
        }
        .profile-buttons button:hover {
            background-color: #e8e0c4;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-picture">
            <i class="fa-regular fa-user"></i>
        </div>
        <form class="profile-form" action="update_user.php" method="POST">
            <h1>Update Profile</h1>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">

            <div class="profile-buttons">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
