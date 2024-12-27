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
    <title>Halaman Utama</title>
</head>

<body>
    <a href="add.php">Tambah Data Baru</a>
    <br>
    <a href="logout.php">Logout</a>
    <br /><br />
    <?php
    if ($_SESSION["role"] == "admin") {
        echo "anda login sebagai admin";
    } else if ($_SESSION["role"] == "user") {
        echo "anda login sebagai user";
    }
    ?>
    <h1>Pencarian Anime</h1>
    <form id="searchForm" method="GET" action="index.php">
        <input type="text" id="searchInput" name="search" placeholder="Cari anime..." value="<?php echo htmlspecialchars($search); ?>" />
        <button type="submit">Cari</button>
    </form>
    <div id="result"></div>
    <table border=1>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Tahun Rilis</th>
            <th>Deskripsi</th>
            <th>Poster</th>
            <th>Update</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['genre'] . "</td>";
            echo "<td>" . $row['release_date'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td><img src='poster/$row[poster]' width='100'></td>";
            echo "<td><a href='edit.php?id=$row[id]'>Edit</a> | <a href='delete.php?id=$row[id]'>Delete</a> | <a href='print_anime.php?id=$row[id]'>Print</a></td></tr>";
        }
        ?>
    </table>
</body>

</html>