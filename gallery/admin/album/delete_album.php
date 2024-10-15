<?php
session_start();
include_once("../../config/koneksi.php");

if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $albumId = intval($_GET['id']);
    $sql_delete = "DELETE FROM album WHERE AlbumID = ?";
    $stmt = $kon->prepare($sql_delete);
    $stmt->bind_param("i", $albumId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Album deleted successfully!'); window.location.href='../manage_albums.php';</script>";
    } else {
        echo "<script>alert('Failed to delete album!'); window.location.href='../manage_albums.php';</script>";
    }
} else {
    header("Location: ../manage_albums.php");
}
?>
