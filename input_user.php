<?php
include "connection.php";

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

$errors = [];

if (empty($id)) {
    $errors[] = "Username harus diisi.";
}

if (empty($name)) {
    $errors[] = "Nama lengkap harus diisi.";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email harus diisi.";
}

if (empty($password)) {
    $errors[] = "Password harus diisi.";
}

if (empty($role) || !in_array($role, ['admin', 'user'])) {
    $errors[] = "Role yang dipilih tidak valid.";
}

$result = mysqli_query($con, "SELECT id FROM user WHERE id='$id'");
if (mysqli_num_rows($result) > 0) {
    $errors[] = "Username sudah digunakan.";
}

$result = mysqli_query($con, "SELECT email FROM user WHERE email='$email'");
if (mysqli_num_rows($result) > 0) {
    $errors[] = "Email sudah digunakan.";
}

if (count($errors) > 0) {
    $error_message = implode("\\n", $errors);
    echo "<script>alert('$error_message'); window.location.href='registration.php';</script>";
    exit;
}

$pass = md5($password);

$sql = "INSERT INTO user(id, password, name, email, role) VALUES ('$id', '$pass', '$name','$email','$role')";
$query = mysqli_query($con, $sql);

if ($query) {
    echo "<script>alert('Registrasi berhasil'); window.location.href='login.php';</script>";
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>