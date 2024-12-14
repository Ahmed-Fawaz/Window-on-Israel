<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published = $_POST['published'];
    $category = $_POST['category'];
    $download_link = $_POST['download_link'];
    $cover_image = $_POST['cover_image'];

    $sql = "INSERT INTO books (title, author, published, category, download_link, cover_image) 
            VALUES ('$title', '$author', '$published', '$category', '$download_link', '$cover_image')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post">
    <label>Title:</label><input type="text" name="title" required><br>
    <label>Author:</label><input type="text" name="author" required><br>
    <label>Published:</label><input type="text" name="published"><br>
    <label>Category:</label><input type="text" name="category"><br>
    <label>Download Link:</label><input type="text" name="download_link"><br>
    <label>Cover Image:</label><input type="text" name="cover_image"><br>
    <button type="submit">Add Book</button>
</form>
