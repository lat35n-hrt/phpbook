<?php
require_once __DIR__ . '/../shared/functions.php'; // with a function for XSS (str2html) and db_open()
include_once __DIR__ . '/../shared/error_check.php'; // with validations for error check
include_once __DIR__ . '/../shared/header.php'; // with a shared header
require_once __DIR__ . '/../shared/token_check.php'; // with a token check

// Extract year, month, and day from the input 'YYYY-MM-DD'
$date = explode('-', $_POST['publish']);
// Check if the date is valid (month, day, year)
if(!checkdate($date[1], $date[2], $date[0])){
    echo "The publish date is invalid. Please enter a valid date.";
    exit;
}
if(!preg_match('/\A[[:^cntrl:]]{0,89}\z/u', $_POST['author'])){
    echo "The author name must be up to 89 characters and cannot contain control characters.";
    exit;
}
try {
    // Establish a database connection using db_open() from /shared/functions.php
    $dbh = db_open();

    $sql = 'INSERT INTO books (id, title, isbn, price, publish, author)
            VALUES (NULL, :title, :isbn, :price, :publish, :author)';
    $stmt = $dbh->prepare($sql);
    //$price = (int) $_POST['price'];
    $stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
    $stmt->bindParam(":price", $_POST['price'], PDO::PARAM_INT);
    $stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);

    $stmt->execute();
    echo "Added Data <br>";
    echo "<a href='index.php'> Return to the list</a>";
}
catch(PDOException $e){
    echo "Error!!: " . str2html($e->getMessage()) . "<br>";
    //$e->getMessage() for a training purpose to know how it works
    exit;
}
?>
<?php include_once __DIR__ . '/../shared/footer.php'; // with a shared header