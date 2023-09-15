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
    $formTemplateType = $_POST["templateType"];

    // Memeriksa apakah delete button telah diklik
    if (isset($_POST["delete-btn"])) {
        $deleteId = $_POST["deleteId"];

        // Menghapus data dari database berdasarkan templateType
        if ($formTemplateType === "ATS") {
            $deleteStmt = $conn->prepare("DELETE FROM template_ATS WHERE id = ?");
        } elseif ($formTemplateType === "Modern") {
            $deleteStmt = $conn->prepare("DELETE FROM template_Modern WHERE id = ?");
        }

        if (!$deleteStmt) {
            die("Pernyataan SQL error: " . $conn->error);
        }

        $deleteStmt->bind_param("i", $deleteId);

        if ($deleteStmt->execute()) {
            echo '<script>alert("Data berhasil dihapus.")</script>';
            header("Location: Template_Admin.php");
            exit();
        } else {
            echo '<script>alert("Terjadi kesalahan saat menghapus data.")</script>';
        }

        $deleteStmt->close();
    } else {
        // Memeriksa apakah file telah diunggah
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $formImageTmp = $_FILES["image"]["tmp_name"];
            $formImageName = $_FILES["image"]["name"];

            // Melakukan validasi untuk memastikan semua input terisi
            if (empty($formTemplateType) || empty($formImageName)) {
                echo '<script>alert("Mohon untuk mengisi semua data.")</script>';
            } else {
                // Mengecek apakah direktori template/ sudah ada, jika belum maka buat direktori tersebut
                if (!is_dir('template/')) {
                    mkdir('template/');
                }

                // Mengecek apakah direktori template/ATS/ sudah ada, jika belum maka buat direktori tersebut
                if (!is_dir('template/ATS/')) {
                    mkdir('template/ATS/');
                }

                // Mengecek apakah direktori template/Modern/ sudah ada, jika belum maka buat direktori tersebut
                if (!is_dir('template/Modern/')) {
                    mkdir('template/Modern/');
                }

                // Menyimpan gambar yang diunggah ke dalam folder yang sesuai dengan templateType
                if ($formTemplateType === "ATS") {
                    move_uploaded_file($formImageTmp, 'template/ATS/' . $formImageName);
                } elseif ($formTemplateType === "Modern") {
                    move_uploaded_file($formImageTmp, 'template/Modern/' . $formImageName);
                }

                // Menyimpan data gambar ke dalam database
                if ($formTemplateType === "ATS") {
                    $stmt = $conn->prepare("INSERT INTO template_ATS (ATS) VALUES (?)");
                    $stmt->bind_param("s", $formImageName);
                } elseif ($formTemplateType === "Modern") {
                    $stmt = $conn->prepare("INSERT INTO template_Modern (Modern) VALUES (?)");
                    $stmt->bind_param("s", $formImageName);
                }

                if (!$stmt) {
                    die("Pernyataan SQL error: " . $conn->error);
                }

                // Menjalankan pernyataan SQL
                if ($stmt->execute()) {
                    echo '<script>alert("Gambar berhasil diunggah dan data berhasil disimpan.")</script>';
                    header("Location: Template_Admin.php");
                    exit();
                } else {
                    echo '<script>alert("Terjadi kesalahan saat mengunggah gambar atau menyimpan data.")</script>';
                }

                $stmt->close();
            }
        } else {
            echo '<script>alert("Terjadi kesalahan saat mengunggah file.")</script>';
        }
    }
}

// Menampilkan tabel Template_ATS
$sqlATS = "SELECT * FROM template_ATS";
$resultATS = $conn->query($sqlATS);

// Menampilkan tabel Template_Modern
$sqlModern = "SELECT * FROM template_Modern";
$resultModern = $conn->query($sqlModern);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link href="tempadmin.css" rel="stylesheet" type="text/css">
    <title>CVForge</title>
</head>
<body>
<form>
    <nav>
        <ul>
            <li style="font-size: 200%;"><a href="Admin.php"><b>CVForge</b></a></li>
            <li style="margin-top: 8px; font-size: 20px;"><a href="User.php">User</a></li>
            <li style="margin-top: 8px; font-size: 20px;"><a href="Template_Admin.php">Template CV</a></li>
            <span style="float: right">
                <li style="margin-top: 8px; font-size: 20px;"><a href="CVForge_1.html">Logout</a></li>
            </span>
        </ul>
    </nav>
</form>

<div class="container" style="left: 400px">
    <h1>ATS</h1>
            <form method="POST" enctype="multipart/form-data">
                <left>
                <div class="form-elem">
                    <label for="" class="form-label"></label>
                    <input name="image" type="file" class="form-control image" id="" accept="image/*">
                    <input type="hidden" name="templateType" value="ATS">
                    <input type="submit" name="submit" value="Upload Image" id="upload" style="margin-bottom: 30px; margin-left: 75px">
                </div>
                </left>
            </form>
            <div class="scroll-table">
            <table id="ats-table">
                <tr>
                    <th>ID</th>
                    <th>ATS</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($resultATS->num_rows > 0) {
                    while ($row = $resultATS->fetch_assoc()) {

                        echo "<tr>";
                        echo "<b>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["ATS"] . "</td>";
                        echo '<td><form method="POST"><input type="hidden" name="templateType" value="ATS"><input type="hidden" name="deleteId" value="' . $row["id"] . '"><input type="submit" name="delete-btn" value="Delete" class="delete-btn"></form></td>';
                        echo "</b>";
                        echo "</tr>";

                    }
                } else {
                    echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
                }
                ?>
            </table>
            </div>
        </div>
</div>

<div class="container" align="right" style="right: -175px;">
    <h1>Modern</h1>
    <form method="POST" enctype="multipart/form-data">
        <left>
        <div class="form-elem">
            <label for="" class="form-label"></label>
            <input name="image" type="file" class="form-control image" id="" accept="image/*">
            <input type="hidden" name="templateType" value="Modern">
            <input type="submit" name="submit" value="Upload Image" id="upload" style="margin-bottom: 30px; margin-left: 75px">
        </div>
        </left>
    </form>
    <div class="scroll-table">
    <table id="ats-table">
        <tr>
            <th>ID</th>
            <th>Modern</th>
            <th>Action</th>
        </tr>
        <?php
        if ($resultModern->num_rows > 0) {
            while ($row = $resultModern->fetch_assoc()) {

                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["Modern"] . "</td>";
                echo '<td><form method="POST"><input type="hidden" name="templateType" value="Modern"><input type="hidden" name="deleteId" value="' . $row["id"] . '"><input type="submit" name="delete-btn" value="Delete" class="delete-btn"></form></td>';
                echo "</tr>";

            }
        } else {
            echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
        }
        ?>
    </table>
    </div>
</div>
</body>
</html>
