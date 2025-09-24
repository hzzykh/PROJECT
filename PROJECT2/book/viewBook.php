<?php

require_once "../classes/book.php";
$bookObj = new Book();

$search = $genre = "";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $search = isset($_GET["search"])? trim(htmlspecialchars($_GET["search"])) : "";
    $genre = isset($_GET["genre"])? trim(htmlspecialchars($_GET["genre"])) : "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
    <h1>Books</h1>
    <form action="" method="get">
        <label for="">Search (Title):</label>
        <input type="search" name="search" id="search" value="<?= $search ?>">
        <select name="genre" id="genre">
            <option value="">All</option>
            <option value="history" <?= ($genre == "history")? "selected":"" ?>>History</option>
            <option value="science" <?= ($genre == "science")? "selected":"" ?>>Science</option>
            <option value="fiction" <?= ($genre == "fiction")? "selected":"" ?>>Fiction</option>
        </select>
        <input type="submit" value="Search">
    </form>
    <button><a href="addbook.php">Add Book</a></button>
    <table border=1>
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
            <th>Publisher</th>
            <th>Copies</th>
        </tr>
        <?php
        $no = 1;
        foreach($bookObj->viewBooks($search, $genre) as $book){
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $book["title"] ?></td>
            <td><?= $book["author"] ?></td>
            <td><?= $book["genre"] ?></td>
            <td><?= $book["publication_year"] ?></td>
            <td><?= $book["publisher"] ?></td>
            <td><?= $book["copies"] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
