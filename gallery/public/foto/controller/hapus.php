<?php  
include_once("../../../config/koneksi.php");
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: ../../../login.php");
    exit();
}

$UserID = $_SESSION['UserID']; 

$query = "SELECT FotoID, JudulFoto, LokasiFile FROM foto WHERE UserID = '$UserID'";
$result = mysqli_query($kon, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Foto</title>
    <link rel="stylesheet" href="../css/hapus.css">
</head>
<body>
    <header>
        <h1>Kelola Foto Anda</h1>
        <nav>
            <ul>
                <li><a href="../view/foto.php">Kembali ke Foto</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <form action="hapus.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Foto ID</th>
                        <th>Judul Foto</th>
                        <th>Lokasi File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) == 0) : ?>
                        <tr>
                            <td colspan="4">Tidak ada foto untuk ditampilkan.</td>
                        </tr>
                    <?php else : ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $row['FotoID']; ?></td>
                                <td><?php echo $row['JudulFoto']; ?></td>
                                <td><img src="../aset/<?php echo $row['LokasiFile']; ?>" width="100" alt="Foto"></td>
                                <td>
                                    <button type="submit" name="hapus" value="<?php echo $row['FotoID']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">Hapus</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
    </main>

    <?php  
    if (isset($_POST['hapus'])) {
        $FotoID = $_POST['hapus'];

        $fotoQuery = "SELECT LokasiFile FROM foto WHERE FotoID = '$FotoID' AND UserID = '$UserID'";
        $fotoResult = mysqli_query($kon, $fotoQuery);
        if (mysqli_num_rows($fotoResult) > 0) {
            $fotoData = mysqli_fetch_assoc($fotoResult);
            $lokasiFile = $fotoData['LokasiFile'];

            // Cek apakah file ada sebelum menghapus
            $filePath = '../aset/' . $lokasiFile;
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    // Jika file berhasil dihapus, hapus entri dari database
                    $deleteQuery = "DELETE FROM foto WHERE FotoID = '$FotoID'";
                    if (mysqli_query($kon, $deleteQuery)) {
                        echo "<script>alert('Foto berhasil dihapus.'); window.location.href='hapus.php';</script>";
                    } else {
                        echo "<script>alert('Gagal menghapus data dari database: " . mysqli_error($kon) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Gagal menghapus file dari server.');</script>";
                }
            } else {
                // Jika file tidak ditemukan, tetap hapus entri di database
                $deleteQuery = "DELETE FROM foto WHERE FotoID = '$FotoID'";
                if (mysqli_query($kon, $deleteQuery)) {
                    echo "<script>alert('File tidak ditemukan, tetapi entri foto telah dihapus dari database.'); window.location.href='hapus.php';</script>";
                } else {
                    echo "<script>alert('Gagal menghapus data dari database: " . mysqli_error($kon) . "');</script>";
                }
            }
        } else {
            echo "<script>alert('Foto tidak ditemukan atau bukan milik Anda.');</script>";
        }
    }
    ?>
</body>
</html>
