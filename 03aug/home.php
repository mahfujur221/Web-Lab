<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Coffee Shop | Home</title>
 <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Navbar -->
<header class="bg-white shadow">
  <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-brown-800">Coffee Heaven ☕</h1>
    <nav class="space-x-6">
      <a href="home.php" class="text-gray-700 hover:text-brown-700 font-medium">Home</a>
      <a href="#about" class="text-gray-700 hover:text-brown-700 font-medium">About Us</a>
      <a href="login.php" class="text-blue-600 hover:underline font-medium">Login</a>
      <a href="register.php" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 font-medium">Register</a>
    </nav>
  </div>
</header>

<!-- Hero Section -->
<section class="bg-[url('https://images.unsplash.com/photo-1541167760496-1628856ab772')] bg-cover bg-center h-[500px] flex items-center justify-center text-white">
  <div class="bg-black bg-opacity-50 p-10 rounded">
    <h2 class="text-4xl font-bold mb-4">Start Your Day with a Perfect Brew</h2>
    <p class="text-lg mb-6">Fresh beans. Great taste. Best price.</p>
    <a href="#offers" class="bg-yellow-400 text-black px-5 py-2 rounded font-semibold hover:bg-yellow-300">See Offers</a>
  </div>
</section>

<!-- Offers Section -->
<section id="offers" class="py-16 px-4 md:px-12 lg:px-24 bg-white">
  <h3 class="text-3xl font-bold text-center mb-10">🔥 Today's Offers</h3>
  <div class="grid md:grid-cols-3 gap-8">
    <!-- Offer Card 1 -->
    <div class="bg-gray-100 p-6 rounded shadow hover:shadow-lg transition">
      <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348" alt="Coffee 1" class="w-full h-40 object-cover rounded mb-4">
      <h4 class="text-xl font-semibold mb-2">Caramel Latte</h4>
      <p class="text-gray-600 mb-2">Rich, creamy, and 20% off today!</p>
      <span class="inline-block bg-yellow-300 text-black px-3 py-1 rounded font-semibold text-sm">Only $3.99</span>
    </div>
    <!-- Offer Card 2 -->
    <div class="bg-gray-100 p-6 rounded shadow hover:shadow-lg transition">
      <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772" alt="Coffee 2" class="w-full h-40 object-cover rounded mb-4">
      <h4 class="text-xl font-semibold mb-2">Espresso Shot</h4>
      <p class="text-gray-600 mb-2">Strong, bold, and 30% off now!</p>
      <span class="inline-block bg-yellow-300 text-black px-3 py-1 rounded font-semibold text-sm">Only $2.49</span>
    </div>
    <!-- Offer Card 3 -->
    <div class="bg-gray-100 p-6 rounded shadow hover:shadow-lg transition">
      <img src="https://images.unsplash.com/photo-1552072092-7f9b8d63a104" alt="Coffee 3" class="w-full h-40 object-cover rounded mb-4">
      <h4 class="text-xl font-semibold mb-2">Mocha Delight</h4>
      <p class="text-gray-600 mb-2">Chocolatey twist, now 25% off!</p>
      <span class="inline-block bg-yellow-300 text-black px-3 py-1 rounded font-semibold text-sm">Only $4.25</span>
    </div>
  </div>
</section>

<!-- About Us Section -->
<section id="about" class="py-16 bg-gray-100 px-4 md:px-12 lg:px-24">
  <div class="max-w-4xl mx-auto text-center">
    <h3 class="text-3xl font-bold mb-6">About Us</h3>
    <p class="text-gray-700 text-lg">
      At Coffee Heaven, we blend passion and beans to bring you the best coffee experience in town. From sunrise to sunset, our brews will energize your soul and delight your taste buds.
    </p>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white border-t mt-16">
  <div class="max-w-7xl mx-auto py-6 px-4 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
    <p>&copy; <?= date("Y") ?> Coffee Heaven. All rights reserved.</p>
    <div class="space-x-4 mt-4 md:mt-0">
      <a href="home.php" class="hover:underline">Home</a>
      <a href="#about" class="hover:underline">About Us</a>
      <a href="login.php" class="hover:underline">Login</a>
      <a href="register.php" class="hover:underline">Register</a>
    </div>
  </div>
</footer>

</body>
</html>
