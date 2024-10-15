<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Inisialisasi variabel pencarian
$search_judul = "";
$search_user_id = "";

// Cek apakah form pencarian di-submit
if (isset($_GET['search_judul']) || isset($_GET['search_user_id'])) {
    $search_judul = isset($_GET['search_judul']) ? $_GET['search_judul'] : "";
    $search_user_id = isset($_GET['search_user_id']) ? intval($_GET['search_user_id']) : "";

    // Bangun query berdasarkan input yang diberikan
    $sql_photos = "SELECT * FROM foto WHERE 1=1";

    if (!empty($search_judul)) {
        $sql_photos .= " AND JudulFoto LIKE '%$search_judul%'";
    }

    if (!empty($search_user_id)) {
        $sql_photos .= " AND UserID = $search_user_id";
    }

} else {
    // Jika tidak ada pencarian, tampilkan semua foto
    $sql_photos = "SELECT * FROM foto";
}

$result_photos = $kon->query($sql_photos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Photos</title>
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>Manage Photos</h1>

    <!-- Form Pencarian Foto Berdasarkan Judul dan User ID -->
    <form method="GET" action="">
        <input type="text" name="search_judul" placeholder="Cari Judul Foto" value="<?php echo htmlspecialchars($search_judul); ?>">
        <input type="number" name="search_user_id" placeholder="Cari User ID" value="<?php echo htmlspecialchars($search_user_id); ?>">
        <button type="submit">Cari</button>
        <a href="manage_photos.php">Reset</a> <!-- Tombol untuk reset pencarian -->
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Foto</th>
                <th>Deskripsi</th>
                <th>Tanggal Unggah</th>
                <th>Lokasi File</th>
                <th>Album ID</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_photos->num_rows > 0): ?>
                <?php while($photo = $result_photos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $photo['FotoID']; ?></td>
                    <td><?php echo $photo['JudulFoto']; ?></td>
                    <td><?php echo $photo['Deskripsi']; ?></td>
                    <td><?php echo $photo['TanggalUnggah']; ?></td>
                    <td><?php echo $photo['LokasiFile']; ?></td>
                    <td><?php echo $photo['AlbumID']; ?></td>
                    <td><?php echo $photo['UserID']; ?></td>
                    <td>
                        <a href="foto/edit_photo.php?id=<?php echo $photo['FotoID']; ?>">Edit</a>
                        <a href="foto/delete.php?id=<?php echo $photo['FotoID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No photos found with the given criteria.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
