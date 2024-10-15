<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Inisialisasi variabel pencarian
$search_comment_id = "";
$search_user_id = "";

// Cek apakah form pencarian di-submit
if (isset($_GET['search_comment_id']) || isset($_GET['search_user_id'])) {
    $search_comment_id = isset($_GET['search_comment_id']) ? intval($_GET['search_comment_id']) : "";
    $search_user_id = isset($_GET['search_user_id']) ? intval($_GET['search_user_id']) : "";

    // Bangun query berdasarkan input yang diberikan
    $sql_comments = "SELECT * FROM komentarfoto WHERE 1=1";

    if (!empty($search_comment_id)) {
        $sql_comments .= " AND KomentarID = $search_comment_id";
    }

    if (!empty($search_user_id)) {
        $sql_comments .= " AND UserID = $search_user_id";
    }

} else {
    // Jika tidak ada pencarian, tampilkan semua komentar
    $sql_comments = "SELECT * FROM komentarfoto";
}

$result_comments = $kon->query($sql_comments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments</title>
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>Manage Comments</h1>

    <!-- Form Pencarian Komentar Berdasarkan KomentarID dan UserID -->
    <form method="GET" action="">
        <input type="number" name="search_comment_id" placeholder="Cari Komentar ID" value="<?php echo htmlspecialchars($search_comment_id); ?>">
        <input type="number" name="search_user_id" placeholder="Cari User ID" value="<?php echo htmlspecialchars($search_user_id); ?>">
        <button type="submit">Cari</button>
        <a href="manage_comments.php">Reset</a> <!-- Tombol untuk reset pencarian -->
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto ID</th>
                <th>User ID</th>
                <th>Isi Komentar</th>
                <th>Tanggal Komentar</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_comments->num_rows > 0): ?>
                <?php while($comment = $result_comments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $comment['KomentarID']; ?></td>
                    <td><?php echo $comment['FotoID']; ?></td>
                    <td><?php echo $comment['UserID']; ?></td>
                    <td><?php echo $comment['IsiKomentar']; ?></td>
                    <td><?php echo $comment['TanggalKomentar']; ?></td>
                    <td>
                        <a href="komentar/delete_komentar.php?id=<?php echo $comment['KomentarID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No comments found with the given criteria.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
