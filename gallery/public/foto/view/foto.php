<?php 
session_start(); 
include_once('../../../config/koneksi.php'); 

if (!isset($_SESSION['UserID'])) { 
    header("Location: ../../../login.php"); 
    exit(); 
} 

$UserID = $_SESSION['UserID']; 

if (isset($_GET['cari'])) { 
    $cari = $_GET['cari']; 
    $sql = "SELECT f.*, u.Username, a.NamaAlbum, 
            (SELECT COUNT(*) FROM likefoto l WHERE l.FotoID = f.FotoID) AS likeCount, 
            (SELECT COUNT(*) FROM likefoto l WHERE l.FotoID = f.FotoID AND l.UserID = '$UserID') AS userLiked 
            FROM foto f 
            JOIN user u ON f.UserID = u.UserID 
            JOIN album a ON f.AlbumID = a.AlbumID 
            WHERE f.JudulFoto LIKE '%$cari%' AND f.UserID = '$UserID'"; 
} else { 
    $sql = "SELECT f.*, u.Username, a.NamaAlbum, 
            (SELECT COUNT(*) FROM likefoto l WHERE l.FotoID = f.FotoID) AS likeCount, 
            (SELECT COUNT(*) FROM likefoto l WHERE l.FotoID = f.FotoID AND l.UserID = '$UserID') AS userLiked 
            FROM foto f 
            JOIN user u ON f.UserID = u.UserID 
            JOIN album a ON f.AlbumID = a.AlbumID 
            WHERE f.UserID = '$UserID'"; 
} 

$result = $kon->query($sql); 

if (!$result) { 
    die("Query Error: " . $kon->error); 
} 
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/> 
    <link rel="stylesheet" href="../css/foto.css"> 
    <title>Galeri Foto</title> 
</head> 
<body> 
    <div class="header"> 
        <div class="logo"> 
            <a href="#" style="text-decoration: none; color: black;">Gallery</a> 
        </div>
        <div class="nav">
            <a class="active" href="../../../index.php">Home</a>
            <a href="../../album/view/album.php">Album</a>
            <a href="tambah.php">Create Foto</a>
            <button onclick="window.print();">Print Semua Foto</button>
        </div>

        <form action="foto.php" method="get" class="search-bar">
            <input type="text" name="cari" placeholder="Cari foto..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <div class="dropdown profile-logo">
            <img src="../source/user.png" alt="Logo" onclick="toggleDropdown()">
            <div id="myDropdown" class="dropdown-content">
                <a href="profile.php">Settings</a>
                <a href="../../../logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div class="content">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='pin'>";
                echo "<img src='../aset/" . $row['LokasiFile'] . "' alt='" . $row['JudulFoto'] . "'>"; 
                echo "<div class='info'>";
                echo "<p class='title'>" . $row['JudulFoto'] . "</p>";
                echo "<p class='username'>Uploaded by: " . $row['Username'] . "</p>"; 
                echo "<p class='album-name'>Album: " . $row['NamaAlbum'] . "</p>"; 
                echo "</div>";

                echo "<div class='action-buttons'>";
                echo "<a href='komentar.php' class='chat-logo'><img src='../source/comment.png' alt='Chat' class='icon'/></a>";
                echo "<a href='../aset/" . $row['LokasiFile'] . "' download class='save-button'>Save</a>";
                
                echo "</div>"; 

                echo "<div class='like-section'>";
                echo "<a href='foto.php' class='like-button' onclick=\"likeFoto(event, '" . $row['FotoID'] . "')\">";
                echo "<span class='like-text'>";
                echo ($row['userLiked'] > 0 ? 'Unlike' : 'Like');
                echo "</span></a>";
                echo "<span id='likeCount_" . $row['FotoID'] . "'>" . $row['likeCount'] . "</span> Likes";
                echo "</div>";

                $fotoID = $row['FotoID'];
                $komentarSql = "SELECT k.*, u.Username FROM komentarfoto k 
                                JOIN user u ON k.UserID = u.UserID 
                                WHERE k.FotoID = '$fotoID' 
                                ORDER BY k.TanggalKomentar DESC";
                $komentarResult = $kon->query($komentarSql);

                if ($komentarResult !== false && $komentarResult->num_rows > 0) {
                    echo "<div class='comment-section'>";
                    echo "<h4>Komentar:</h4>";
                    while($komentar = $komentarResult->fetch_assoc()) {
                        echo "<p><strong>" . $komentar['Username'] . ":</strong> " . $komentar['IsiKomentar'] . " <em>(" . $komentar['TanggalKomentar'] . ")</em></p>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='comment-section'>";
                    echo "<p>Belum ada komentar.</p>";
                    echo "</div>";
                }

                echo "<div class='add-comment'>";
                echo "<form action='tambah_komentar.php' method='POST'>";
                echo "<input type='hidden' name='fotoid' value='" . $row['FotoID'] . "'>";
                echo "<textarea name='isikomentar' placeholder='Tambahkan komentar...'></textarea>";
                echo "<button type='submit'>Kirim</button>";
                echo "</form>";
                echo "</div>";

                echo "</div>"; 
            }            
        } else {
            echo "<p>Tidak ada foto ditemukan.</p>";
        }
        ?>
    </div>

    <script> 
        function likeFoto(event, fotoID) { 
            event.preventDefault(); 
            const xhr = new XMLHttpRequest(); 
            xhr.open('POST', 'like.php', true); 
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); 

            xhr.onreadystatechange = function() { 
                if (xhr.readyState === XMLHttpRequest.DONE) { 
                    if (xhr.status === 200) { 
                        const response = JSON.parse(xhr.responseText); 
                        const likeCountElement = document.getElementById('likeCount_' + fotoID); 
                        likeCountElement.textContent = response.likeCount; 
                        const likeButton = event.target; 
                        const likeText = likeButton.querySelector('.like-text');

                        if (response.userLiked) {
                            likeText.innerHTML = "Unlike"; 
                        } else {
                            likeText.innerHTML = "Like";
                        }

                        window.location.href = 'foto.php'; 
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