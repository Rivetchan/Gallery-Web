<?php

include '../../../config/koneksi.php'; 

$fotoID = $_GET['fotoid'];

$sql = "SELECT * FROM foto WHERE FotoID = '$fotoID'";
$result = $kon->query($sql);

if ($result->num_rows > 0) {
    $foto = $result->fetch_assoc();
} else {
    echo "Foto tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judulFoto = $_POST['judul'];
    $lokasiFile = $_FILES['file']['name'];
    $deskripsi = $_POST['deskripsi']; 

    if ($lokasiFile) {
        $targetDir = '../aset/';
        $targetFile = $targetDir . basename($lokasiFile);
        move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);

        $sql = "UPDATE foto SET JudulFoto='$judulFoto', LokasiFile='$lokasiFile', Deskripsi='$deskripsi' WHERE FotoID='$fotoID'";
    } else {
        $sql = "UPDATE foto SET JudulFoto='$judulFoto', Deskripsi='$deskripsi' WHERE FotoID='$fotoID'"; // Update deskripsi
    }

    if ($kon->query($sql) === TRUE) {
        echo "<script>alert('Foto berhasil diupdate!'); window.location.href='foto.php';</script>";
    } else {
        echo "Error: " . $kon->error;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit.css"> 
    <title>Edit Foto</title>
</head>
<body>
    <div class="container">
        <h2>Edit Foto</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul Foto :</label>
                <input type="text" id="judul" name="judul" value="<?php echo $foto['JudulFoto']; ?>" required>
            </div>
            <div class="form-group">
                <label for="file">Ganti Gambar :</label>
                <input type="file" id="file" name="file">
                <img src="../aset/<?php echo $foto['LokasiFile']; ?>" alt="Foto" class="preview-image">
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi :</label>
                <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $foto['Deskripsi']; ?>" required> <!-- Tambahkan input deskripsi -->
            </div>
            <button type="submit" class="submit-button">Update Foto</button>
        </form>
        <a href="index.php" class="back-button">Kembali</a>
    </div>
</body>
</html>
