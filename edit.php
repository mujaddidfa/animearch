<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include_once("connection.php");

$id = $_GET['id'];

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
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "<a href='edit.php?id=$id'>Go back</a>";
        exit;
    }

    $target_dir = "poster/";
    $target_file = $target_dir . basename($poster);

    if (!empty($poster)) {
        $check = getimagesize($_FILES['poster']['tmp_name']);
        if ($check !== false) {
            $result = mysqli_query($con, "SELECT poster FROM anime WHERE id='$id'");
            $row = mysqli_fetch_assoc($result);
            $current_poster = $row['poster'];
            
            if (!empty($current_poster) && file_exists($target_dir . $current_poster)) {
                unlink($target_dir . $current_poster);
            }
            
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
                $result = mysqli_query($con, "UPDATE anime SET title='$title', genre='$genre', release_date='$release_date', description='$description', poster='$poster' WHERE id='$id'");
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    } else {
        $result = mysqli_query($con, "UPDATE anime SET title='$title', genre='$genre', release_date='$release_date', description='$description' WHERE id='$id'");
    }

    if ($result) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>
<?php

$result = mysqli_query($con, "SELECT * FROM anime WHERE id='$id'");
while ($row = mysqli_fetch_array($result)) {
    $title = $row['title'];
    $genre = $row['genre'];
    $release_date = $row['release_date'];
    $description = $row['description'];
    $poster = $row['poster'];
}
?>
<html>

<head>
    <title>Edit Data Anime</title>
</head>

<body>
    <a href="index.php">Go to Home</a>
    <br /><br />
    <form method="POST" action="edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <table width="25%" border="0">
            <tr>
                <td>Judul</td>
                <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
            </tr>
            <tr>
                <td>Genre</td>
                <td><input type="text" name="genre" value="<?php echo $genre; ?>"></td>
            </tr>
            <tr>
                <td>Tahun Rilis</td>
                <td><input type="number" name="release_date" value="<?php echo $release_date; ?>"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><input type="text" name="description" value="<?php echo $description; ?>"></td>
            </tr>
            <tr>
                <td>Poster</td>
                <td><input type="file" name="poster"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>