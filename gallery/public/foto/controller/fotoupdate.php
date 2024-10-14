<?php  
	include_once("../../../config/koneksi.php");

	class FotoController {
		private $kon;

		public function __construct($connection) {
			$this->kon = $connection;
		}

		public function updateFoto($FotoID, $JudulFoto, $Deskripsi, $LokasiFile, $TanggalUnggah, $AlbumID, $UserID) {
			$result = mysqli_query($this->kon, "UPDATE foto SET JudulFoto = '$JudulFoto', Deskripsi = '$Deskripsi', LokasiFile = '$LokasiFile', TanggalUnggah = '$TanggalUnggah', AlbumID = '$AlbumID', UserID = '$UserID' WHERE FotoID = '$FotoID'");

			if ($result) {
				return "Sukses meng-update data Foto.";
			} else {
				return "Gagal meng-update data Foto.";
			}
		}

		public function getDataFoto($FotoID) {
			$sql = "SELECT * FROM foto WHERE FotoID = '$FotoID'";
			$ambildata = $this->kon->query($sql);

			if ($result = mysqli_fetch_array($ambildata)) {
				return $result;
			} else {
				return null;
			}
		}
	}
?>
