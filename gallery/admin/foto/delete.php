<?php
session_start();
include_once("../../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $photoId = intval($_GET['id']);
    $sql_delete = "DELETE FROM foto WHERE FotoID = ?";
    $stmt = $kon->prepare($sql_delete);
    $stmt->bind_param("i", $photoId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Photo deleted successfully!'); window.location.href='manage_photos.php';</script>";
    } else {
        echo "<script>alert('Failed to delete photo!'); window.location.href='manage_photos.php';</script>";
    }
} else {
    header("Location: ../manage_photos.php");
}
?>
