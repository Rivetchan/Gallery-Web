<?php
session_start();
include_once("../../config/koneksi.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $commentId = intval($_GET['id']);
    $sql_delete = "DELETE FROM komentarfoto WHERE KomentarID = ?";
    $stmt = $kon->prepare($sql_delete);
    $stmt->bind_param("i", $commentId);
    
    if ($stmt->execute()) {
        echo "<script>alert('Comment deleted successfully!'); window.location.href='../manage_comments.php';</script>";
    } else {
        echo "<script>alert('Failed to delete comment!'); window.location.href='../manage_comments.php';</script>";
    }
} else {
    header("Location: ../manage_comments.php");
}
?>
