<?php  
    include_once("../../../config/koneksi.php");
    include_once("../controller/albumtambah.php");

    session_start(); 
    $albumController = new AlbumController($kon);

    $UserID = $_SESSION['UserID'];

    $queryUser = "SELECT Username FROM user WHERE UserID = '$UserID'";
    $resultUser = mysqli_query($kon, $queryUser);
    $username = '';
    
    if ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $row = mysqli_fetch_assoc($resultUser);
        $username = $row['Username'];
    }

    if (isset($_POST['submit'])) {
        $AlbumID = $albumController->tambahAlbum();

        $data = [
            'AlbumID' => $AlbumID,
            'NamaAlbum' => $_POST['NamaAlbum'],
            'Deskripsi' => $_POST['Deskripsi'],
            'TanggalDibuat' => $_POST['TanggalDibuat'],
            'UserID' => $UserID
        ];

        $message = $albumController->tambahDataAlbum($data);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Album</title>
    <link rel="stylesheet" href="../css/tambah.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Tambah Data Album</h1>
            <a href="album.php" class="btn home-btn">Home</a>
        </header>

        <form action="tambah.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID Album</label>
                <input type="text" name="AlbumID" value="<?php echo($albumController->tambahAlbum())?>" readonly>
            </div>
            <div class="form-group">
                <label>Nama Album</label>
                <input type="text" name="NamaAlbum" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="Deskripsi">
            </div>
            <div class="form-group">
                <label for="UserID">User</label>
                <input type="text" name="User" value="<?php echo htmlspecialchars($UserID . ' - ' . $username); ?>" readonly>
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
            <button type="submit" name="submit" class="btn submit-btn">Tambah Data</button>

            <?php if (isset($message)) : ?>
                <div class="success-message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>