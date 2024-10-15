<?php 
    session_start();
    include_once("config/koneksi.php");

    if($kon->connect_error) {
        die("Connection failed: " . $kon->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];

        $sql = "SELECT UserID, Username, Password, level FROM user WHERE Username = '$Username' AND Password = '$Password'";
        $result = $kon->query($sql);

        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Username'] = $row['Username'];
            $_SESSION['level'] = $row['level']; 

            if ($row['level'] == 1) {
                header("Location: index.php");
            } elseif ($row['level'] == 2) {
                header("Location: index.php"); 
            }
            exit();
        } else {
            $error_message = "Failed Login, invalid Username or Password";
        }
    }

    $kon->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="style/login.css" rel="stylesheet">
</head>
<body>
    <div>
        <form method="post">
            <h1>LOGIN</h1>
            <div class="mb-4">
                <label for="Username">Username :</label>
                <input type="text" name="Username" id="Username" required>
            </div>
            <div class="mb-4 password-wrapper">
                <label for="Password">Password :</label>
                <input type="password" name="Password" id="Password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <img src="style/images/view.png" alt="Show/Hide Password" id="eyeIcon" class="eye-icon">
                </span>
            </div>
            <?php if (isset($error_message)) { ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php } ?>
            <p>Tidak Punya Akun? <a href="public/users/view/tambah.php">Register</a></p><br>
            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("Password");
            var eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.src = "style/images/close.png";
            } else {
                passwordInput.type = "password";
                eyeIcon.src = "style/images/view.png";
            }
        }
    </script>
</body>
</html>