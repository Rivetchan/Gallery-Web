<?php  
	include_once("../../../config/koneksi.php");

	class FotoController {
		private $kon;

		public function __construct($connection) {
			$this->kon = $connection;
		}

		public function getFotoData($FotoID) {
			$result = mysqli_query($this->kon, "SELECT foto.FotoID, album.NamaAlbum, user.Username, foto.JudulFoto, foto.Deskripsi, foto.LokasiFile, foto.TanggalUnggah
												FROM foto
												INNER JOIN album ON album.AlbumID = foto.AlbumID
												INNER JOIN user ON user.UserID = foto.UserID
												WHERE foto.FotoID = '$FotoID'");
			return mysqli_fetch_array($result);
		}
	}

	$kelasController = new FotoController($kon);
	$FotoID = $_GET['FotoID'];
	$fotoData = $kelasController->getFotoData($FotoID);

	if ($fotoData) {
		$FotoID = $fotoData['FotoID'];
		$JudulFoto = $fotoData['JudulFoto'];
		$Deskripsi = $fotoData['Deskripsi'];
		$LokasiFile = $fotoData['LokasiFile'];
		$TanggalUnggah = $fotoData['TanggalUnggah'];
		$NamaAlbum = $fotoData['NamaAlbum'];
		$Username = $fotoData['Username'];
	}
?>