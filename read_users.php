<?php
include 'config.php';
$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Users</title>
    <style>
        body {
            background-color: #6d2323;
            font-family: Arial, sans-serif;
            color: #fef9e1;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #fef9e1;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
            background-color: #fef9e1;
            color: #6d2323;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #6d2323;
            text-align: left;
        }

        th {
            background-color: #e0bb7d;
        }

        tr:nth-child(even) {
            background-color: #fff3d4;
        }

        tr:hover {
            background-color: #ffe6a7;
        }

        a {
            color: #6d2323;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #fef9e1;
            background-color: #6d2323;
            border: 2px solid #fef9e1;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            transition: 0.3s;
        }

        .back-link a:hover {
            background-color: #5a1d1d;
            border-color: #fff3d4;
        }
    </style>
</head>
<body>
    <h1>Data Users</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $row['user_id']; ?></td>
                <td><?= $row['username']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['address']; ?></td>
                <td><?= $row['phone_number']; ?></td>
                <td>
                    <a href="update_users.php?id=<?= $row['user_id']; ?>">Edit</a> |
                    <a href="delete_users.php?id=<?= $row['user_id']; ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="back-link">
        <a href="profile.php">Kembali </a>
    </div>
</body>
</html>
