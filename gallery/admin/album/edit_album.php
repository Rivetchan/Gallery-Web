<?php
session_start();
include_once("../../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location:../../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../manage_albums.php");
    exit();
}

$albumId = intval($_GET['id']);

$sql_album = "SELECT * FROM album WHERE AlbumID = ?";
$stmt = $kon->prepare($sql_album);
$stmt->bind_param("i", $albumId);
$stmt->execute();
$result = $stmt->get_result();
$album = $result->fetch_assoc();

if (!$album) {
    header("Location: ../manage_albums.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaAlbum = $_POST['namaAlbum'];
    $deskripsi = $_POST['deskripsi'];

    $sql_update = "UPDATE album SET NamaAlbum=?, Deskripsi=? WHERE AlbumID=?";
    $stmt_update = $kon->prepare($sql_update);
    $stmt_update->bind_param("ssi", $namaAlbum, $deskripsi, $albumId);
    
    if ($stmt_update->execute()) {
        echo "<script>alert('Album updated successfully!'); window.location.href='manage_albums.php';</script>";
    } else {
        echo "<script>alert('Failed to update album!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
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

        input[type="text"] {
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
    <h1>Edit Album</h1>
    <form method="POST" action="">
        <label for="namaAlbum">Nama Album:</label>
        <input type="text" id="namaAlbum" name="namaAlbum" value="<?php echo $album['NamaAlbum']; ?>" required>

        <label for="deskripsi">Deskripsi:</label>
        <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $album['Deskripsi']; ?>" required>

        <input type="submit" value="Update Album">
    </form>
</div>

</body>
</html>
