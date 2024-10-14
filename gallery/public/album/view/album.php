<?php  
session_start();
include_once("../../../config/koneksi.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: ../../../login.php");
    exit();
}

$currentUserID = $_SESSION['UserID']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Album</title>
    <link rel="stylesheet" href="../css/album.css">
    <script>
        function autoSearch() {
            const searchInput = document.querySelector('.search-input');
            const searchValue = searchInput.value;
            const searchForm = document.querySelector('.search-form');

            if (searchValue.length > 1) {
                const url = new URL(searchForm.action);
                url.searchParams.set('cari', searchValue);
                window.location.href = url;
            } else if (searchValue.length === 0) {
                window.location.href = 'album.php'; 
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1 class="page-title">Daftar Album</h1>

    <form action="album.php" method="get" class="search-form">
        <input type="text" name="cari" placeholder="Cari album..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>" class="search-input" oninput="autoSearch()">
    </form>

    <div class="action-menu">
        <div class="left-menu">
            <a href="tambah.php" class="btn add-btn">Tambah Album</a>
            <a href="javascript:void(0);" onclick="window.print();" class="btn cetak-btn">Cetak</a>
        </div>
        <a href="../../foto/view/foto.php" class="btn home-btn">Home</a>
    </div>

    <table class="product-table">
        <thead>
            <tr>
                <th>ID Album</th>
                <th>Nama Album</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php  
                if (isset($_GET['cari'])) {
                    $cari = mysqli_real_escape_string($kon, $_GET['cari']);
                    $query = "SELECT album.*, user.Username 
                              FROM album 
                              JOIN user ON album.UserID = user.UserID
                              WHERE (album.AlbumID LIKE '%$cari%' 
                                  OR album.NamaAlbum LIKE '%$cari%'
                                  OR user.Username LIKE '%$cari%')
                                AND album.UserID = '$currentUserID'
                              ORDER BY album.AlbumID ASC";
                } else {
                    $query = "SELECT album.*, user.Username 
                              FROM album 
                              JOIN user ON album.UserID = user.UserID
                              WHERE album.UserID = '$currentUserID'
                              ORDER BY album.AlbumID ASC";
                }
                
                $ambildata = mysqli_query($kon, $query);

                if (mysqli_num_rows($ambildata) > 0) {
                    while ($userAmbilData = mysqli_fetch_array($ambildata)) {
                        echo "<tr>";
                        echo "<td>" . $userAmbilData['AlbumID'] . "</td>";
                        echo "<td>" . $userAmbilData['NamaAlbum'] . "</td>";
                        echo "<td>" . $userAmbilData['Deskripsi'] . "</td>";
                        echo "<td>" . $userAmbilData['TanggalDibuat'] . "</td>";
                        echo "<td>" . $userAmbilData['Username'] . "</td>";
                        echo "<td class='actions'>
                                <a href='update.php?AlbumID=" . $userAmbilData['AlbumID'] . "' class='btn action-btn'>Edit</a>  
                                <a href='../controller/hapus.php?AlbumID=" . $userAmbilData['AlbumID'] . "' class='btn action-btn delete-btn'>Hapus</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Data tidak ditemukan.</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
