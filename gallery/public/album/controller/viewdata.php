<?php  
	include_once("../../../config/koneksi.php");

	class AlbumController {
		private $kon;

		public function __construct($connection) {
			$this->kon = $connection;
		}

		public function getAlbumData($AlbumID) {
			$result = mysqli_query($this->kon, "SELECT * FROM album WHERE AlbumID = '$AlbumID'");
			return mysqli_fetch_array($result);
		}
	}

	if (isset($_GET['AlbumID'])) {
		$AlbumID = mysqli_real_escape_string($kon, $_GET['AlbumID']);
		$kelasController = new AlbumController($kon);
		$albumData = $kelasController->getAlbumData($AlbumID);

		if ($albumData) {
			$AlbumID = $albumData['AlbumID'];
			$NamaAlbum = $albumData['NamaAlbum'];
			$Deskripsi = $albumData['Deskripsi'];
			$TanggalDibuat = $albumData['TanggalDibuat'];
			$UserID = $albumData['UserID'];
		} else {
			echo "Data alat tidak ditemukan.";
		}
	} else {
		echo "ID Alat tidak diberikan.";
	}
?>
