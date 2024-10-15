<?php
session_start();
include_once("../../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $photoId = intval($_GET['id']); 

    $sql_check = "SELECT * FROM foto WHERE FotoID = ?";
    $stmt_check = $kon->prepare($sql_check);
    $stmt_check->bind_param("i", $photoId);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $sql_delete = "DELETE FROM foto WHERE FotoID = ?";
        $stmt = $kon->prepare($sql_delete);
        $stmt->bind_param("i", $photoId);

        if ($stmt->execute()) {
            echo "<script>alert('Photo deleted successfully!'); window.location.href='../manage_photos.php';</script>";
        } else {
            echo "<script>alert('Failed to delete photo: " . $stmt->error . "'); window.location.href='../manage_photos.php';</script>";
        }
    } else {
        echo "<script>alert('Photo does not exist!'); window.location.href='../manage_photos.php';</script>";
    }
} else {
    header("Location: ../manage_photos.php");
}
?>
