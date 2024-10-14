<?php  
session_start();
include_once("config/koneksi.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$currentUserID = $_SESSION['UserID']; 

if (!isset($_GET['AlbumID'])) {
    header("Location: public/foto/view/foto.php");
    exit();
}

// Mengamankan input AlbumID
$albumID = mysqli_real_escape_string($kon, $_GET['AlbumID']);
$query = "SELECT * FROM foto WHERE AlbumID = '$albumID'";
$ambildata = mysqli_query($kon, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gambar Album</title>
    <link rel="stylesheet" href="style/album.css">
</head>
<body>

<div class="container">
    <h1 class="page-title">Gambar dalam Album</h1>

    <div class="action-menu">
        <a href="index.php" class="btn back-btn">Back</a>
    </div>

    <div class="gallery">
        <?php  
        if (mysqli_num_rows($ambildata) > 0) {
            while ($row = mysqli_fetch_array($ambildata)) {
                echo "<div class='gallery-item'>";
                // Menggunakan path yang benar untuk LokasiFile
                echo "<img class='gallery-image' src='public/foto/aset/" . htmlspecialchars($row['LokasiFile']) . "' alt='" . htmlspecialchars($row['JudulFoto']) . "'>";
                echo "<div class='info'>";
                echo "<h3 class='image-title'>" . htmlspecialchars($row['JudulFoto']) . "</h3>";
                echo "<p class='image-description'>" . htmlspecialchars($row['Deskripsi']) . "</p>";
                echo "</div></div>";
            }
        } else {
            echo "<p>Tidak ada gambar dalam album ini.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
