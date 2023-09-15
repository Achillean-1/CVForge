<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
session_start();

// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "CVForge_Database";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa apakah koneksi berhasil atau gagal
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memeriksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Memeriksa apakah password dan confirm password sama
    if ($_POST["password"] !== $_POST["confirm_password"]) {
        echo '<script>alert("Password and Confirm Password must match!");</script>';
    } else {
        // Menyimpan data ke database
        $sql = "INSERT INTO user_register (email, password) VALUES ('$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("User registered successfully!"); window.location.href = "CVForge_1.html";</script>';
            $_SESSION["email"] = $email;
        } else {
            echo '<script>alert("Error: ' . $sql . '<br>' . $conn->error . '");</script>';
        }
    }
}

// Menutup koneksi ke database
$conn->close();
?>

    <nav>
        <ul>
            <li style="font-size: 200%;"><a href="CVForge_1.html"><b>CVForge</b></a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>SIGN UP</h1>
        <form onsubmit="return validateForm()" method="post" action="register.php">
            <span style="float: left">
                <label><b>Email</b></label><br>
            </span>
            <input type="text" name="email" required><br>
            <span style="float: left">
                <label><b>Password</b></label><br>
            </span>
            <input id="passwordInput" type="password" name="password" required><br>
            <span style="float: left">
                <label><b>Confirm Password</b></label><br>
            </span>
            <input id="confirmPasswordInput" type="password" name="confirm_password" required autocomplete="new-password"><br>
            <button type="submit"><b>Sign Up</b></button>
        </form>
    </div>  

    <script>
        function validateForm() {
            var password = document.getElementById("passwordInput").value;
            var confirmPassword = document.getElementById("confirmPasswordInput").value;

            if (password !== confirmPassword) {
                alert("Password and Confirm Password must match!");
                return false;
            }

            if (password.length < 8) {
                alert("Password must have at least 8 characters!");
                return false;
            }

            return true;
        }
    </script>   
</body>
</html>