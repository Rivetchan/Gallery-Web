<?php
session_start();
include_once("../config/koneksi.php");

// Cek apakah pengguna sudah login dan levelnya admin (1)
if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

$sql_users = "SELECT * FROM user";
$result_users = $kon->query($sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="css/admin.css" rel="stylesheet">
    <style>
        /* CSS untuk transisi tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            transition: all 0.3s ease; /* Transisi untuk semua perubahan */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1; /* Efek hover pada baris */
            transform: scale(1.01); /* Efek transisi saat hover */
        }

        a {
            margin-right: 10px;
            text-decoration: none;
            color: blue;
            transition: color 0.3s; /* Transisi untuk warna link */
        }

        a:hover {
            color: darkblue; /* Warna saat hover link */
        }
    </style>
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>Manage Users</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = $result_users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['UserID']; ?></td>
                <td><?php echo $user['Username']; ?></td>
                <td><?php echo $user['Email']; ?></td>
                <td><?php echo $user['NamaLengkap']; ?></td>
                <td><?php echo $user['Alamat']; ?></td>
                <td>
                    <a href="user/edit_user.php?id=<?php echo $user['UserID']; ?>">Edit</a>
                    <a href="user/delete_user.php?id=<?php echo $user['UserID']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
