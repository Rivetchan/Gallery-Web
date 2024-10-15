<?php
session_start();
include_once('../../../config/koneksi.php');

if (!isset($_SESSION['UserID'])) {
    header("Location: ../../../login.php");
    exit();
}

$UserID = $_SESSION['UserID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $targetDir = "../aset/";
    $targetFile = $targetDir . basename($_FILES["foto"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
        $sql = "UPDATE user SET FotoUser = '" . htmlspecialchars(basename($_FILES["foto"]["name"])) . "' WHERE UserID = '$UserID'";
        if ($kon->query($sql) === TRUE) {
            header("Location: profile.php");
            exit();
        } else {
            die("Error updating record: " . $kon->error);
        }
    } else {
        die("Sorry, there was an error uploading your file.");
    }
}
