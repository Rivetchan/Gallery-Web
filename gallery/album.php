<?php  
session_start();
include_once("config/koneksi.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$currentUserID = $_SESSION['UserID']; 

if (isset($_GET['album'])) {
    $albumName = mysqli_real_escape_string($kon, $_GET['album']);

    $query = "SELECT album.*, user.Username 
              FROM album 
              JOIN user ON album.UserID = user.UserID
              WHERE album.NamaAlbum = '$albumName'
              AND album.UserID = '$currentUserID'
              LIMIT 1"; 
              
    $ambildata = mysqli_query($kon, $query);
    
    if (mysqli_num_rows($ambildata) > 0) {
        $album = mysqli_fetch_array($ambildata);
    } else {
        echo "Album tidak ditemukan.";
        exit();
    }
} else {
    echo "Nama album tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Album - <?php echo htmlspecialchars($album['NamaAlbum']); ?></title>
    <link rel="stylesheet" href="../css/album.css">
</head>
<body>

<div class="container">
    <h1 class="page-title"><?php echo htmlspecialchars($album['NamaAlbum']); ?></h1>
    <p>Deskripsi: <?php echo htmlspecialchars($album['Deskripsi']); ?></p>
    <p>Tanggal Dibuat: <?php echo htmlspecialchars($album['TanggalDibuat']); ?></p>
    <p>Username: <?php echo htmlspecialchars($album['Username']); ?></p>

    <div class="album-images">
    </div>
</div>

</body>
</html>
