<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['Submit'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_date = $_POST['release_date'];
    $description = $_POST['description'];
    $poster = $_FILES['poster']['name'];

    // Validasi input
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
        $error_message = implode("\\n", $errors);
        echo "<script>alert('$error_message'); window.location.href='add.php';</script>";
        exit;
    }

    $target_dir = "poster/";
    $target_file = $target_dir . basename($poster);

    $check = getimagesize($_FILES['poster']['tmp_name']);
    if ($check !== false) {
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
            // Insert data into database
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

<!DOCTYPE html>
<html>

<head>
    <title>AnimeArch | Tambah Data Anime</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Tambah Data Anime</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="add.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" name="title" class="form-control" id="title">
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" name="genre" class="form-control" id="genre">
                            </div>
                            <div class="form-group">
                                <label for="release_date">Tahun Rilis</label>
                                <input type="number" name="release_date" class="form-control" id="release_date">
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" class="form-control" id="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="poster">Poster</label>
                                <input type="file" name="poster" class="form-control-file" id="poster">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="Submit" class="btn btn-primary btn-block">Tambah</button>
                            </div>
                        </form>
                        <div class="text-center">
                            <a href="index.php" class="btn btn-secondary">Kembali ke Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>