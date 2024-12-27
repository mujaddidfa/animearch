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
    <title>Halaman Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <h1>Halaman Login</h1>
    <form method=post action=login_check.php>
        <table>
            <tr>
                <td>Username</td>
                <td> : <input name='id_user' type='text'></td>
            </tr>
            <tr>
                <td>Password</td>
                <td> : <input name='password' type='password'></td>
            </tr>
            <tr><td>Captcha<br>
                <td>
                    <div class="g-recaptcha" data-sitekey="6Ld3h4YqAAAAAFW5z5C8t0m48tTFGOwiVIoY2qB-"></div>
                </td>
            <tr>
                <td colspan=><input type='submit' value='LOGIN'></td>
                <td><a href="registration.php">Registrasi</a></td>
            </tr>
        </table>
    </form>
</body>
</html>