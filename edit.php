<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$result = mysqli_query($con, "SELECT * FROM anime WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Data anime tidak ditemukan.";
    exit;
}

if (isset($_POST['update'])) {
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

    if (count($errors) > 0) {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('$error_message'); window.location.href='edit.php?id=$id';</script>";
        exit;
    }

    if (!empty($poster)) {
        $target_dir = "poster/";
        $target_file = $target_dir . basename($poster);

        $check = getimagesize($_FILES['poster']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
                // Update data with new poster
                $result = mysqli_query($con, "UPDATE anime SET title='$title', genre='$genre', release_date='$release_date', description='$description', poster='$poster' WHERE id='$id'");
            } else {
                echo "Terdapat kesalahan saat mengupload file.";
                exit;
            }
        } else {
            echo "File yang diupload bukan gambar.";
            exit;
        }
    } else {
        $result = mysqli_query($con, "UPDATE anime SET title='$title', genre='$genre', release_date='$release_date', description='$description' WHERE id='$id'");
    }

    if ($result) {
        header("Location: detail.php?id=$id");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>AnimeArch | Edit Data Anime</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Edit Data Anime</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" name="title" class="form-control" id="title" value="<?php echo $row['title']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" name="genre" class="form-control" id="genre" value="<?php echo $row['genre']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="release_date">Tahun Rilis</label>
                                <input type="number" name="release_date" class="form-control" id="release_date" value="<?php echo $row['release_date']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" class="form-control" id="description"><?php echo $row['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="poster">Poster</label>
                                <input type="file" name="poster" class="form-control-file" id="poster">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="update" class="btn btn-primary btn-block">Update</button>
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