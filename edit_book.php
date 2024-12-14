<?php
include('db.php');

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id=$id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published = $_POST['published'];
    $category = $_POST['category'];
    $download_link = $_POST['download_link'];
    $cover_image = $_POST['cover_image'];

    $sql = "UPDATE books SET title='$title', author='$author', published='$published', 
            category='$category', download_link='$download_link', cover_image='$cover_image' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post">
    <label>Title:</label><input type="text" name="title" value="<?php echo $book['title']; ?>" required><br>
    <label>Author:</label><input type="text" name="author" value="<?php echo $book['author']; ?>" required><br>
    <label>Published:</label><input type="text" name="published" value="<?php echo $book['published']; ?>"><br>
    <label>Category:</label><input type="text" name="category" value="<?php echo $book['category']; ?>"><br>
    <label>Download Link:</label><input type="text" name="download_link" value="<?php echo $book['download_link']; ?>"><br>
    <label>Cover Image:</label><input type="text" name="cover_image" value="<?php echo $book['cover_image']; ?>"><br>
    <button type="submit">Update Book</button>
</form>
