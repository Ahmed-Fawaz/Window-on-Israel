<?php
include('db.php');

$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>
                <h3>" . $row["title"] . "</h3>
                <p>Author: " . $row["author"] . "</p>
                <p>Published: " . $row["published"] . "</p>
                <p>Category: " . $row["category"] . "</p>
                <p><a href='" . $row["download_link"] . "'>Download</a></p>
                <img src='" . $row["cover_image"] . "' alt='Cover Image'>
                <a href='edit_book.php?id=" . $row["id"] . "'>Edit</a>
                <a href='delete_book.php?id=" . $row["id"] . "'>Delete</a>
              </div>";
    }
} else {
    echo "0 results";
}
?>
