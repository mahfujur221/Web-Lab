<?php
// connection.php code inside this file
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_table";  // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO books (title, author, description) VALUES ('$title', '$author', '$description')";

    if ($conn->query($sql) === TRUE) {
        $message = "New book added successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Book</title>
</head>
<body>

<h2>Add a New Book</h2>

<?php if ($message) echo "<p>$message</p>"; ?>

<form method="post" action="">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Author:</label><br>
    <input type="text" name="author" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" cols="40" required></textarea><br><br>

    <input type="submit" value="Add Book">
</form>

</body>
</html>
