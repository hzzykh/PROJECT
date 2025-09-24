<?php

require_once "../classes/book.php";
$bookObj = new Book();

$book = [
    "title" => "",
    "author" => "",
    "genre" => "",
    "publication_year" => "",
    "publisher" => "",
    "copies" => ""
];

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));
    $book["publisher"] = trim(htmlspecialchars($_POST["publisher"]));
    $book["copies"] = trim(htmlspecialchars($_POST["copies"]));

    // validations
    if (empty($book["title"])) {
        $errors["title"] = "Book title is required";
    } elseif ($bookObj->isBookExist($book["title"])) {
        $errors["title"] = "Book title already exists";
    }

    if (empty($book["author"])) {
        $errors["author"] = "Author is required";
    }

    if (empty($book["genre"])) {
        $errors["genre"] = "Please select a genre";
    }

    if (empty($book["publication_year"]) || (int)$book["publication_year"] > (int)date("Y")) {
        $errors["publication_year"] = "Publication year is required and must not be in the future";
    }

    if (empty($book["publisher"])) {
        $errors["publisher"] = "Publisher is required";
    }

    if ($book["copies"] === "") {
        $errors["copies"] = "Number of copies is required";
    } elseif (!is_numeric($book["copies"]) || $book["copies"] < 1) {
        $errors["copies"] = "Copies must be a number greater than 0";
    }

    // save if no errors
    if (empty($errors)) {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];
        $bookObj->publisher = $book["publisher"];
        $bookObj->copies = $book["copies"];

        if ($bookObj->addBook()) {
            header("Location: viewbook.php");
            exit;
        } else {
            echo "Error saving book.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        label { display: block; }
        span { color: red; }
        p.error { color: red; margin: 0; }
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <label>Fields with <span>*</span> are required</label>
    <form action="" method="post">
        <label for="title">Book Title <span>*</span></label>
        <input type="text" name="title" id="title" value="<?= $book["title"] ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label for="author">Author <span>*</span></label>
        <input type="text" name="author" id="author" value="<?= $book["author"] ?>">
        <p class="error"><?= $errors["author"] ?? "" ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--Select--</option>
            <option value="history" <?= ($book["genre"] == "history") ? "selected" : "" ?>>History</option>
            <option value="science" <?= ($book["genre"] == "science") ? "selected" : "" ?>>Science</option>
            <option value="fiction" <?= ($book["genre"] == "fiction") ? "selected" : "" ?>>Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?? "" ?></p>

        <label for="publication_year">Publication Year <span>*</span></label>
        <input type="text" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?>">
        <p class="error"><?= $errors["publication_year"] ?? "" ?></p>

        <label for="publisher">Publisher <span>*</span></label>
        <input type="text" name="publisher" id="publisher" value="<?= $book["publisher"] ?>">
        <p class="error"><?= $errors["publisher"] ?? "" ?></p>

        <label for="copies">Copies <span>*</span></label>
        <input type="text" name="copies" id="copies" value="<?= $book["copies"] ?>">
        <p class="error"><?= $errors["copies"] ?? "" ?></p>

        <br><br>
        <input type="submit" value="Save Book">
    </form>
</body>
</html>
