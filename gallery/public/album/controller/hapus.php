<?php  
include_once("../../../config/koneksi.php");

class AlbumController {
    private $kon;

    public function __construct($connection) {
        $this->kon = $connection;
    }

    public function deleteAlbum($AlbumID) {
        $deletePhotos = mysqli_query($this->kon, "DELETE FROM foto WHERE AlbumID = '$AlbumID'");

        $deletedata = mysqli_query($this->kon, "DELETE FROM album WHERE AlbumID = '$AlbumID'");

        if ($deletedata) {
            return "Data sukses terhapus.";
        } else {
            return "Data gagal terhapus: " . mysqli_error($this->kon);
        }
    }
}

$kelasController = new AlbumController($kon);

if (isset($_GET['AlbumID'])) {
    $AlbumID = $_GET['AlbumID'];
    $message = $kelasController->deleteAlbum($AlbumID);
    echo $message;

    header("Location: ../view/album.php");
    exit(); 
}
?>
