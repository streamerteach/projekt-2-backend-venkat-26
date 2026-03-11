
<?php
echo "TEST WORKS";
if(!empty($_REQUEST['username'])){
    $username = test_input($_REQUEST['username']);
    // hasha lösenordet och spara i databasem
    $hashed_password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO `profiles` (`id`, `username`, `realname`, `zipcode`, `bio`, `salary`, `preference`, `email`, `likes`, `role`, `passhash`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    //$stmt->execute(['welandfr', 'Welander Fredrik', '00420', 'hej', '100', '1', 'welandfr@arcada.fi', '1', '1', $hashed_password]);
    print("<p>Hashed password stored in DB:".$hashed_password."</p>");


    // Verifiera inmatat lösneord med hash från DB
    if(!empty($_REQUEST['password'])){
        
        $sql = "SELECT * FROM profiles where username = ?";
        $result = $conn->prepare($sql);
        $result->execute([$username]);
        // Fetch a row
        $row = $result->fetch();
        //print_r($row['passhash']);
        // Hämta passhash från den assosiativa arrayen 
        $hashFromDB = $row['passhash'];
        print("<p>Hittade följande passhash från DB:n: ".$hashFromDB."</p>");

        if (password_verify($_REQUEST['password'], $hashFromDB)) {
            print("<p>Password matches hash from DB</p>");
            $_SESSION['username'] = test_input($_REQUEST['username']);
            
            
        } else {
            print("<p>Password doesn't match hash</p>");
        }
    }
}

?>