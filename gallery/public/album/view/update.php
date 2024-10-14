<?php  
include_once("../../../config/koneksi.php");
include_once("../controller/albumupdate.php");

$albumController = new AlbumController($kon);
$message = ''; 

if (isset($_POST['update'])) {
    $AlbumID = $_POST['AlbumID'];
    $NamaAlbum = $_POST['NamaAlbum'];
    $Deskripsi = $_POST['Deskripsi'];
    $TanggalDibuat = $_POST['TanggalDibuat'];
    $UserID = $_POST['UserID'];

    $message = $albumController->updateAlbum($AlbumID, $NamaAlbum, $Deskripsi, $TanggalDibuat, $UserID);
    
    if ($message === true) {
        echo "<script>
                alert('Data album berhasil diperbarui!');
                window.location.href='album.php'; // Redirect ke halaman album
              </script>";
        exit();
    } else {
        $message = "Gagal memperbarui album: " . $message; 
    }
}

$AlbumID = null;
$NamaAlbum = null;
$Deskripsi = null;
$TanggalDibuat = null;
$UserID = null;
$Username = null;
$userDisplay = null;

if (isset($_GET['AlbumID']) && is_numeric($_GET['AlbumID'])) {
    $AlbumID = $_GET['AlbumID'];
    $result = $albumController->getDataAlbum($AlbumID);

    if ($result) {
        $AlbumID = $result['AlbumID'];
        $NamaAlbum = $result['NamaAlbum'];
        $Deskripsi = $result['Deskripsi'];
        $TanggalDibuat = $result['TanggalDibuat'];
        $UserID = $result['UserID'];

        $queryUsername = "SELECT Username FROM user WHERE UserID = '$UserID'";
        $resultUsername = mysqli_query($kon, $queryUsername);

        if ($resultUsername && mysqli_num_rows($resultUsername) > 0) {
            $rowUsername = mysqli_fetch_assoc($resultUsername);
            $Username = $rowUsername['Username'];
        } else {
            $Username = "Username tidak ditemukan";
        }


        $userDisplay = $UserID . " - " . $Username . " ";
    } else {
        echo "ID Tidak Valid.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Album</title>
    <link rel="stylesheet" href="../css/update.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Update Data Album</h1>
            <a href="album.php" class="btn home-btn">Home</a>
        </header>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID Album</label>
                <input type="text" name="AlbumID" value="<?php echo htmlspecialchars($AlbumID); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Nama Album</label>
                <input type="text" name="NamaAlbum" value="<?php echo htmlspecialchars($NamaAlbum); ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="Deskripsi" value="<?php echo htmlspecialchars($Deskripsi); ?>">
            </div>
            <div class="form-group">
                <label for="userDisplay">User</label>
                <input type="text" name="userDisplay" value="<?php echo htmlspecialchars($userDisplay); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Dibuat</label>
                <input type="datetime-local" id="tanggalDibuat" name="TanggalDibuat" required>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const now = new Date();
                    const isoString = now.toISOString().slice(0, 16); 
                    document.getElementById('tanggalDibuat').value = isoString;
                });
            </script>
            <div class="form-group">
                <button type="submit" name="update" class="btn update-btn">Update</button>
            </div>
            <?php if (!empty($message)) : ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
