<?php

session_start();

if (!isset($_SESSION["admin_id"])) {

    header("Location: ../auth/login.php");
    exit;

}

$adminName = $_SESSION["admin_name"];
$adminEmail = $_SESSION["admin_email"];

?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="dashboard">

    <nav class="navbar">

        <div class="navbar-title">
           <img style="width:10%;" src="../assets/image/logo.png" alt="">

        </div>

        <a class="logout-btn" href="../auth/logout.php"
   onclick="return confirm('Apakah Anda yakin ingin logout?');">
    Logout
</a>

    </nav>

    <main class="dashboard-content">

        <div class="welcome-card">

            <h1>
                Selamat Datang,
                <?php echo htmlspecialchars($adminName); ?>!
            </h1>

            <p>
                Anda berhasil login ke dalam sistem
                admin.
            </p>

            <div class="info-box">

                <p>
                    <strong>Nama:</strong>
                    <?php echo htmlspecialchars($adminName); ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php echo htmlspecialchars($adminEmail); ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    Admin Aktif
                </p>

            </div>

        </div>

    </main>

</div>

</body>

</html>