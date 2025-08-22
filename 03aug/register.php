<?php
// Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'coffee_shop';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $rawPassword = $_POST['password'];

    // Validate Email Format
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@diu\.edu\.bd$/', $email)) {
        $error = "Email must end with @diu.edu.bd.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $dob)) {
        $error = "Invalid date format.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*@).{6,}$/', $rawPassword)) {
        $error = "Password must have at least one uppercase letter, one lowercase letter, one number, one @ symbol, and be at least 6 characters.";
    } else {
        // Check for existing email
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $existingUser = $stmt->get_result()->fetch_assoc();

        if ($existingUser) {
            $error = "This email is already registered.";
        } else {
            $dobObj = DateTime::createFromFormat('Y-m-d', $dob);
            $yearCode = $dobObj->format("Y");

            // Get today's increment number for this birth year
            $checkCountQuery = "SELECT COUNT(*) as total FROM users WHERE YEAR(dob) = ?";
            $stmt = $conn->prepare($checkCountQuery);
            $birthYear = $dobObj->format("Y");
            $stmt->bind_param("s", $birthYear);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $autoNumber = str_pad($result['total'] + 1, 3, '0', STR_PAD_LEFT);

            $serialNumber = $yearCode . '-' . $autoNumber;
            $passwordHash = password_hash($rawPassword, PASSWORD_DEFAULT);

            // Insert into DB
            $insertQuery = "INSERT INTO users (name, email, dob, serial_number, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssss", $name, $email, $dob, $serialNumber, $passwordHash);

            if ($stmt->execute()) {
                $success = "Registered successfully! Your Serial: $serialNumber";
            } else {
                $error = "Database error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Registration</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

  <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Register</h2>

    <?php if ($success): ?>
      <div class="bg-green-100 text-green-700 p-3 mb-4 rounded text-center"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 rounded text-center"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-5">
      <div>
        <label class="block font-semibold text-gray-700 mb-1">Full Name</label>
        <input type="text" name="name" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <div>
        <label class="block font-semibold text-gray-700 mb-1">Email <span class="text-sm text-gray-500">(@diu.edu.bd only)</span></label>
        <input type="email" name="email" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <div>
        <label class="block font-semibold text-gray-700 mb-1">Date of Birth</label>
        <input type="date" name="dob" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <div>
        <label class="block font-semibold text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required placeholder="Min 6 chars, include @, A-Z, a-z, 0-9" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <div>
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
          Register
        </button>
      </div>
    </form>
  </div>

</body>
</html>
