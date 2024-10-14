<?php  
include_once("../../../config/koneksi.php");

class FotoController {
    private $kon; 

    public function __construct($connection) {
        $this->kon = $connection;
    }

    public function tambahFoto() {
        $result = mysqli_query($this->kon, "SELECT FotoID FROM foto");
        $used_ids = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $used_ids[] = $row['FotoID'];
        }

        $new_id = 1;

        while (in_array($new_id, $used_ids)) {
            $new_id++;
        }

        return $new_id;
    }

    public function tambahDataFoto($data) {
        $FotoID = $data['FotoID'];
        $JudulFoto = mysqli_real_escape_string($this->kon, $data['JudulFoto']);
        $Deskripsi = mysqli_real_escape_string($this->kon, $data['Deskripsi']);
        $TanggalUnggah = $data['TanggalUnggah'];
        $AlbumID = $data['AlbumID'];
        $UserID = $data['UserID'];
    
        $ekstensi_diperbolehkan = array('jpeg', 'jpg', 'png');
        $namagambar = $_FILES['LokasiFile']['name'];
        $x = explode('.', $namagambar);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['LokasiFile']['size'];
        $file_temp = $_FILES['LokasiFile']['tmp_name'];
    
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran <= 20000000) {
                $upload_path = '../aset/' . $namagambar;
    
                if (move_uploaded_file($file_temp, $upload_path)) {
                    $insertData = mysqli_query($this->kon, "INSERT INTO foto (FotoID, JudulFoto, Deskripsi, LokasiFile, TanggalUnggah, AlbumID, UserID) VALUES ('$FotoID', '$JudulFoto', '$Deskripsi', '$namagambar', '$TanggalUnggah', '$AlbumID', '$UserID')");

                    if ($insertData) {
                        return "Data berhasil disimpan.";
                    } else {
                        return "Gagal menyimpan data: " . mysqli_error($this->kon);
                    }
                } else {
                    return "Gagal mengupload gambar.";
                }
            } else {
                return "Ukuran file terlalu besar! Silahkan pilih file yang lebih kecil.";
            }
        } else {
            return "Ekstensi file yang diupload tidak diizinkan!";
        }
    }
}
?>
