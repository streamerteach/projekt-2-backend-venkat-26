<?php
    $errors = [];
    $success = false;

    $stmt = $conn->prepare("
        SELECT 
            l.*, 
            u.realname AS listing_seller,
            u.username AS listing_seller_uname,
            (SELECT 1 FROM users_interested WHERE user_id_fk = :user_id AND listing_id_fk = l.id) AS is_interested,
            (SELECT COUNT(*) FROM users_interested WHERE listing_id_fk = l.id) AS total_interested
        FROM listings l
        LEFT JOIN users u ON u.id = l.user_id_fk
        WHERE l.id = :listing_id
    ");

    $stmt->execute([
        'user_id' => $_SESSION['user_id'] ?? 0, 
        'listing_id' => $_GET['id']
    ]);

    $listingData = $stmt->fetch(PDO::FETCH_ASSOC);

    $isInterested = (bool)$listingData['is_interested'];
    $totalInterested = $listingData['total_interested'];
    
/* Handle interested / not intersted / comments */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $listing_id = $_GET['id'];
    $action = $_POST['action'];
    $user_id = $_SESSION['user_id'];

    //Interested buttons
if(isset($_POST['action'])){ 
    $action = $_POST['action'];

    if ($action === 'interested') {
        $stmt = $conn->prepare("INSERT IGNORE INTO users_interested (user_id_fk, listing_id_fk) VALUES (?, ?)");
        $stmt->execute([$user_id, $listing_id]);
    } elseif ($action === 'not_interested') {
        $stmt = $conn->prepare("DELETE FROM users_interested WHERE user_id_fk = ? AND listing_id_fk = ?");
        $stmt->execute([$user_id, $listing_id]);
    }

    header("Location: " . BASE_URL . "/index.php?page=listing&id=" . $listing_id);
    exit;
}

//comment submit 
  if(isset($_POST['submit_comment'])){
   $comment = trim($_POST['comment']) ;
    
   if($comment !== ''){
    $stmt = $conn->prepare("
      INSERT INTO comments (content, listing_id_fk, user_id_fk, date) VALUES (:content, :listing_id, :user_id, CURDATE())
    ");
     
    $stmt ->execute([
        ':content' => $comment,
         ':listing_id' => $listing_id,
         ':user_id' => $user_id
    ]);
   }
    header("Location:" .BASE_URL. "/index.php?page=listing&id=" .$listing_id);
    exit;
  }
}
/* Fetch comments for this listing */
$stmt = $conn->prepare("
  SELECT 
    c.id,
    c.content,
    c.date,
    u.username
  FROM comments c
  INNER JOIN users u ON u.id = c.user_id_fk
   WHERE c.listing_id_fk = :listing_id
   ORDER BY c.id ASC
 ");
  $stmt->execute([
    ':listing_id' => $_GET['id']
  ]);

  $listingComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
