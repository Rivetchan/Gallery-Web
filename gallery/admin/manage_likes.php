<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Inisialisasi variabel pencarian
$search_like_id = "";
$search_user_id = "";

// Cek apakah form pencarian di-submit
if (isset($_GET['search_like_id']) || isset($_GET['search_user_id'])) {
    $search_like_id = isset($_GET['search_like_id']) ? intval($_GET['search_like_id']) : "";
    $search_user_id = isset($_GET['search_user_id']) ? intval($_GET['search_user_id']) : "";

    // Bangun query berdasarkan input yang diberikan
    $sql_likes = "SELECT * FROM likefoto WHERE 1=1";

    if (!empty($search_like_id)) {
        $sql_likes .= " AND LikeID = $search_like_id";
    }

    if (!empty($search_user_id)) {
        $sql_likes .= " AND UserID = $search_user_id";
    }

} else {
    // Jika tidak ada pencarian, tampilkan semua like
    $sql_likes = "SELECT * FROM likefoto";
}

$result_likes = $kon->query($sql_likes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Likes</title>
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>Manage Likes</h1>

    <!-- Form Pencarian Like Berdasarkan LikeID dan UserID -->
    <form method="GET" action="">
        <input type="number" name="search_like_id" placeholder="Cari Like ID" value="<?php echo htmlspecialchars($search_like_id); ?>">
        <input type="number" name="search_user_id" placeholder="Cari User ID" value="<?php echo htmlspecialchars($search_user_id); ?>">
        <button type="submit">Cari</button>
        <a href="manage_likes.php">Reset</a> <!-- Tombol untuk reset pencarian -->
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto ID</th>
                <th>User ID</th>
                <th>Tanggal Like</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_likes->num_rows > 0): ?>
                <?php while($like = $result_likes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $like['LikeID']; ?></td>
                    <td><?php echo $like['FotoID']; ?></td>
                    <td><?php echo $like['UserID']; ?></td>
                    <td><?php echo $like['TanggalLike']; ?></td>
                    <td>
                        <a href="like/delete_like.php?id=<?php echo $like['LikeID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No likes found with the given criteria.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
