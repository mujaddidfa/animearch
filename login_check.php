<?php
include "connection.php";

$recaptcha_secret = "6Ld3h4YqAAAAAKUfd6Ne26Ls5k_7A9TwQow6_WNJ";
$recaptcha_response = $_POST['g-recaptcha-response'];

$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_data = array(
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response
);

$options = array(
    'http' => array(
        'method'  => 'POST',
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($recaptcha_data)
    )
);

$context  = stream_context_create($options);
$response = file_get_contents($recaptcha_url, false, $context);
$response_keys = json_decode($response, true);

if ($response_keys["success"]) {
    $id_user = $_POST['id_user'];
    $pass = md5($_POST['password']);
    $sql = "SELECT * FROM user WHERE id='$id_user' AND password='$pass'";
    $login = mysqli_query($con, $sql);

    $found = mysqli_num_rows($login);
    $r = mysqli_fetch_array($login);

    if ($found > 0) {
        session_start();
        $_SESSION["login"] = true;
        $_SESSION['iduser'] = $r['id'];
        $_SESSION['passuser'] = $r['password'];
        $_SESSION['role'] = $r['role'];
        header('location:index.php');
        exit;
    } else {
        echo "<script>alert('Login gagal! Username & password tidak benar'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Login gagal! reCAPTCHA tidak valid'); window.location.href='login.php';</script>";
}
?>