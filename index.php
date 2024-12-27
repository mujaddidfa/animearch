<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
}

$query = "SELECT * FROM anime";
if (!empty($search)) {
    $query .= " WHERE title LIKE '%$search%' OR genre LIKE '%$search%' OR description LIKE '%$search%'";
}

$result = mysqli_query($con, $query);

?>

<html>

<head>
    <title>AnimeArch</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card img {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-4">
            <?php if ($_SESSION["role"] == "admin"): ?>
                <a href="add.php" class="btn btn-primary">Tambah Data Baru</a>
            <?php endif; ?>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
        <?php
        if ($_SESSION["role"] == "admin") {
            echo "<div class='alert alert-info'>Anda login sebagai admin</div>";
        } else if ($_SESSION["role"] == "user") {
            echo "<div class='alert alert-info'>Anda login sebagai user</div>";
        }
        ?>
        <h1>Selamat Datang, <?php echo $_SESSION['name'] ?></h1>
        <form id="searchForm" method="GET" action="index.php" class="form-inline mb-4">
            <input type="text" id="searchInput" name="search" class="form-control mr-2" placeholder="Cari anime..." value="<?php echo htmlspecialchars($search); ?>" />
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='poster/$row[poster]' class='card-img-top' alt='$row[title]'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>$row[title]</h5>";
                echo "<p class='card-text'>Genre: $row[genre]</p>";
                echo "<p class='card-text'>Tahun Rilis: $row[release_date]</p>";
                echo "<a href='detail.php?id=$row[id]' class='btn btn-primary'>Detail</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>