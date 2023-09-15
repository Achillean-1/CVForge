<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- custom css -->
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <style>
        input[id="submit"] {
            font-family: sans-serif;
            font-size: 15px;
            font-weight: bold;
            background: #E9C46A;
            text-align: center;
            color: #264653;
            border-color: #264653;
            border-radius: 15px;
            padding: 10px;
            margin-top: 20px;
        }

        input[id=backbutton]{
            font-family: sans-serif;
            font-size: 15px;
            font-weight: bold;
            background: #E9C46A;
            text-align: center;
            color: #264653;
            border-color: #264653;
            border-radius: 15px;
            padding: 10px;
            margin-top: 10px;
            margin-left: 10px;
        }
    </style>

<?php
session_start();

// Mengatur koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cvforge_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi ke database
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari form
    $formUsername = $_POST["username"];
    $formEmail = $_POST["email"];
    $formNotelp = $_POST["notelp"];
    $formImageTmp = $_FILES["image"]["tmp_name"];
    $formImageName = $_FILES["image"]["name"];
    $formAlamat = $_POST["alamat"];
    $summary = substr($_POST['summary'], 0, 660);
    $experience = substr($_POST['experience'], 0, 100);
    $education = substr($_POST['education'], 0, 100);
    $language = substr($_POST['language'], 0, 100); 

    $_SESSION['summary'] = $summary;
    $_SESSION['experience'] = $experience;
    $_SESSION['education'] = $education;
    $_SESSION['language'] = $language;

    // Melakukan validasi untuk memastikan semua input terisi
    if (empty($formUsername) || empty($formEmail) || empty($formNotelp) || empty($formImageName) || empty($formAlamat)) {
        echo '<script>alert("Mohon untuk mengisi semua data.")</script>';
    } else {
        // Mengecek apakah email sudah ada dalam database
        $stmt = $conn->prepare("SELECT email FROM settings WHERE email = ?");
        $stmt->bind_param("s", $formEmail);
        $stmt->execute();
        $stmt->store_result();
        $emailExists = $stmt->num_rows > 0;
        $stmt->close();

        if ($emailExists) {
            // Email sudah ada dalam database, lakukan pembaruan (update) data
            $stmt = $conn->prepare("UPDATE settings SET username = ?, notelp = ?, image_pp = ?, alamat = ? WHERE email = ?");
            $stmt->bind_param("sssss", $formUsername, $formNotelp, $formImageName, $formAlamat, $formEmail);
        }
        
        if (!$stmt) {
            die("Pernyataan SQL error: " . $conn->error);
        }

        // Menjalankan pernyataan SQL
        if ($stmt->execute()) {
            // Menyimpan nilai "summary" ke dalam session
            $_SESSION["summary"] = $summary;

            // Memeriksa apakah gambar diunggah
            if (!empty($formImageTmp)) {
                // Memeriksa apakah direktori uploaded_img/ sudah ada, jika belum maka buat direktori tersebut
                if (!is_dir('uploaded_img/')) {
                    mkdir('uploaded_img/');
                }

                // Menyimpan gambar yang diunggah ke direktori uploaded_img/
                move_uploaded_file($formImageTmp, 'uploaded_img/' . $formImageName);
            }

            echo '<script>alert("Data berhasil disimpan.")</script>';
            header("Location: Profile.php");
            exit();
        } else {
            echo '<script>alert("Terjadi kesalahan saat menyimpan data.")</script>';
        }

        $stmt->close();
    }
}

$conn->close();
?>
    <a href="Profile.php">
        <input type="button" id="backbutton" value="Back">
    </a>
    <section id="about-sc">
        <div class="container">
            <div class="about-cnt">
                <form action="" method="POST" class="cv-form" enctype="multipart/form-data">
                    <div class="form-content">
                        <h2>Settings</h2>
                        <div class="row">
                            <div class="cols-3">
                                <div class="form-elem">
                                    <label for="" class="form-label">Username</label>
                                    <input name="username" type="text" class="form-control username" id=""
                                        onkeyup="generateCV()">
                                    <span class="form-text"></span>
                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Email</label>
                                    <input name="email" type="text" class="form-control email" id=""
                                        onkeyup="generateCV()">
                                    <span class="form-text"></span>
                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Nomor Telepon</label>
                                    <input name="notelp" type="text" class="form-control notelp" id=""
                                        onkeyup="generateCV()">
                                    <span class="form-text"></span>
                                </div>
                            </div>

                            <div class="cols-3">
                                <div class="form-elem">
                                    <label for="" class="form-label">Profile Picture</label>
                                    <input name="image" type="file" class="form-control image" id="" accept="image/*"
                                        onchange="previewImage()">
                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Alamat</label>
                                    <input name="alamat" type="text" class="form-control alamat" id=""
                                        onkeyup="generateCV()">
                                    <span class="form-text"></span>
                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Professional Summary</label>
                                    <input name="summary" type="text" class="form-control summary" id="summary"
                                        onkeyup="generateCV()">
                                    <span class="form-text"></span>
                                </div>
                            </div>

                            <div class="cols-3">
                                <div class="form-elem">
                                    <label for="" class="form-label">Experience</label>
                                    <input name="experience" type="text" class="form-control experience" id="experience"
                                        onkeyup="generateCV()">
                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Education</label>
                                    <input name="education" type="text" class="form-control education" id="education"
                                        onkeyup="generateCV()">
                                    <span class="form-text"></span>
                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Language</label>
                                    <input name="language" type="text" class="form-control language" id="language"
                                        onkeyup="generateCV()">
                                    <span class="form-text"></span>
                                </div>
                            </div>
                        </div>
                        <input type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>