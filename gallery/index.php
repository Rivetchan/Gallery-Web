<?php
session_start();
$isLoggedIn = false;
$Username = '';
$level = 0; 

if (isset($_SESSION['Username'])) {
    $Username = $_SESSION['Username'];
    $isLoggedIn = true;
    $level = $_SESSION['level'];
}
?>
<html>
<head>
    <title>Home Gallery</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="style/index/style.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="index.php">
                <img alt="Rivet Gallery" src="source/images/20thcenturyboy.jpg">
            </a>
        </div>

        <div class="auth-links">
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
            <?php if ($isLoggedIn): ?>
                <a href="public/foto/view/foto.php">Dashboard Foto</a>
                <?php if ($level == 1): ?>
                    <a href="admin/admin.php">Halaman Admin</a>
                <?php endif; ?>
                <a class="logout" href="logout.php">Log out</a>
            <?php else: ?>
                <a class="login" href="login.php">Log in</a>
                <a class="signup" href="public/users/view/tambah.php">Sign up</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="main-content">
        <h1>WELCOME</h1>
        <h2>To</h2>
        <h1>Your Gallery</h1>
    </div>

    <div class="sliding-image-gallery">
        <button class="arrow left" id="prevBtn">&#10094;</button>
        <div class="image-track">
            <div class="image-container">
                <a href="foto_album.php?AlbumID=2">
                    <img src="source/images/20 Century Manga.jpg" alt="Gallery Image">
                    <div class="category-label">20th Century Boys</div>
                </a>
            </div>
            <div class="image-container">
                <a href="foto_album.php?AlbumID=1">
                    <img src="source/images/Spiderman.jpg" alt="Gallery Image">
                    <div class="category-label">Spider-Man Across The Spider-Verse</div>
                </a>
            </div>
            <div class="image-container">
                <a href="foto_album.php?AlbumID=3">
                    <img src="source/images/Cyber Security.png" alt="Gallery Image">
                    <div class="category-label">Cyber Security</div>
                </a>
            </div>
            <div class="image-container">
                <a href="foto_album.php?AlbumID=4">
                    <img src="source/images/Murder Drones.jpg" alt="Gallery Image">
                    <div class="category-label">Murder Drones</div>
                </a>
            </div>
        </div>
        </div>
        <button class="arrow right" id="nextBtn">&#10095;</button>
    </div>

    <div class="footer"></div>

    <script>
        const images = [
            { src: "source/images/20 Century Manga.jpg", category: "20th Century Boys" },
            { src: "source/images/Spiderman.jpg", category: "Spiderman" },
            { src: "source/images/Cyber Security.png", category: "Cyber Security" },
            { src: "source/images/Murder Drones.jpg", category: "Murder Drones" }
        ];

        let currentIndex = 1;
        const imageTrack = document.querySelector(".image-track");
        const imageContainers = document.querySelectorAll(".image-container");

        function updateGallery() {
            imageContainers.forEach((container, index) => {
                const offset = index - currentIndex;
                if (offset === 0) {
                    container.classList.add("center");
                    container.classList.remove("left", "right");
                } else if (offset === -1 || offset === (images.length - 1)) {
                    container.classList.add("left");
                    container.classList.remove("center", "right");
                } else if (offset === 1 || offset === -(images.length - 1)) {
                    container.classList.add("right");
                    container.classList.remove("center", "left");
                } else {
                    container.classList.remove("center", "left", "right");
                }
            });
        }

        document.getElementById('nextBtn').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % images.length;
            updateGallery();
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateGallery();
        });

        setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            updateGallery();
        }, 3000);

        updateGallery();
    </script>
</body>
</html>
