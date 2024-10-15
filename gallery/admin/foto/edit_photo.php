<?php
session_start();
include_once("../../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../manage_photos.php");
    exit();
}

$photoId = intval($_GET['id']);

$sql_photo = "SELECT * FROM foto WHERE FotoID = ?";
$stmt = $kon->prepare($sql_photo);
$stmt->bind_param("i", $photoId);
$stmt->execute();
$result = $stmt->get_result();
$photo = $result->fetch_assoc();

if (!$photo) {
    header("Location: ../manage_photos.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judulFoto = $_POST['judulFoto'];
    $deskripsi = $_POST['deskripsi'];
    $albumID = $_POST['albumID'];
    $userID = $_POST['userID'];
    $lokasiFile = $_POST['lokasiFile'];

    $sql_update = "UPDATE foto SET JudulFoto=?, Deskripsi=?, AlbumID=?, UserID=?, LokasiFile=? WHERE FotoID=?";
    $stmt_update = $kon->prepare($sql_update);
    $stmt_update->bind_param("ssissi", $judulFoto, $deskripsi, $albumID, $userID, $lokasiFile, $photoId);
    
    if ($stmt_update->execute()) {
        echo "<script>alert('Foto updated successfully!'); window.location.href='../manage_photos.php';</script>";
    } else {
        echo "<script>alert('Failed to update photo!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo</title>
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

        input[type="text"], input[type="number"] {
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

        .image-preview {
            text-align: center;
            margin-bottom: 15px;
        }

        .image-preview img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Photo</h1>
    <form method="POST" action="">
        <div class="image-preview">
            <img src="../../public/foto/aset/<?php echo htmlspecialchars($photo['LokasiFile']); ?>" alt="Photo Preview">
        </div>

        <label for="judulFoto">Judul Foto:</label>
        <input type="text" id="judulFoto" name="judulFoto" value="<?php echo htmlspecialchars($photo['JudulFoto']); ?>" required>

        <label for="deskripsi">Deskripsi:</label>
        <input type="text" id="deskripsi" name="deskripsi" value="<?php echo htmlspecialchars($photo['Deskripsi']); ?>" required>

        <label for="albumID">Album ID:</label>
        <input type="number" id="albumID" name="albumID" value="<?php echo htmlspecialchars($photo['AlbumID']); ?>" required>

        <label for="userID">User ID:</label>
        <input type="number" id="userID" name="userID" value="<?php echo htmlspecialchars($photo['UserID']); ?>" required>

        <label for="lokasiFile">Lokasi File (Relative Path):</label>
        <input type="file" id="lokasiFile" name="lokasiFile" value="<?php echo htmlspecialchars($photo['LokasiFile']); ?>" required>

        <input type="submit" value="Update Photo">
    </form>
</div>

</body>
</html>
