<?php
session_start();

$conn = new mysqli("localhost", "root", "", "coffee_shop");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST["identifier"]); // can be email or serial number
    $password = $_POST["password"];

    // Prepare query to check email or serial_number
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR serial_number = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Save user info in session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"]; // <-- Add this!

            // Redirect to coffee.php
            header("Location: coffee.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email or serial number.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block font-medium">Email or Serial Number</label>
            <input type="text" name="identifier" required class="w-full border rounded px-3 py-2" placeholder="Email or Serial Number" />
        </div>
        <div>
            <label class="block font-medium">Password</label>
            <input type="password" name="password" required class="w-full border rounded px-3 py-2" />
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</button>
    </form>

    <p class="mt-4 text-center text-sm">
        Don’t have an account? <a href="register.php" class="text-blue-600 hover:underline">Register here</a>
    </p>
</div>
</body>
</html>
