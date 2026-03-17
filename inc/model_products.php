<?php
$orderBy = "date_added DESC";
$where = [];
$params = [];

//sorting
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':
            $orderBy = "price ASC";
            break;
        case 'price_desc':
            $orderBy = "price DESC";
            break;
        case 'oldest':
            $orderBy = "date_added ASC";
            break;
        case 'likes_desc':
            $orderBy = "interested_amount DESC";
            break;
        case 'newest':
        default:
            $orderBy = "date_added DESC";
            break;
    }
}

//Search filterering
if(!empty($_GET['search'])){
  $where[] = "(name LIKE :search OR description LIKE :search)";
  $params[':search'] = "%" . trim($_GET['search']) . "%";
}

//Min price
if(isset($_GET['min_price']) && $_GET['min_price'] !== ''){
  $where[] = "price >= :min_price";
  $params[':min_price'] =  (int)($_GET['min_price']) ;
}

//Max price
if(isset($_GET['max_price']) && $_GET['max_price'] !== ''){
  $where[] = "price <= :max_price";
  $params[':max_price'] =  (int)($_GET['max_price']) ;
}

//Min likes
if(isset($_GET['min_likes']) && $_GET['min_likes'] !== ''){
  $where[] = "interested_amount >= :min_likes";
  $params[':min_likes'] =  (int)($_GET['min_likes']) ;
}

//LAzy loading
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

//Build SQL
$sql = "SELECT * FROM listings";

if(!empty($where)){
    $sql .= " WHERE " .implode(" AND ", $where);
}

$sql .= " ORDER BY $orderBy LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
// 3. Prepare the query with the dynamic (but safe) ORDER BY clause
// $stmt = $conn->prepare("SELECT * FROM listings ORDER BY $orderBy");

//Bind normal params
foreach($params as $key => $value){
    $stmt-> bindValue($key, $value);
}

//bind limit + offset
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);