<?php

require_once "config/database.php";

$name = "Administrator";
$email = "admin@gmail.com";
$password = "Admin@123";

/*
 * Cek apakah email sudah ada
 */

$sqlCheck = "SELECT id FROM admin WHERE email = :email LIMIT 1";

$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->bindParam(":email", $email);
$stmtCheck->execute();

$existing = $stmtCheck->fetch();

if ($existing) {

    echo "<h3>Admin sudah ada.</h3>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Silakan langsung login.";

    exit;

}

/*
 * Buat password
 */

if (function_exists("password_hash")) {

    $passwordHash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

} else {

    /*
     * Fallback untuk PHP lama
     */
    $passwordHash = hash(
        "sha256",
        $password
    );

}

/*
 * Insert admin
 */

$sql = "INSERT INTO admin
        (name, email, password)
        VALUES
        (:name, :email, :password)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":name", $name);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":password", $passwordHash);

$stmt->execute();

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Admin Berhasil Dibuat</title>

</head>

<body>

    <h2>Admin berhasil dibuat!</h2>

    <p>
        <strong>Nama:</strong>
        <?php echo htmlspecialchars($name); ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?php echo htmlspecialchars($email); ?>
    </p>

    <p>
        <strong>Password:</strong>
        <?php echo htmlspecialchars($password); ?>
    </p>

    <p>
        Silakan kembali ke halaman login.
    </p>

</body>

</html>