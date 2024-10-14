<?php
session_start();
include_once('../../../config/koneksi.php');

if (!isset($_SESSION['UserID'])) {
    header("Location: ../../../login.php");
    exit();
}

$UserID = $_SESSION['UserID'];
$fotoID = $_POST['fotoid'];
$isiKomentar = $_POST['isikomentar'];

$sql = "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar) VALUES ('$fotoID', '$UserID', '$isiKomentar', NOW())";

$result = $kon->query($sql);

if (!$result) {
    die("Query Error: " . $kon->error);
} else {
    header("Location: foto.php");
    exit();
}
?>