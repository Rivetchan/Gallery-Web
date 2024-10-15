<?php
session_start();
include_once("../../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../manage_users.php");
    exit();
}

$userId = intval($_GET['id']);

$sql_user = "SELECT * FROM user WHERE UserID = ?";
$stmt = $kon->prepare($sql_user);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: ../manage_users.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $namaLengkap = $_POST['namaLengkap'];
    $alamat = $_POST['alamat'];

    $sql_update = "UPDATE user SET Username=?, Email=?, NamaLengkap=?, Alamat=? WHERE UserID=?";
    $stmt_update = $kon->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $username, $email, $namaLengkap, $alamat, $userId);
    
    if ($stmt_update->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href='../manage_users.php';</script>";
    } else {
        echo "<script>alert('Failed to update user!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit User</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['Username']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['Email']; ?>" required>

        <label for="namaLengkap">Nama Lengkap:</label>
        <input type="text" id="namaLengkap" name="namaLengkap" value="<?php echo $user['NamaLengkap']; ?>" required>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="<?php echo $user['Alamat']; ?>" required>

        <input type="submit" value="Update User">
    </form>
</div>

</body>
</html>
