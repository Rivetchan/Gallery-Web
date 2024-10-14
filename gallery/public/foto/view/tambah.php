<?php  
include_once("../../../config/koneksi.php");
include_once("../controller/fototambah.php");

$fotoController = new FotoController($kon);
$FotoID = $fotoController->tambahFoto();

if (isset($_POST['submit'])) {
    $data = [
        'FotoID' => $FotoID,
        'JudulFoto' => $_POST['JudulFoto'],
        'Deskripsi' => $_POST['Deskripsi'],
        'TanggalUnggah' => $_POST['TanggalUnggah'],
        'AlbumID' => $_POST['AlbumID'],
        'UserID' => $_POST['UserID'],
    ];

    $message = $fotoController->tambahDataFoto($data);
}

$dataAlbum = "SELECT AlbumID, NamaAlbum FROM album";
$hasilAlbum = mysqli_query($kon, $dataAlbum);

$dataUser = "SELECT UserID, Username FROM user";
$hasilUser = mysqli_query($kon, $dataUser);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Foto</title>
    <link rel="stylesheet" href="../css/tambah.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Tambah Data Foto</h1>
            <a href="foto.php" class="btn home-btn">Home</a>
        </header>

        <form action="tambah.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID Foto</label>
                <input type="text" name="FotoID" value="<?php echo($FotoID); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Judul Foto</label>
                <input type="text" name="JudulFoto" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="Deskripsi">
            </div>
            <div class="form-group">
                <label>Lokasi File</label>
                <input type="file" name="LokasiFile" required>
            </div>
            <div class="form-group">
                <label for="AlbumID">Album</label>
                <select name="AlbumID" id="AlbumID" required>
                    <?php if (mysqli_num_rows($hasilAlbum) == 0) : ?>
                        <option disabled>Tidak ada Pilihan Album !!</option>
                    <?php else : ?>
                        <?php while ($row = mysqli_fetch_assoc($hasilAlbum)) : ?>
                            <option value="<?php echo $row['AlbumID']; ?>">
                                <?php echo $row['AlbumID'] . ' - ' . $row['NamaAlbum'] ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="UserID">User</label>
                <select name="UserID" id="UserID" required>
                    <?php if (mysqli_num_rows($hasilUser) == 0) : ?>
                        <option disabled>Tidak ada Pilihan User !!!</option>
                    <?php else : ?>
                        <?php while ($row = mysqli_fetch_assoc($hasilUser)) : ?>
                            <option value="<?php echo $row['UserID']; ?>">
                                <?php echo $row['UserID'] . ' - ' . $row['Username'] ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Dibuat</label>
                <input type="datetime-local" id="tanggalUnggah" name="TanggalUnggah" required>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const now = new Date();
                    const isoString = now.toISOString().slice(0, 16);
                    document.getElementById('tanggalUnggah').value = isoString;
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
