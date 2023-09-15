<!DOCTYPE html>
<html>
    <head>
        <link href="admin.css" rel="stylesheet" type="text/css">
        <title>User</title>
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
            <div class="container">
                <h1>User</h1>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "cvforge_database";

                    // Membuat koneksi
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Memeriksa koneksi
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }
                    
                    echo "<table border='3'>";
                    echo "<tr>";
                    echo "<th>Email</th>";
                    echo "<th>Username</th>";
                    echo "<th>No. Telp</th>";
                    echo "<th>Image PP</th>";
                    echo "<th>Alamat</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";

                    $sql2 = "SELECT u.email, s.username, s.notelp, s.image_pp, s.alamat 
                    FROM user_register u 
                    LEFT JOIN settings s ON u.email = s.email 
                    WHERE u.email != 'admin@example.com'";
                    $result = $conn->query($sql2);

                    if ($result->num_rows > 0) {
                        // Menampilkan data ke dalam tabel
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr align='center'>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . $row["notelp"] . "</td>";
                            echo "<td>" . $row["image_pp"] . "</td>";
                            echo "<td>" . $row["alamat"] . "</td>";
                            echo "<td>";
                            echo "<form method='POST'>";
                            echo "<input type='hidden' name='email' value='" . $row["email"] . "'>";
                            echo "<button class='delete-btn' type='submit' name='delete-btn'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Tidak ada data.";
                    }

                    // Tombol "Delete" di-klik
                    if (isset($_POST["delete-btn"])) {
                        $email = $_POST["email"];

                        // Nonaktifkan pengecekan kunci asing sementara
                        $conn->query("SET FOREIGN_KEY_CHECKS = 0");

                        // Hapus data dari tabel `settings` terlebih dahulu
                        $deleteSettingsQuery = "DELETE FROM settings WHERE email = '$email'";
                        if ($conn->query($deleteSettingsQuery) === TRUE) {
                            // Setelah menghapus data dari tabel `settings`, hapus data dari tabel `user_register`
                            $deleteUserQuery = "DELETE FROM user_register WHERE email = '$email'";
                            if ($conn->query($deleteUserQuery) === TRUE) {
                                echo "<script>alert('Data berhasil dihapus.')";
                            } else {
                                echo "<script>alert('Gagal menghapus data.')";
                            }
                        } else {
                            echo "<script>alert('Gagal menghapus data.')";
                        }

                        // Aktifkan kembali pengecekan kunci asing
                        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
                    }

                    // Menutup koneksi
                    $conn->close();

                    ?>
            </div>
    </body>
</html>
