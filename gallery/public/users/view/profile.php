<?php
session_start();
include_once("../config/koneksi.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data pengguna dari database
$username = $_SESSION['Username'];
$sql_user = "SELECT * FROM users WHERE Username = ?";
$stmt = $kon->prepare($sql_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_user = $stmt->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    echo "<script>alert('User not found!'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="css/admin.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .profile-info {
            margin: 20px 0;
        }

        .profile-info label {
            font-weight: bold;
        }

        .edit-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }

        .edit-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php include('admin_nav.php'); ?>

<div class="container">
    <h1>User Profile</h1>
    <div class="profile-info">
        <label>Username:</label>
        <p><?php echo htmlspecialchars($user['Username']); ?></p>

        <label>Email:</label>
        <p><?php echo htmlspecialchars($user['Email']); ?></p>

        <label>Nomor HP:</label>
        <p><?php echo htmlspecialchars($user['NomorHP']); ?></p>

        <label>Tanggal Lahir:</label>
        <p><?php echo htmlspecialchars($user['TanggalLahir']); ?></p>
    </div>
    
    <a href="edit_profile.php" class="edit-link">Edit Profile</a>
</div>

</body>
</html>
