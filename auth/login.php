<?php
session_start();

require_once "../config/database.php";

if (isset($_SESSION["admin_id"])) {
    header("Location: ../dashboard/index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi.";
    } else {
        $sql = "SELECT id, name, email, password FROM admin WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array("email" => $email));
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin["password"])) {
            session_regenerate_id(true);
            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];
            $_SESSION["admin_email"] = $admin["email"];

            header("Location: ../dashboard/index.php");
            exit;
        } else {
            $error = "Email atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Mahira Printing</title>
   <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body>

<div class="login-page">
    <div class="login-card">

        <div class="brand">
            <img src="../assets/image/logo2.png" alt="Mahira Printing">
        </div>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <form method="POST" action="">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email" required>
            </div>

           <div class="form-group">
    <label for="password">Password</label>
    <div class="password-box">
        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        <button type="button" class="toggle-password" id="togglePassword">Lihat</button>
    </div>
</div>

            <button type="submit" class="btn-login">Login</button>

        </form>

    </div>
</div>

<script src="../assets/js/login.js"></script>

</body>
</html>