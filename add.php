<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include_once("connection.php");

if (isset($_POST['Submit'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_date = $_POST['release_date'];
    $description = $_POST['description'];
    $poster = $_FILES['poster']['name'];

    $errors = [];

    if (empty($title)) {
        $errors[] = "Judul harus diisi.";
    }

    if (empty($genre)) {
        $errors[] = "Genre harus diisi.";
    }

    if (empty($release_date)) {
        $errors[] = "Tahun rilis harus diisi.";
    }

    if (empty($description)) {
        $errors[] = "Deskripsi harus diisi.";
    }

    if (empty($poster)) {
        $errors[] = "Poster harus diupload.";
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "<a href='add.php'>Go back</a>";
        exit;
    }

    $target_dir = "poster/";
    $target_file = $target_dir . basename($poster);

    $check = getimagesize($_FILES['poster']['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
            $result = mysqli_query($con, "INSERT INTO anime(title, genre, release_date, description, poster) VALUES('$title', '$genre', '$release_date', '$description', '$poster')");
            
            if ($result) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>
<html>

<head>
    <title>Tambah data mahasiswa</title>
</head>

<body>
    <a href="index.php">Go to Home</a>
    <br /><br />
    <form method="POST" action="add.php" enctype="multipart/form-data">
        <table width="25%" border="0">
            <tr>
                <td>Judul</td>
                <td><input type="text" name="title"></td>
            </tr>
            <tr>
                <td>Genre</td>
                <td><input type="text" name="genre"></td>
            </tr>
            <tr>
                <td>Tahun Rilis</td>
                <td><input type="number" name="release_date"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="description"></td>
            </tr>
            <tr>
                <td>Poster</td>
                <td><input type="file" name="poster"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Submit" value="Tambah"></td>
            </tr>
        </table>
    </form>
</body>
</html>