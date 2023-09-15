<!DOCTYPE html>
<html>
    <head>
        <link href="main.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <title>CVForge</title>
        <style>
            footer  {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                text-align: center;
                padding: 10px 0;
            }
            h1 {
                font-size: 36px;
                color: #333;
                margin-bottom: 20px;
                margin-top: 130px;
                color: #E9C46A;
            }
            .container-parent {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
            }
            .container-total {
                display: inline-block;
                margin: 20px;
                padding: 20px;
                background-color: #264653;
                border: 1px solid #ced4da;
                border-radius: 5px;
                width: 15%;
            }

            h4 {
                color: white;
                font-size: 24px;
                margin-bottom: 10px;
            }

            h5 {
                color: white;
                font-size: 18px;
            }
        </style>
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
    <center>
    <h1>Selamat Datang di Halaman Admin CVForge</h1>
    </center>
    <div class="container-parent">
    <div class="container-total">
        <h4 style="color:white;"><i class="fas fa-users"> Total User</i></h4>
        <h5 style="color:white;">
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "cvforge_database";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $excludedEmail = "admin@example.com";
                $sql = "SELECT COUNT(*) as total_users FROM user_register WHERE email != '$excludedEmail'";
                $result = $conn->query($sql);
                $count = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $count = $row['total_users'];
                }
                echo $count;
                ?></h5>       
    </div>
    <div class="container-total">
        <h4 style="color:white;"><i class="fas fa-file-alt"> Total Template</i></h4>
        <h5 style="color:white;">
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "cvforge_database";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sqlATS = "SELECT COUNT(*) as total_template_ats FROM template_ATS";
                $resultATS = $conn->query($sqlATS);
                $count = 0;
                if ($resultATS->num_rows > 0) {
                    $rowATS = $resultATS->fetch_assoc();
                    $countATS = $rowATS['total_template_ats'];
                }

                $sqlModern = "SELECT COUNT(*) AS total_template_modern FROM template_Modern";
                $resultModern = $conn->query($sqlModern);
                $countModern = 0;
                if ($resultModern->num_rows > 0) {
                    $rowModern = $resultModern->fetch_assoc();
                    $countModern = $rowModern['total_template_modern'];
                }

                $totalCount = $countATS + $countModern;
                echo $totalCount;
                ?></h5>       
    </div>
    </div>
    </body>
    <footer class = "footer bg-dark">
        <div class="container">
            <div class = "footer-content text-center">
                <p class="fs-15">&copy;Copyright 2023. All Rights Reserved - <span>Project Pemrograman Web</span></p>
            </div>
        </div>
    </footer>
</html>
