<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

$sql_comments = "SELECT * FROM komentarfoto";
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
        </tbody>
    </table>
</div>

</body>
</html>
