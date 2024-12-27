<?php
include_once("connection.php");

$id = $_GET['id'];

$result = mysqli_query($con, "SELECT poster FROM anime WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
$poster = $row['poster'];

$result = mysqli_query($con, "DELETE FROM anime WHERE id='$id'");

if ($result) {
    $target_dir = "poster/";
    $target_file = $target_dir . $poster;
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    header("Location: index.php");
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>