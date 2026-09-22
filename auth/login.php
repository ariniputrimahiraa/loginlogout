<?php

session_start();

require_once "../config/database.php";

/*
|--------------------------------------------------------------------------
| Mencegah halaman disimpan di cache browser
|--------------------------------------------------------------------------
*/

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");


/*
|--------------------------------------------------------------------------
| Jika admin sudah login
|--------------------------------------------------------------------------
*/

if (isset($_SESSION["admin_id"])) {

    header("Location: ../dashboard/index.php");
    exit;

}


$error = "";


/*
|--------------------------------------------------------------------------
| Proses Login
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = "";

    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
    }


    $password = "";

    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    }


    /*
    |--------------------------------------------------------------------------
    | Validasi
    |--------------------------------------------------------------------------
    */

    if ($email == "" || $password == "") {

        $error = "Email dan password wajib diisi.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Cari admin
        |--------------------------------------------------------------------------
        */

        $sql = "SELECT id, name, email, password
                FROM admin
                WHERE email = :email
                LIMIT 1";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":email", $email);

        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);


        /*
        |--------------------------------------------------------------------------
        | Verifikasi password
        |--------------------------------------------------------------------------
        */

        if ($admin && password_verify($password, $admin["password"])) {

            session_regenerate_id(true);

            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];
            $_SESSION["admin_email"] = $admin["email"];


            /*
            |--------------------------------------------------------------------------
            | Masuk Dashboard
            |--------------------------------------------------------------------------
            */

            header("Location: ../dashboard/index.php");
            exit;

        } else {

            $error = "Email atau password yang Anda masukkan salah.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin</title>

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>


<body>

<div class="login-page">

    <div class="login-card">


        <!-- Logo -->

        <div class="brand">

            <img
                style="width:30%;"
                src="../assets/image/logo2.png"
                alt="Logo Mahira Printing"
            >

        </div>


        <!-- Error -->

        <?php if ($error != "") { ?>

            <div class="alert alert-error">

                <?php echo htmlspecialchars($error); ?>

            </div>

        <?php } ?>


        <!-- Form Login -->

        <form
            method="POST"
            action=""
        >

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan email admin"
                    autocomplete="email"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>


                <div class="password-box">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >


                    <button
                        type="button"
                        id="togglePassword"
                        class="toggle-password"
                    >
                        Lihat
                    </button>

                </div>

            </div>


            <button
                type="submit"
                class="btn-login"
            >
                Masuk
            </button>

        </form>


        <!-- Footer -->

        <div class="login-footer">
            Login Admin
        </div>


    </div>

</div>


<script src="../assets/js/login.js"></script>


<!-- Mencegah halaman lama muncul dari cache saat tombol Back ditekan -->

<script>

window.addEventListener("pageshow", function (event) {

    if (event.persisted) {

        window.location.reload();

    }

});

</script>


</body>

</html>