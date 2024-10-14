<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

$sql_photos = "SELECT * FROM foto";
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
                    <a href="foto/delete_photo.php?id=<?php echo $photo['FotoID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
