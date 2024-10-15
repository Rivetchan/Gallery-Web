<?php
session_start();
include_once('../../../config/koneksi.php');

if (!isset($_SESSION['UserID'])) {
    http_response_code(403); 
    exit();
}

$UserID = $_SESSION['UserID'];

if (isset($_POST['fotoid'])) {
    $fotoID = $_POST['fotoid'];

    $checkLike = $kon->prepare("SELECT * FROM likefoto WHERE FotoID = ? AND UserID = ?");
    $checkLike->bind_param("ii", $fotoID, $UserID);
    $checkLike->execute();
    $result = $checkLike->get_result();

    if ($result->num_rows > 0) {
        $deleteLike = $kon->prepare("DELETE FROM likefoto WHERE FotoID = ? AND UserID = ?");
        $deleteLike->bind_param("ii", $fotoID, $UserID);
        $deleteLike->execute();

        $likeCount = $kon->query("SELECT COUNT(*) AS likeCount FROM likefoto WHERE FotoID = $fotoID")->fetch_assoc()['likeCount'];

        $response = ['likeCount' => $likeCount, 'userLiked' => false];
    } else {
        $addLike = $kon->prepare("INSERT INTO likefoto (FotoID, UserID) VALUES (?, ?)");
        $addLike->bind_param("ii", $fotoID, $UserID);
        $addLike->execute();

        $likeCount = $kon->query("SELECT COUNT(*) AS likeCount FROM likefoto WHERE FotoID = $fotoID")->fetch_assoc()['likeCount'];

        $response = ['likeCount' => $likeCount, 'userLiked' => true];
    }

    echo json_encode($response);
} else {
    http_response_code(400);
}
?>
