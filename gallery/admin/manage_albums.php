<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

$search_id = "";
$search_name = "";

if (isset($_GET['search_id']) || isset($_GET['search_name'])) {
    $search_id = isset($_GET['search_id']) ? intval($_GET['search_id']) : ""; 
    $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : "";

    $sql_albums = "SELECT * FROM album WHERE 1=1";

    if (!empty($search_id)) {
        $sql_albums .= " AND AlbumID = $search_id";
    }

    if (!empty($search_name)) {
        $sql_albums .= " AND NamaAlbum LIKE '%" . $kon->real_escape_string($search_name) . "%'";
    }

} else {
    $sql_albums = "SELECT * FROM album";
}

$result_albums = $kon->query($sql_albums);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Albums</title>
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>Manage Albums</h1>

    <form method="GET" action="">
        <input type="number" name="search_id" placeholder="Cari Album ID" value="<?php echo htmlspecialchars($search_id); ?>">
        <input type="text" name="search_name" placeholder="Cari Nama Album" value="<?php echo htmlspecialchars($search_name); ?>">
        <button type="submit">Cari</button>
        <a href="manage_albums.php">Reset</a> 
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Album</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_albums->num_rows > 0): ?>
                <?php while($album = $result_albums->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $album['AlbumID']; ?></td>
                    <td><?php echo $album['NamaAlbum']; ?></td>
                    <td><?php echo $album['Deskripsi']; ?></td>
                    <td><?php echo $album['TanggalDibuat']; ?></td>
                    <td>
                        <a href="album/edit_album.php?id=<?php echo $album['AlbumID']; ?>">Edit</a>
                        <a href="album/delete_album.php?id=<?php echo $album['AlbumID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No albums found with the given criteria.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
