<?php
session_start();
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_email"])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "coffee_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userEmail = $_SESSION["user_email"];
$success = "";
$error = "";

// Handle Add to Cart form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['coffee_id']) && isset($_POST['coffee_title'])) {
    $coffeeId = intval($_POST['coffee_id']);
    $coffeeTitle = $_POST['coffee_title'];

    // Check if coffee already in cart for this user email
    $checkQuery = "SELECT * FROM cart WHERE user_email = ? AND coffee_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("si", $userEmail, $coffeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Increment quantity if exists
        $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_email = ? AND coffee_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $userEmail, $coffeeId);
        if ($stmt->execute()) {
            $success = "Quantity updated in your cart for '{$coffeeTitle}'.";
        } else {
            $error = "Failed to update cart.";
        }
    } else {
        // Insert new cart item
        $insertQuery = "INSERT INTO cart (user_email, coffee_id, coffee_title, quantity) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sis", $userEmail, $coffeeId, $coffeeTitle);
        if ($stmt->execute()) {
            $success = "'{$coffeeTitle}' added to your cart.";
        } else {
            $error = "Failed to add to cart.";
        }
    }
}

// Fetch coffee data from API
$apiUrl = "https://api.sampleapis.com/coffee/hot";
$coffeeDataJson = file_get_contents($apiUrl);
$coffeeData = json_decode($coffeeDataJson, true);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Welcome to Coffee Heaven</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<header class="bg-white shadow p-4 flex justify-between items-center">
  <h1 class="text-xl font-bold">Coffee Heaven ☕</h1>
  <div class="flex items-center gap-4">
    <p>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</p>
    <a href="logout.php" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Logout</a>
  </div>
</header>

<main class="p-8">
  <?php if ($success): ?>
    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= $error ?></div>
  <?php endif; ?>

  <h2 class="text-3xl font-bold mb-4">Today’s Specials</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <?php if ($coffeeData && is_array($coffeeData)): ?>
      <?php foreach ($coffeeData as $coffee): ?>
        <div class="bg-white rounded shadow p-4 flex flex-col">
          <img src="<?= htmlspecialchars($coffee['image'] ?? '') ?>" alt="<?= htmlspecialchars($coffee['title'] ?? 'Coffee') ?>" class="rounded mb-2 h-40 object-cover w-full" />
          <h3 class="font-semibold"><?= htmlspecialchars($coffee['title'] ?? 'No Title') ?></h3>
          <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($coffee['description'] ?? '') ?></p>
          <?php if (!empty($coffee['ingredients']) && is_array($coffee['ingredients'])): ?>
            <ul class="text-xs text-gray-500 list-disc list-inside mb-4">
              <?php foreach ($coffee['ingredients'] as $ingredient): ?>
                <li><?= htmlspecialchars($ingredient) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <form method="POST" class="mt-auto">
            <input type="hidden" name="coffee_id" value="<?= intval($coffee['id']) ?>" />
            <input type="hidden" name="coffee_title" value="<?= htmlspecialchars($coffee['title']) ?>" />
            <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-300 font-semibold w-full">
              Buy
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No coffee data available.</p>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
