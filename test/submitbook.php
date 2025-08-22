<?php
$servername = "127.0.0.1"; // safer than "localhost"
$username = "root";
$password = "";
$dbname = "book_table";

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
        echo '
        <div id="successModal" style="
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.5);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999; animation: fadeIn 1s forwards;">
            <div id="modalContent" style="
                background: #fff;
                padding: 30px 40px;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                text-align: center; animation: slideUp 0.5s forwards;">
                <h2>Success!</h2>
                <p>New record created successfully.</p>
            </div>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "table.php";
            }, 2000);
        </script>
        <style>
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes slideUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
        </style>
        ';
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!-- Form Part -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
</head>
<body>
    <h2>Add a New Book</h2>
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
