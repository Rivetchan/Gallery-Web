<?php
session_start();
include_once("../../config/koneksi.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $likeId = intval($_GET['id']);
    $sql_delete = "DELETE FROM likefoto WHERE LikeID = ?";
    $stmt = $kon->prepare($sql_delete);
    $stmt->bind_param("i", $likeId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Like deleted successfully!'); window.location.href='../manage_likes.php';</script>";
    } else {
        echo "<script>alert('Failed to delete like!'); window.location.href='../manage_likes.php';</script>";
    }
} else {
    header("Location: ../manage_likes.php");
}
?>
