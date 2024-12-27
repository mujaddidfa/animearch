<?php
include "connection.php";

$id = $_GET['id'];

$result = mysqli_query($con, "SELECT * FROM anime WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Data anime tidak ditemukan.";
    exit;
}

session_start();
?>

<html>

<head>
    <title>Detail Anime</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .detail-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 16px;
        }
        .detail-container .poster {
            flex: 1;
            max-width: 300px;
            margin-right: 16px;
        }
        .detail-container .poster img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }
        .detail-container .details {
            flex: 2;
        }
        .details h1 {
            font-size: 2em;
            margin-bottom: 0.5em;
        }
        .details p {
            margin: 0.5em 0;
        }
        .details .actions {
            margin-top: 1em;
        }
        .details .actions a {
            margin-right: 1em;
            text-decoration: none;
            padding: 0.5em 1em;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="detail-container row">
            <div class="poster col-md-4">
                <img src="poster/<?php echo $row['poster']; ?>" alt="<?php echo $row['title']; ?>" class="img-fluid">
            </div>
            <div class="details col-md-8">
                <h1><?php echo $row['title']; ?></h1>
                <p><strong>Genre:</strong> <?php echo $row['genre']; ?></p>
                <p><strong>Tahun Rilis:</strong> <?php echo $row['release_date']; ?></p>
                <p><strong>Deskripsi:</strong> <?php echo $row['description']; ?></p>
                <div class="actions">
                    <?php if ($_SESSION["role"] == "admin"): ?>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                    <?php endif; ?>
                    <a href="print_anime.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Print</a>
                </div>
                <br>
                <a href="index.php" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</body>

</html>