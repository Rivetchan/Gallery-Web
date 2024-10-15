<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Inisialisasi variabel pencarian
$search_username = "";
$search_email = "";

// Cek apakah form pencarian di-submit
if (isset($_GET['search_username']) || isset($_GET['search_email'])) {
    $search_username = isset($_GET['search_username']) ? $_GET['search_username'] : "";
    $search_email = isset($_GET['search_email']) ? $_GET['search_email'] : "";

    // Bangun query berdasarkan input yang diberikan
    $sql_users = "SELECT * FROM user WHERE 1=1";

    if (!empty($search_username)) {
        $sql_users .= " AND Username LIKE '%$search_username%'";
    }

    if (!empty($search_email)) {
        $sql_users .= " AND Email LIKE '%$search_email%'";
    }

} else {
    // Jika tidak ada pencarian, tampilkan semua user
    $sql_users = "SELECT * FROM user";
}

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
        table {
            width: 100%;
            border-collapse: collapse;
            transition: all 0.3s ease;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1; 
            transform: scale(1.01);
        }

        a {
            margin-right: 10px;
            text-decoration: none;
            color: blue;
            transition: color 0.3s;
        }

        a:hover {
            color: darkblue;
        }
    </style>
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>Manage Users</h1>

    <!-- Form Pencarian Berdasarkan Username dan Email -->
    <form method="GET" action="">
        <input type="text" name="search_username" placeholder="Cari Username" value="<?php echo htmlspecialchars($search_username); ?>">
        <input type="text" name="search_email" placeholder="Cari Email" value="<?php echo htmlspecialchars($search_email); ?>">
        <button type="submit">Cari</button>
        <a href="manage_users.php">Reset</a> <!-- Tombol untuk reset pencarian -->
    </form>

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
            <?php if ($result_users->num_rows > 0): ?>
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
            <?php else: ?>
                <tr>
                    <td colspan="6">No users found with the given criteria.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
