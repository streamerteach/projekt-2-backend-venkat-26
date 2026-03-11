<?php
    require_once __DIR__ . '/../inc/config.php';
    if (! defined('APP_STARTED')) {
    exit;
    }

    $stmt = $conn->prepare("SELECT * FROM listings");
    $stmt->execute();

    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // print_r($listings);

 //Initialize products in session if not already set
 /*if(!isset($_SESSION['products'])){
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
 }*/
  
?>
<main class="product-page">
<h2>Available Products</h2>
 <div class="product-listing">
  <?php foreach ($listings as $listing): ?>
    
      <div class="product-card"><a href="<?= BASE_URL ?>/index.php?page=listing&id=<?= $listing['id'] ?>">
      <!-- Product details can be added here -->
        <img src="<?= BASE_URL ?>/images/<?= $listing['img_path'] ?>" 
        alt="<?php echo htmlspecialchars($listing['name']); ?>">
        <h3> <?php echo htmlspecialchars($listing['name']); ?> </h3>
        <p><?php echo htmlspecialchars($listing['description']); ?> </p>
        <p> Price: <?php echo $listing['price']; ?>€</p>
      </a></div>
    
  <?php endforeach; ?>
 </div>
</main>