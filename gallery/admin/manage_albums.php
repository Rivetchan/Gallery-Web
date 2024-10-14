<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}


$sql_albums = "SELECT * FROM album";
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
        </tbody>
    </table>
</div>
</body>
</html>
