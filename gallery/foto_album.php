<?php  
session_start();
include_once("config/koneksi.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$currentUserID = $_SESSION['UserID']; 

if (!isset($_GET['AlbumID'])) {
    header("Location: foto_album.php");
    exit();
}

$albumID = mysqli_real_escape_string($kon, $_GET['AlbumID']);
$query = "SELECT * FROM foto WHERE AlbumID = '$albumID'";
$ambildata = mysqli_query($kon, $query);

if (!$ambildata) {
    die("Query Failed: " . mysqli_error($kon));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['isikomentar'])) {
    $fotoID = mysqli_real_escape_string($kon, $_POST['fotoid']);
    $komentarIsi = mysqli_real_escape_string($kon, $_POST['isikomentar']);
    $tanggalKomentar = date('Y-m-d H:i:s');

    $insertKomentar = "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar) VALUES ('$fotoID', '$currentUserID', '$komentarIsi', '$tanggalKomentar')";
    mysqli_query($kon, $insertKomentar);

    header("Location: " . $_SERVER['PHP_SELF'] . "?AlbumID=" . $albumID);
    exit();
}
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

                echo "<div class='gallery-item'>";
                echo "<img class='gallery-image' src='public/foto/aset/" . htmlspecialchars($row['LokasiFile']) . "' alt='" . htmlspecialchars($row['JudulFoto']) . "'>";
                echo "<a href='public/foto/aset/" . htmlspecialchars($row['LokasiFile']) . "' class='save-button' download>Save</a>";
                echo "<div class='info'>";
                echo "<h3 class='image-title'>" . htmlspecialchars($row['JudulFoto']) . "</h3>";

                $deskripsi = htmlspecialchars($row['Deskripsi']);
                echo "<p class='image-description'>";
                echo "<span class='full-description'>" . $deskripsi . "</span>";
                echo "<span class='short-description' style='display:none;'>" . implode(' ', array_slice(explode(' ', $deskripsi), 0, 5)) . "...</span>";
                echo "</p>";
                echo "<a href='#' class='show-more' onclick='toggleDescription(this); return false;'>Show More</a>";

                $likeCountQuery = "SELECT COUNT(*) AS likeCount FROM likefoto WHERE FotoID = '$fotoID'";
                $likeCountResult = mysqli_query($kon, $likeCountQuery);
                $likeCount = mysqli_fetch_assoc($likeCountResult)['likeCount'];

                $userLikedQuery = "SELECT COUNT(*) AS userLiked FROM likefoto WHERE FotoID = '$fotoID' AND UserID = '$currentUserID'";
                $userLikedResult = mysqli_query($kon, $userLikedQuery);
                $userLiked = mysqli_fetch_assoc($userLikedResult)['userLiked'] > 0;

                echo "<div class='like-section'>";
                echo "<a href='public/foto/view/like.php?fotoid=$fotoID' class='like-button' onclick=\"event.preventDefault(); likeFoto('$fotoID')\">";
                echo "<i class='fas " . ($userLiked ? 'fa-thumbs-down' : 'fa-thumbs-up') . "'></i>";
                echo "<span class='like-text'>" . ($userLiked ? 'Unlike' : 'Like') . "</span></a>";
                echo "<span id='likeCount_$fotoID'>$likeCount</span> Likes";
                echo "</div>";

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

                    const likeButton = document.querySelector(`.like-button[href*='${fotoID}']`);
                    const likeText = likeButton.querySelector('.like-text');
                    const likeIcon = likeButton.querySelector('.fas');

                    likeText.innerHTML = response.userLiked ? 'Unlike' : 'Like';
                    likeIcon.classList.toggle('fa-thumbs-up', !response.userLiked);
                    likeIcon.classList.toggle('fa-thumbs-down', response.userLiked);
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };
        xhr.send('fotoid=' + fotoID);
    }

    function toggleDescription(link) {
        const fullDescription = link.previousElementSibling.firstElementChild; 
        const shortDescription = link.previousElementSibling.lastElementChild; 

        if (fullDescription.style.display === "none") {
            fullDescription.style.display = "block"; 
            shortDescription.style.display = "none"; 
            link.textContent = "Show Less"; 
        } else {
            fullDescription.style.display = "none"; 
            shortDescription.style.display = "inline"; 
            link.textContent = "Show More"; 
        }
    }
</script>

</body>
</html>
