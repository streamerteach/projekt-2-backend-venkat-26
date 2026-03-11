<?php
    require_once __DIR__ . '/../inc/config.php';
    if (! defined('APP_STARTED')) {
    exit;
    }
 //Initialize products in session if not already set
 if(!isset($_SESSION['products'])){
  $_SESSION['products'] = [
    [
      'name' => 'Reusable Water Bottle',
      'description' => 'Eco-friendly and BPA-free.',
      'price' => 15.99,
      'image' => 'images/bottle.jpg'
  ],
  [
      'name' => 'Organic Cotton Tote Bag',
      'description' => 'Perfect for groceries and shopping.',
      'price' => 12.50,
      'image' => 'images/tote.jpg'
  ],
  [
      'name' => 'Solar-Powered Lamp',
      'description' => 'Energy-saving outdoor lamp.',
      'price' => 25.00,
      'image' => 'images/lamp.png'
  ]
  ];
 }
  

$products = $_SESSION['products'];
?>

<main class="product-page">
<h2>Available Products</h2>
 <div class="product-listing">
  <?php foreach ($products as $product): ?>
    <div class="product-card">
      <!-- Product details can be added here -->
       <img src="<?php echo BASE_URL . '/' . $product['image']; ?>" 
       alt="<?php echo htmlspecialchars($product['name']); ?>">
       <h3> <?php echo htmlspecialchars($product['name']); ?> </h3>
       <p><?php echo htmlspecialchars($product['description']); ?> </p>
       <p> Price: $<?php echo $product['price']; ?> </p>
    </div>
  <?php endforeach; ?>
 </div>
</main>