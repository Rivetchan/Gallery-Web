<?php  
	include_once("../../../config/koneksi.php");

	class AlbumController {
		private $kon; 

		public function __construct($connection) {
			$this->kon = $connection;
		}

		public function tambahAlbum() {
			$setAuto = mysqli_query($this->kon, "SELECT MAX(AlbumID) AS max_id FROM album");
			$result = mysqli_fetch_assoc($setAuto);
			$max_id = $result['max_id'];

			if (is_numeric($max_id)) {
				$nounik = $max_id + 1;
			} else {
				$nounik = 1;
			} 
			return $nounik;
		}

		public function tambahDataAlbum($data) {
			$AlbumID = $data['AlbumID'];
            $NamaAlbum = $data['NamaAlbum'];
            $Deskripsi = $data['Deskripsi'];
			$TanggalDibuat = $data['TanggalDibuat'];
			$UserID = $data['UserID'];

			$insertData = mysqli_query($this->kon, "INSERT INTO album (AlbumID, NamaAlbum, Deskripsi, TanggalDibuat, UserID) VALUES ('$AlbumID', '$NamaAlbum', '$Deskripsi', '$TanggalDibuat', '$UserID')");

			if ($insertData) {
				return "Data berhasil disimpan.";
			} else {
				return "Gagal menyimpan data: " . mysqli_error($this->kon);
			}
		}
	}
?>
