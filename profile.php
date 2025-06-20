<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_message'] = "Anda harus login terlebih dahulu untuk melihat profil.";

    header("Location: signin.php");
    exit(); 
}
$user_id = $_SESSION['user_id'];
$query = "SELECT username, email, address, phone_number, profile_picture FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
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
            overflow: hidden; 
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            border-radius: 50%;
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

        .profile-form input[type="text"],
        .profile-form input[type="email"],
        .profile-form input[type="number"],
        .profile-form input[type="file"] {
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
        
        .profile-form input[readonly] {
            background-color: #e0bb7d;
            cursor: not-allowed;
        }


        .profile-buttons {
            margin-top: 20px;
            display: flex;
            gap: 15px;
        }

        .profile-buttons button,
        .profile-buttons a {
            flex: 1;
            background-color: #fef9e1;
            color: #6d2323;
            border: none; 
            border-radius: 15px;
            padding: 12px 0;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s;
            box-sizing: border-box; 
        }

        .profile-buttons button:hover,
        .profile-buttons a:hover {
            background-color: #e8e0c4;
        }

        .message {
            color: #fef9e1;
            background-color: rgba(0, 128, 0, 0.7);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .error-message {
            background-color: rgba(255, 0, 0, 0.7);
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-picture">
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Gambar Profil">
            <?php else: ?>
                <i class="fa-regular fa-user"></i>
            <?php endif; ?>
        </div>
        <form class="profile-form" action="update_users.php" method="POST" enctype="multipart/form-data">
            <h1>Update Profil</h1>

            <?php if (!empty($message)): ?>
                <p class="message <?php echo strpos($message, 'berhasil') !== false ? '' : 'error-message'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </p>
            <?php endif; ?>

            <label for="username">Nama Pengguna:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" readonly> <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly> <label for="address">Alamat:</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>">

            <label for="phone_number">Nomor Telepon:</label>
            <input type="number" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>" min="0" step="1">

            <label for="profile_image">Unggah Gambar Profil:</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">

            <div class="profile-buttons">
    <button type="submit" name="submit_profile">Perbarui </button>
    <a href="1landingpage.php">Kembali</a>
    <a href="logout.php" >Logout</a>
</div>

            </div>
        </form>
    </div>
</body>
</html>