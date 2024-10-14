<?php  
	include_once("../../../config/koneksi.php");
	include_once("../controller/fotoupdate.php");

	$fotoController = new FotoController($kon);

	if (isset($_POST['update'])) {
		$FotoID = $_POST['FotoID'];
		$JudulFoto = $_POST['JudulFoto'];
		$Deskripsi = $_POST['Deskripsi'];
        $TanggalUnggah = $_POST['TanggalUnggah'];
		$AlbumID = $_POST['AlbumID'];
        $UserID = $_POST['UserID'];

		$message = $fotoController->updateFoto($FotoID, $JudulFoto, $Deskripsi, $TanggalUnggah, $AlbumID, $UserID);
		echo $message;

		header("Location: ../../dashboard/foto.php");
		exit();
	}

	$FotoID = null;
	$JudulFoto = null;
	$Deskripsi = null;
    $TanggalUnggah = null;
	$AlbumID = null;
    $UserID = null;

	if (isset($_GET['FotoID']) && is_numeric($_GET['FotoID'])) {
		$FotoID = $_GET['FotoID'];
		$result = $fotoController->getDataFoto($FotoID);

		if ($result) {
			$FotoID = $result['FotoID'];
			$JudulFoto = $result['JudulFoto'];
			$Deskripsi = $result['Deskripsi'];
            $TanggalUnggah = $result['TanggalUnggah'];
			$AlbumID = $result['AlbumID'];
            $UserID = $result['UserID'];
		} else {
			echo "ID Tidak Valid.";
		}
	}
    $dataAlbum= "SELECT AlbumID, NamaAlbum FROM album WHERE AlbumID NOT IN (SELECT AlbumID FROM foto)";
    $hasilAlbum= mysqli_query($kon, $dataAlbum);

    $dataUser= "SELECT UserID, Username FROM user WHERE UserID NOT IN (SELECT UserID FROM foto)";
    $hasilUser= mysqli_query($kon, $dataUser);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Foto</title>
    <link rel="stylesheet" href="../css/update.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Update Data Foto</h1>
            <a href="../view/foto.php" class="btn home-btn">Home</a>
        </header>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Foto ID</label>
                <input type="text" name="FotoID" value="<?php echo $FotoID; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Judul Foto</label>
                <input type="text" name="JudulFoto" value="<?php echo $JudulFoto; ?>" required>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="LokasiFile">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="Deskripsi" value="<?php echo $Deskripsi; ?>">
            </div>
            <div class="form-group">
                <label for="AlbumID" >Album</label>
                <select name="AlbumID" id="AlbumID" required>
                    <?php if (mysqli_num_rows($hasilAlbum) == 0) : ?>
                        <option disabled>Tidak ada Pilihan Album !!</option>
                    <?php else : ?>
                        <?php while ($row = mysqli_fetch_assoc($hasilMobil)) : ?>
                            <option value="<?php echo $row['AlbumID']; ?>">
                                <?php echo $row['AlbumID'] . ' - ' . $row['NamaAlbum'] ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="UserID" >Username</label>
                <select name="UserID" id="UserID" required>
                    <?php if (mysqli_num_rows($hasilUser) == 0) : ?>
                        <option disabled>Tidak ada Pilihan User !!</option>
                    <?php else : ?>
                        <?php while ($row = mysqli_fetch_assoc($hasilMobil)) : ?>
                            <option value="<?php echo $row['UserID']; ?>">
                                <?php echo $row['UserID'] . ' - ' . $row['Username'] ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Unggah</label>
                <input type="datetime-local" id="tanggalUnggah" name="TanggalUnggah" required>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const now = new Date();
                    const isoString = now.toISOString().slice(0, 16);
                    document.getElementById('tanggalUnggah').value = isoString;
                });
            </script>
            <button type="submit" name="update" class="btn submit-btn">Update Data</button>

            <?php if (isset($message)) : ?>
                <div class="success-message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
