<?php
session_start();
include_once('../../../config/koneksi.php');

if (!isset($_SESSION['UserID'])) {
    header("Location: ../../../login.php");
    exit();
}

$UserID = $_SESSION['UserID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];

    $updateSql = "UPDATE user SET Password = '$newPassword' WHERE UserID = '$UserID'";

    if ($kon->query($updateSql) === TRUE) {
        $successMessage = "Password berhasil diubah.";
    } else {
        $errorMessage = "Error: " . $kon->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/profile.css">
    <title>Edit Password</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="../../../index.php">Gallery</a>
        </div>
        <div class="nav">
            <a href="../../../index.php">Home</a>
            <a href="../../album/view/album.php">Album</a>
            <a href="../../foto/view/foto.php">Galeri Foto</a>
            <a href="edit_password.php">Edit Password</a>
            <a href="../../../logout.php">Logout</a>
        </div>
    </div>

    <div class="content">
        <h2>Edit Password</h2>
        <?php if (isset($successMessage)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        <form action="edit_password.php" method="POST">
            <div class="form-group">
                <label for="new_password">Password Baru:</label>
                <div class="password-container">
                    <input type="password" name="new_password" id="new_password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('new_password', this)"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password Baru:</label>
                <div class="password-container">
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('confirm_password', this)"></i>
                </div>
            </div>
            <button type="submit">Ubah Password</button>
        </form>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            const iconClass = icon.classList.contains('fa-eye') ? 'fa-eye-slash' : 'fa-eye';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
