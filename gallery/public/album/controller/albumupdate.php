<?php  
	include_once("../../../config/koneksi.php");

	class AlbumController {
		private $kon;

		public function __construct($connection) {
			$this->kon = $connection;
		}

		public function updateAlbum($AlbumID, $NamaAlbum, $Deskripsi, $TanggalDibuat, $UserID) {
			$result = mysqli_query($this->kon, "UPDATE album SET NamaAlbum = '$NamaAlbum', Deskripsi = '$Deskripsi', TanggalDibuat = '$TanggalDibuat', UserID = '$UserID' WHERE AlbumID = '$AlbumID'");

			if ($result) {
				return "Sukses meng-update data Album.";
			} else {
				return "Gagal meng-update data Album.";
			}
		}

		public function getDataAlbum($AlbumID) {
			$sql = "SELECT * FROM Album WHERE AlbumID = '$AlbumID'";
			$ambildata = $this->kon->query($sql);

			if ($result = mysqli_fetch_array($ambildata)) {
				return $result;
			} else {
				return null;
			}
		}
	}
?>
