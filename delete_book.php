
<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // استعلام لحذف الكتاب
    $sql = "DELETE FROM books WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "تم حذف الكتاب بنجاح";
    } else {
        echo "خطأ في الحذف: " . $conn->error;
    }
}
?>
