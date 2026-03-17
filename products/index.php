<?php
    require_once __DIR__ . '/../inc/config.php';

    if (! defined('APP_STARTED')) {
    exit;
    }
    require_once __DIR__ . '/../inc/model_products.php';


/* $stmt = $conn->prepare("SELECT * FROM listings");
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

    <div class="filter-card">
        <h3>Filter & Sort</h3>

        <div class="sort-row">
            <form action="index.php" method="GET" id="sortForm">
                <input type="hidden" name="page" value="products">
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <input type="hidden" name="min_price" value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>">
                <input type="hidden" name="max_price" value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>">
                <input type="hidden" name="min_likes" value="<?php echo htmlspecialchars($_GET['min_likes'] ?? ''); ?>">

                <label for="sort-by">Sort by</label>
                <select name="sort" id="sort-by" onchange="this.form.submit()">
                    <option value="newest" <?php echo (($_GET['sort'] ?? 'newest') === 'newest') ? 'selected' : ''; ?>>
                        Newest First
                    </option>
                    <option value="oldest" <?php echo (($_GET['sort'] ?? '') === 'oldest') ? 'selected' : ''; ?>>
                        Oldest First
                    </option>
                    <option value="price_asc" <?php echo (($_GET['sort'] ?? '') === 'price_asc') ? 'selected' : ''; ?>>
                        Price: Low to High
                    </option>
                    <option value="price_desc" <?php echo (($_GET['sort'] ?? '') === 'price_desc') ? 'selected' : ''; ?>>
                        Price: High to Low
                    </option>
                    <option value="likes_desc" <?php echo (($_GET['sort'] ?? '') === 'likes_desc') ? 'selected' : ''; ?>>
                        Most Liked
                    </option>
                </select>
            </form>
        </div>

        <form action="index.php" method="GET" id="filterForm">
            <input type="hidden" name="page" value="products">
            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($_GET['sort'] ?? 'newest'); ?>">

            <div class="filter-row">
                <input type="text" name="search" id="search" placeholder="Search products"
                    value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">

                <input type="number" name="min_price" id="min_price" placeholder="Min Price"
                    value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>">

                <input type="number" name="max_price" id="max_price" placeholder="Max Price"
                    value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>">

                <input type="number" name="min_likes" id="min_likes" placeholder="Minimum Likes"
                    value="<?php echo htmlspecialchars($_GET['min_likes'] ?? ''); ?>">
            </div>

            <div class="filter-actions">
                <button type="submit">Apply Filters</button>
                <a href="index.php?page=products" class="clear-filters-btn">Clear</a>
            </div>
        </form>
    </div>

    <div class="product-listing" id="product-listing">
        <?php if (!empty($listings)) : ?>
            <?php foreach ($listings as $listing): ?>
                <div class="product-card">
                    <a href="<?= BASE_URL ?>/index.php?page=listing&id=<?= $listing['id'] ?>">
                        <img src="<?= BASE_URL ?>/images/<?= htmlspecialchars(basename($listing['img_path'])) ?>"
                             alt="<?php echo htmlspecialchars($listing['name']); ?>">
                        <h3><?php echo htmlspecialchars($listing['name']); ?></h3>
                        <p><?php echo htmlspecialchars($listing['description']); ?></p>
                        <p>Price: <?php echo $listing['price']; ?>€</p>
                        <p>Likes: <?php echo (int)$listing['interested_amount']; ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>

    <div id="loading" style="display: none;">Loading more products...</div>
</main>