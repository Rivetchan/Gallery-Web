<?php
session_start();
include_once("../../config/koneksi.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['Username']) || $_SESSION['level'] != 1) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $sql_delete = "DELETE FROM user WHERE UserID = ?";
    $stmt = $kon->prepare($sql_delete);
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Failed to delete user!'); window.location.href='manage_users.php';</script>";
    }
} else {
    header("Location: ../manage_users.php");
}
?>
