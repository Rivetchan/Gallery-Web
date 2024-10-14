<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

$sql_likes = "SELECT * FROM likefoto";
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
        </tbody>
    </table>
</div>

</body>
</html>
