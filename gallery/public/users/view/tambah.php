<?php 
include_once("../../../config/koneksi.php");
include_once("../controller/users.php");

$userController = new UsersController($kon);

$message = "";
$messageType = "";

if (isset($_POST['submit'])) {
    if ($_POST['Password'] !== $_POST['confirm_password']) {
        $message = "Password dan konfirmasi password tidak sesuai.";
        $messageType = "error";
    } else {
        $username = $_POST['Username'];
        $email = $_POST['Email'];

        if ($userController->cekDuplikasiUser($username, $email)) {
            $message = "Username atau Email sudah terdaftar.";
            $messageType = "error";
        } else {
            $UserID = $userController->generateUserId();

            $data = [
                'UserID' => $UserID,
                'Username' => $username,
                'Email' => $email,
                'Password' => $_POST['Password'],
                'NamaLengkap' => $_POST['NamaLengkap'],
                'Alamat' => $_POST['Alamat'],
                'Level' => $_POST['Level']
            ];

            $result = $userController->tambahDataUser($data);
            
            if ($result) {
                $message = "Akun berhasil dibuat!";
                $messageType = "success";
            } else {
                $message = "Gagal membuat akun.";
                $messageType = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>
    <div class="form-container">
        <h1>Daftar User</h1>

        <form action="tambah.php" method="post">
            <div class="form-group">
                <label for="Username">Username:</label>
                <input type="text" name="Username" id="Username" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" name="Email" id="Email" required>
            </div>

            <div class="form-group">
                <label for="Password">Password:</label>
                <div class="password-container">
                    <input type="password" name="Password" id="Password" required>
                    <img src="../css/images/view.png" id="eyePassword" alt="Toggle Password" onclick="togglePassword('Password', 'eyePassword')">
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password:</label>
                <div class="password-container">
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <img src="../css/images/view.png" id="eyeConfirmPassword" alt="Toggle Confirm Password" onclick="togglePassword('confirm_password', 'eyeConfirmPassword')">
                </div>
            </div>

            <div class="form-group">
                <label for="NamaLengkap">Nama Lengkap:</label>
                <input type="text" name="NamaLengkap" id="NamaLengkap" required>
            </div>

            <div class="form-group">
                <label for="Alamat">Alamat:</label>
                <input type="text" name="Alamat" id="Alamat" required>
            </div>

            <div class="form-group">
                <label for="level">Level:</label>
                <select name="Level" id="Level" required>
                    <option value="2">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>

            <p>Sudah punya akun? <a href="../../../login.php" class="login-link">Login</a></p>

            <div class="form-group">
                <button type="submit" name="submit">Register</button>
            </div>
        </form>
    </div>

    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="messageText" class=""></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('messageModal');
            var span = document.getElementsByClassName('close')[0];
            var messageText = document.getElementById('messageText');
            var message = "<?php echo addslashes($message); ?>";
            var messageType = "<?php echo $messageType; ?>";

            if (message) {
                messageText.textContent = message;
                messageText.className = messageType;
                modal.style.display = 'block';
            }

            span.onclick = function() {
                modal.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });

        function togglePassword(fieldId, iconId) {
            var passwordInput = document.getElementById(fieldId);
            var eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.src = "../css/images/close.png";
            } else {
                passwordInput.type = "password";
                eyeIcon.src = "../css/images/view.png";
            }
        }
    </script>
</body>
</html>