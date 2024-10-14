<?php
session_start();
include_once('../../../config/koneksi.php');

if (!isset($_SESSION['UserID'])) {
    http_response_code(403); // Forbidden
    exit();
}

$UserID = $_SESSION['UserID'];

if (isset($_POST['fotoid'])) {
    $fotoID = $_POST['fotoid'];

    // Cek apakah pengguna sudah menyukai foto ini
    $checkLike = $kon->prepare("SELECT * FROM likefoto WHERE FotoID = ? AND UserID = ?");
    $checkLike->bind_param("ii", $fotoID, $UserID);
    $checkLike->execute();
    $result = $checkLike->get_result();

    if ($result->num_rows > 0) {
        // Jika sudah disukai, hapus like
        $deleteLike = $kon->prepare("DELETE FROM likefoto WHERE FotoID = ? AND UserID = ?");
        $deleteLike->bind_param("ii", $fotoID, $UserID);
        $deleteLike->execute();

        // Ambil jumlah like setelah dihapus
        $likeCount = $kon->query("SELECT COUNT(*) AS likeCount FROM likefoto WHERE FotoID = $fotoID")->fetch_assoc()['likeCount'];

        $response = ['likeCount' => $likeCount, 'userLiked' => false];
    } else {
        // Jika belum disukai, tambahkan like
        $addLike = $kon->prepare("INSERT INTO likefoto (FotoID, UserID) VALUES (?, ?)");
        $addLike->bind_param("ii", $fotoID, $UserID);
        $addLike->execute();

        // Ambil jumlah like setelah ditambahkan
        $likeCount = $kon->query("SELECT COUNT(*) AS likeCount FROM likefoto WHERE FotoID = $fotoID")->fetch_assoc()['likeCount'];

        $response = ['likeCount' => $likeCount, 'userLiked' => true];
    }

    echo json_encode($response);
} else {
    http_response_code(400); // Bad request
}
?>
