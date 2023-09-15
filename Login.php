<!-- dokumen html -->
<!DOCTYPE html>
<!-- tag html -->
<html>
    <!-- tag head -->
    <head>
    <!-- membuat judul web -->
    <title>Login</title>
    <!-- melakukan link menuju style.css untuk melakukan styling -->
    <link rel="stylesheet" href="style.css">
<!-- menutup tag head -->
</head>

<!-- membuka tag body -->
<body>
<!-- membuka tag php -->
<?php
// memulai sesi
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

    // Memeriksa kecocokan email dan password di database
    $sql = "SELECT * FROM user_register WHERE email = '$email' AND password = '$password'";
    // menentukan hasil query
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Login berhasil
        $_SESSION["email"] = $email;

        if ($email == "admin@example.com") {
            // Jika email adalah email admin
            echo '<script>alert("Login successful!"); window.location.href = "Admin.php";</script>';
        } else {
            // Jika email adalah email user
            echo '<script>alert("Login successful!"); window.location.href = "CVForge_2.html";</script>';
        }
    } else {
        // Login gagal
        echo '<script>alert("Invalid email or password!");</script>';
    }
}

// Menutup koneksi ke database
$conn->close();
?>
    <!-- memberi tag nav untuk navigasi bar -->
    <nav>
        <!-- membuat unordered list untuk navigasi bar -->
        <ul>
            <!-- membuat menu CVForge yang mengarahkan ke homepage sebelum login (CVForge_1.html) -->
            <li style="font-size: 200%;"><a href="CVForge_1.html"><b>CVForge</b></a></li>
        <!-- menutup tag unordered list -->
        </ul>
    <!-- menutup tag nav -->
    </nav>
    <!-- membuat divisi "container" -->
    <div class="container">
        <!-- membuat h1 login -->
        <h1>Login</h1>
        <!-- membuat form dengan metode post yang dialamatkan ke halaman login (Login.php) -->
        <form method="post" action="login.php">
            <!-- membuat tag span untuk meletakkan pada posisi kiri -->
            <span style="float: left">
                <!-- membuat label Email -->
                <label><b>Email</b></label><br>
            <!-- menutup tag span -->
            </span>
            <!-- membuat tag input untuk email -->
            <input type="text" name="email"><br>
            <!-- membuat tag span untuk meletakkan pada posisi kiri -->
            <span style="float: left">
                <!-- membuat label Password -->
                <label><b>Password</b></label><br>
            <!-- menutup tag span -->
            </span>
            <!-- membuat tag input untuk password -->
            <input type="password" name="password"><br>
            <!-- membuat tombol submit dengan nama Log in -->
            <button type="submit"><b>Log In</b></button>
            <!-- membuat tag span untuk meletakkan pada posisi tengah -->
            <span style="float: center;">
                <!-- membuat label dengan nama Create Account yang diarahkan ke halaman register (Register.php) -->
                <label><a href="Register.php" style="color:#fff">Create Account</a></label>
            <!-- menutup tag span -->
            </span>
        <!-- menutup tag form -->
        </form>
    <!-- menutup divisi -->
    </div>     
<!-- Menutup body -->
</body>
<!-- menutup html -->
</html>




