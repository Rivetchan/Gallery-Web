<?php
session_start();
include_once('../../../config/koneksi.php');

if (!isset($_SESSION['UserID'])) {
    header("Location: ../../../login.php");
    exit();
}

$UserID = $_SESSION['UserID'];

// Fetch user data
$sql = "SELECT * FROM user WHERE UserID = '$UserID'";
$result = $kon->query($sql);

if (!$result) {
    die("Query Error: " . $kon->error);
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/profile.css">
    <title>Profil Pengguna</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="../../../index.php">Gallery</a>
        </div>
        <div class="nav">
            <a href="../../../index.php">Home</a>
            <a href="../../album/view/album.php">Album</a>
            <a href="../../foto/view/foto.php">Galeri Foto</a>
            <a href="edit_password.php">Edit Password</a>
            <a href="../../../logout.php">Logout</a>
        </div>
    </div>

    <div class="content">
        <h2>Profil Pengguna</h2>
        <div class="profile-info">
            <div class="profile-picture">
                <img src="../aset/<?php echo htmlspecialchars($user['FotoUser']); ?>" alt="Profile Picture">
                <form action="upload_foto.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="foto" accept="image/*">
                    <button type="submit">Ganti Foto Profil</button>
                </form>
            </div>
            <div class="info">
                <p><strong>Nama Pengguna :</strong> <?php echo htmlspecialchars($user['Username']); ?></p>
                <p><strong>Nama Lengkap :</strong> <?php echo htmlspecialchars($user['NamaLengkap']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
                <p><strong>Alamat :</strong> <?php echo htmlspecialchars($user['Alamat']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
