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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/> 
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
                $fotoID = $row['FotoID'];

                // Menggunakan path yang benar untuk LokasiFile
                echo "<div class='gallery-item'>";
                echo "<img class='gallery-image' src='public/foto/aset/" . htmlspecialchars($row['LokasiFile']) . "' alt='" . htmlspecialchars($row['JudulFoto']) . "'>";
                echo "<div class='info'>";
                echo "<h3 class='image-title'>" . htmlspecialchars($row['JudulFoto']) . "</h3>";
                echo "<p class='image-description'>" . htmlspecialchars($row['Deskripsi']) . "</p>";
                
                // Menampilkan jumlah like
                $likeCountQuery = "SELECT COUNT(*) AS likeCount FROM likefoto WHERE FotoID = '$fotoID'";
                $likeCountResult = mysqli_query($kon, $likeCountQuery);
                $likeCount = mysqli_fetch_assoc($likeCountResult)['likeCount'];

                // Menampilkan status like user
                $userLikedQuery = "SELECT COUNT(*) AS userLiked FROM likefoto WHERE FotoID = '$fotoID' AND UserID = '$currentUserID'";
                $userLikedResult = mysqli_query($kon, $userLikedQuery);
                $userLiked = mysqli_fetch_assoc($userLikedResult)['userLiked'] > 0;

                echo "<div class='like-section'>";
                echo "<a href='public/foto/view/like.php?fotoid=$fotoID' class='like-button' onclick=\"event.preventDefault(); likeFoto('$fotoID')\">";
                echo "<span class='like-text'>" . ($userLiked ? 'Unlike' : 'Like') . "</span></a>";
                echo "<span id='likeCount_$fotoID'>$likeCount</span> Likes";
                echo "</div>";

                // Mengambil komentar untuk foto ini
                $komentarSql = "SELECT k.*, u.Username FROM komentarfoto k 
                                JOIN user u ON k.UserID = u.UserID 
                                WHERE k.FotoID = '$fotoID' 
                                ORDER BY k.TanggalKomentar DESC";
                $komentarResult = mysqli_query($kon, $komentarSql);

                if ($komentarResult && mysqli_num_rows($komentarResult) > 0) {
                    echo "<div class='comment-section'>";
                    echo "<h4>Komentar:</h4>";
                    while ($komentar = mysqli_fetch_assoc($komentarResult)) {
                        echo "<p><strong>" . htmlspecialchars($komentar['Username']) . ":</strong> " . htmlspecialchars($komentar['IsiKomentar']) . " <em>(" . htmlspecialchars($komentar['TanggalKomentar']) . ")</em></p>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='comment-section'><p>Belum ada komentar.</p></div>";
                }

                echo "<div class='add-comment'>";
                echo "<form action='tambah_komentar.php' method='POST'>";
                echo "<input type='hidden' name='fotoid' value='" . $row['FotoID'] . "'>";
                echo "<textarea name='isikomentar' placeholder='Tambahkan komentar...' required></textarea>";
                echo "<button type='submit'>Kirim</button>";
                echo "</form>";
                echo "</div>";

                echo "</div></div>";
            }
        } else {
            echo "<p>Tidak ada gambar dalam album ini.</p>";
        }
        ?>
    </div>
</div>

<script>
    function likeFoto(fotoID) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'public/foto/view/like.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    const likeCountElement = document.getElementById('likeCount_' + fotoID);
                    likeCountElement.textContent = response.likeCount;

                    // Mengubah teks button like
                    const likeButton = document.querySelector(`.like-button[href*='${fotoID}']`);
                    const likeText = likeButton.querySelector('.like-text');
                    likeText.innerHTML = response.userLiked ? 'Unlike' : 'Like';
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        xhr.send('fotoid=' + fotoID);
    }
</script>

</body>
</html>
