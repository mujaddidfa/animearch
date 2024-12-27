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

$review_result = mysqli_query($con, "SELECT * FROM reviews WHERE anime_id='$id' ORDER BY created_at DESC");

if (isset($_POST['submit_review'])) {
    $username = $_SESSION['iduser'];
    $review = $_POST['review'];
    $created_at = date('Y-m-d H:i:s');

    $insert_review = mysqli_query($con, "INSERT INTO reviews (anime_id, username, review, created_at) VALUES ('$id', '$username', '$review', '$created_at')");

    if ($insert_review) {
        echo "<script>alert('Review berhasil ditambahkan'); window.location.href='detail.php?id=$id';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan review'); window.location.href='detail.php?id=$id';</script>";
    }
}
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
        .review-container {
            margin-top: 2em;
        }
        .review {
            border-bottom: 1px solid #ccc;
            padding: 1em 0;
        }
        .review:last-child {
            border-bottom: none;
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
        <div class="review-container">
            <h2>Review</h2>
            <?php while ($review = mysqli_fetch_assoc($review_result)): ?>
                <div class="review">
                    <p><strong><?php echo $review['username']; ?></strong> <small><?php echo $review['created_at']; ?></small></p>
                    <p><?php echo $review['review']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="mt-4">
            <h3>Tambahkan Review</h3>
            <form method="POST" action="detail.php?id=<?php echo $id; ?>">
                <div class="form-group">
                    <textarea name="review" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit_review" class="btn btn-primary">Kirim Review</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>