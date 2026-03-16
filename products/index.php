<?php
    require_once __DIR__ . '/../inc/config.php';
    require_once __DIR__ . '/../inc/model_products.php';
    if (! defined('APP_STARTED')) {
    exit;
    }

/*    $stmt = $conn->prepare("SELECT * FROM listings");
    $stmt->execute();

    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // print_r($listings);

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
 }*/
  
?>
<main class="product-page">
<h2>Available Products</h2>

<div>
    <form action="" method="POST">
        <label for="sort-by" class="visually-hidden">Sort by:</label>

        <select name="sort" id="sort-by" onchange="this.form.submit()">
            <option value="newest" <?php echo (isset($_POST['sort']) && $_POST['sort'] == 'newest') ? 'selected' : ''; ?>>
                Newest First
            </option>
            <option value="oldest" <?php echo (isset($_POST['sort']) && $_POST['sort'] == 'oldest') ? 'selected' : ''; ?>>
                Oldest First
            </option>
            <option value="price_asc" <?php echo (isset($_POST['sort']) && $_POST['sort'] == 'price_asc') ? 'selected' : ''; ?>>
                Price: Low to High
            </option>
            <option value="price_desc" <?php echo (isset($_POST['sort']) && $_POST['sort'] == 'price_desc') ? 'selected' : ''; ?>>
                Price: High to Low
            </option>
        </select>

    </form>
<div>

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