<?php
$errors = [];
$success = false;
include __DIR__ . "/../inc/model_listing.php";
include __DIR__ . "/../inc/model_mark_interested.php";

if (!defined('APP_STARTED')) {
    exit;
}

?>

<main class="page-section intro-section">
<article class="listing">

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert success">
        <p>Listing created successfully! 🥳</p>
        <p><a href="<?= BASE_URL ?>/index.php?page=listing&id=<?= $listing_id ?>">Go to listing page</a></p>
      </div>

    <?php else: ?>
        
      <img id="listing-img" src="<?= BASE_URL ?>/images/<?= $listingData['img_path']; ?>" alt="<?php echo htmlspecialchars($listingData['name']); ?>">
      <div id= "listing-data">
        <h1><?php echo $listingData['name'] ?></h1>
        
        <p id="listing-seller">Seller: <?= $listingData['listing_seller'] ?></p>

        <p id="listing-description"><?= $listingData['description'] ?> 
                    <!--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis quam sed neque tristique, id tincidunt odio egestas. Cras pulvinar egestas tortor vel sagittis. Cras efficitur hendrerit ex id egestas. Sed ut dapibus velit, non posuere turpis. Nam dictum mollis ipsum, eu facilisis massa gravida in. Nunc vel molestie leo, in elementum tellus. Donec euismod consequat nibh, quis tempus tellus fermentum sit amet. Duis imperdiet erat nisl, non volutpat leo imperdiet sed. In justo est, accumsan eu porta eget, viverra et risus. Cras et lorem in diam fermentum elementum. Aenean at tincidunt justo, vitae porttitor urna. Nunc id pretium orci.

            Maecenas iaculis nunc non elit auctor, et sodales erat iaculis. Phasellus nec lectus iaculis risus efficitur porttitor nec dictum massa. Aliquam consectetur massa vitae tempor rutrum. Fusce id mattis risus. Mauris semper felis sapien, vel laoreet leo aliquet at. Quisque aliquet venenatis luctus. Nam condimentum varius malesuada. Quisque in quam vel mauris lacinia tempor. Nunc viverra ultrices risus. Praesent eu scelerisque sapien. Etiam et ultricies purus, eget mollis ipsum. Sed nec finibus nibh. Mauris ultricies metus quis odio convallis fermentum. Phasellus nec enim nec turpis dictum lobortis tincidunt in orci. Aenean semper malesuada fringilla.

            Mauris facilisis arcu eget rhoncus dignissim. Proin tempor ultrices diam vitae pretium. Vivamus in venenatis lacus, vel pretium ante. Etiam eget dignissim quam, a eleifend neque. Nullam rutrum enim eget venenatis vulputate. In rhoncus turpis nec leo tincidunt volutpat. Vestibulum quis vulputate ante. Integer interdum turpis mauris, ut pharetra lacus finibus et. Morbi malesuada ante vitae nisl finibus laoreet. Ut semper sollicitudin leo, non tincidunt enim egestas non.

            Praesent ullamcorper non leo non feugiat. Duis lacinia lectus sed nisl tristique, tincidunt venenatis dolor commodo. Fusce blandit non elit et fermentum. Suspendisse eget mi at lacus tempor sollicitudin. Nulla risus nulla, dapibus nec egestas et, condimentum vitae ligula. Nullam et nulla et tellus commodo mollis. Pellentesque lobortis purus ut feugiat laoreet. Sed non finibus turpis. Donec quis mollis elit. Mauris convallis, tortor ac varius ullamcorper, lorem ligula maximus augue, vel tristique lacus libero eu lectus.

            Sed vitae libero dolor. Fusce vel tempus sem. Phasellus eu sapien nisi. Nam sed purus eu ex elementum pellentesque sit amet in neque. Nulla facilisi. Morbi blandit dapibus odio non lacinia. Etiam condimentum interdum justo ac dapibus. Proin lectus augue, scelerisque quis rutrum vitae, lacinia vitae massa. Aliquam blandit euismod nisi vel molestie. Sed fringilla nisl non nulla congue, sit amet malesuada diam gravida. Integer aliquet ultrices erat a pretium. Vestibulum sit amet lorem vitae ante faucibus congue sit amet vel purus. Pellentesque lacinia facilisis arcu a imperdiet. Maecenas elementum arcu in tristique aliquam. Ut in nulla id sapien lobortis ornare. Nam ultricies aliquam enim vitae scelerisque. 
                -->
          </p>

        <div id="listing-interested">
          <p><?= $totalInterested ?> people in total have shown interest in this listing<?php if ($isInterested): ?> (including you)<?php endif; ?>.</p>

          <form action="<?= BASE_URL ?>/index.php?page=listing&id=<?= $_GET['id']; ?>" method="POST">
            
            <?php if ($isInterested): ?>
                <button type="submit" name="action" value="not_interested">Mark me as not interested</button>
            <?php else: ?>
                <button type="submit" name="action" value="interested">Mark me as interested</button>
            <?php endif; ?>
          </form>
        <div>
      <div>
    <?php endif; ?>
</main>
