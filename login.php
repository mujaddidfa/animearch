<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'connection.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>AnimeArch - Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            background-image: url('assets/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">AnimeArch - Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="login_check.php">
                            <div class="form-group">
                                <label for="id_user">Username</label>
                                <input type="text" name="id_user" id="id_user" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Ld3h4YqAAAAAFW5z5C8t0m48tTFGOwiVIoY2qB-"></div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                            </div>
                            <div class="form-group text-center">
                                <a href="registration.php">Daftar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>