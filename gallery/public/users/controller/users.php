<?php 
include_once("../../../config/koneksi.php");

class UsersController {
    private $kon;

    public function __construct($connection) {
        $this->kon = $connection;
    }

    public function generateUserId() {
        $setAuto = mysqli_query($this->kon, "SELECT MAX(UserID) AS max_id FROM user");
        $result = mysqli_fetch_assoc($setAuto);
        $max_id = $result['max_id'];

        if (is_numeric($max_id)) {
            $nounik = $max_id + 1;
        } else {
            $nounik = 1;
        }
        return $nounik;
    }

    public function cekDuplikasiUser($username, $email) {
        $query = "SELECT COUNT(*) as count FROM user WHERE Username = ? OR Email = ?";
        $stmt = $this->kon->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0; 
    }

    public function tambahDataUser($data) {
        $UserID = $data['UserID'];
        $Username = $data['Username'];
        $Password = ($data['Password']);
        $Email = $data['Email'];
        $NamaLengkap = $data['NamaLengkap'];
        $Alamat = $data['Alamat'];
        $Level = $data['Level'];

        $insertData = mysqli_query($this->kon, "INSERT INTO user (UserID, Username, Password, Email, NamaLengkap, Alamat, Level) 
                    VALUES('$UserID', '$Username', '$Password', '$Email', '$NamaLengkap', '$Alamat', '$Level')");

        if ($insertData) {
            return true;
        } else {
            return false;
        }
    }
}
?>
