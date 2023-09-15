<!-- dokumen html -->
<!DOCTYPE html>
<html>
<head>
	<title>Profile Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="overflow: auto;">
<?php
// Memulai sesi PHP
session_start();
// Nama server MySQL
$servername = "localhost";
// Nama pengguna MySQL
$username = "root";
// Kata sandi MySQL
$password = "";
// Nama database
$dbname = "cvforge_database";

// Membuat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Menghentikan eksekusi jika koneksi ke database gagal
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mengambil email dari sesi
$email = $_SESSION["email"];

// Query untuk mengambil data pengguna dari tabel "settings"
$sql = "SELECT * FROM settings WHERE email = '$email'";
// Menjalankan query
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Mengambil username dari hasil query
        $username = $row["username"];
        // Mengambil email dari hasil query
        $email = $row["email"];
        // Mengambil nomor telepon dari hasil query
        $notelp = $row["notelp"];
        // Mengambil alamat dari hasil query
        $alamat = $row["alamat"];
        // Mengambil nama file gambar profil dari hasil query
        $image = $row["image_pp"];
    }
} else {
    // Data tidak ditemukan, alihkan ke halaman Biodata
    // Menutup koneksi database
    mysqli_close($conn);
    // Mengalihkan pengguna ke halaman Biodata
    header("Location: Biodata.php");
    // Menghentikan eksekusi
    exit();
}

// Mengambil ringkasan profesional dari sesi, jika tidak ada, tetapkan nilai kosong
$summary = isset($_SESSION['summary']) ? $_SESSION['summary'] : '';
// Mengambil pengalaman dari sesi, jika tidak ada, tetapkan nilai kosong
$experience = isset($_SESSION['experience']) ? $_SESSION['experience'] : '';
// Mengambil pendidikan dari sesi, jika tidak ada, tetapkan nilai kosong
$education = isset($_SESSION['education']) ? $_SESSION['education'] : '';
// Mengambil bahasa yang dikuasai dari sesi, jika tidak ada, tetapkan nilai kosong
$language = isset($_SESSION['language']) ? $_SESSION['language'] : '';

// Menutup koneksi database
mysqli_close($conn);
?>


<table border="1" style="border-collapse: collapse; border-color: #2A908F; height: 100%; width: 100%; position: absolute; " >
    <tr>
        <td style="border-color: #264653; width: 10%; background-color: #264653; ">
            <div class="sidebar">
                <a href="CVForge_2.html">
                    <input type="button" id="backbutton" value="Back">
                </a>
            </div> 
        </td>
        <td colspan="3" rowspan="2" style="border-left-color: #264653; ">
            <div class="main-content">
                <div class="deskripsi" style="padding-top: 65px; padding-bottom: 80px;">
                    <h2 style="padding-left: 50px; padding-bottom: 10px;">Professional Summary</h2>
                    <p align="justify" style="padding-left: 50px; padding-right: 50px; height: 100px;"><?php echo $summary; ?></p>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td style="border-color: #264653; background-color: #264653;">
            <div class="sidebar">
                <center>
                    <?php
                    if (!empty($image)) {
                        echo '<img src="uploaded_img/' . $image . '" alt="Profile Picture">';
                    }
                    ?>
                </center>
            </div>
        </td>
    </tr>
    <tr>
        <td style="border-color: #264653; background-color: #264653;">
            <div class="datadiri">
                <center>
                    <p><b><?php echo $username;?></b><br>
                    <br><?php echo $email;?><br>
                    <br><?php echo $notelp;?><br>
                    <br><?php echo $alamat;?></p>
                    <a href="Setting.php">
                        <input type="button" id="setting" value="Settings">
                    </a>
                </center>
            </div>
        </td>
        <td>
            <div class="main-content">
                <div class="deskripsi">
                    <div class="kotak">
                        <h2>Experience</h2>
                        <p><?php echo $experience;?></p>
                    </div>
                </div>
            </div>
        </td>
        <td>
            <div class="main-content">
                <div class="deskripsi">
                    <div class="kotak">
                        <h2>Education</h2>
                        <p><?php echo $education;?></p>
                    </div>
                </div>
            </div>
        </td>
        <td>
            <div class="main-content">
                <div class="deskripsi">
                    <div class="kotak">
                        <h2>Languages</h2>
                        <p><?php echo $language;?></p>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
</body>
</html>