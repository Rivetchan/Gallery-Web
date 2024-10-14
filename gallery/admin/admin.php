<?php
session_start();
include_once("../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['Username'];
$sql_admin = "SELECT * FROM user WHERE Username = '$username'";
$result_admin = $kon->query($sql_admin);
$admin_data = $result_admin->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>Welcome, <?php echo $admin_data['NamaLengkap']; ?>!</h1>
    <p>Use the navigation above to manage users, albums, photos, comments, and likes.</p>

    <div class="dashboard-info">
        <h2>Admin Information</h2>
        <table>
            <tr>
                <th>Username</th>
                <td><?php echo $admin_data['Username']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $admin_data['Email']; ?></td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td><?php echo $admin_data['NamaLengkap']; ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo $admin_data['Alamat']; ?></td>
            </tr>
        </table>
    </div>

    <div class="dashboard-stats">
        <?php
        $sql_users = "SELECT COUNT(*) AS total_users FROM user";
        $result_users = $kon->query($sql_users);
        $total_users = $result_users->fetch_assoc()['total_users'];

        $sql_albums = "SELECT COUNT(*) AS total_albums FROM album";
        $result_albums = $kon->query($sql_albums);
        $total_albums = $result_albums->fetch_assoc()['total_albums'];

        $sql_photos = "SELECT COUNT(*) AS total_photos FROM foto";
        $result_photos = $kon->query($sql_photos);
        $total_photos = $result_photos->fetch_assoc()['total_photos'];

        $sql_comments = "SELECT COUNT(*) AS total_comments FROM komentarfoto";
        $result_comments = $kon->query($sql_comments);
        $total_comments = $result_comments->fetch_assoc()['total_comments'];

        $sql_likes = "SELECT COUNT(*) AS total_likes FROM likefoto";
        $result_likes = $kon->query($sql_likes);
        $total_likes = $result_likes->fetch_assoc()['total_likes'];
        ?>

        <div class="stats">
            <h3>Total Users: <?php echo $total_users; ?></h3>
            <h3>Total Albums: <?php echo $total_albums; ?></h3>
            <h3>Total Photos: <?php echo $total_photos; ?></h3>
            <h3>Total Comments: <?php echo $total_comments; ?></h3>
            <h3>Total Likes: <?php echo $total_likes; ?></h3>
        </div>
    </div>
</div>

</body>
</html>
