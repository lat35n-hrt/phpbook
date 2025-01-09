<?php
session_start();
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<?php 
require_once __DIR__ . '/../shared/functions.php'; // functions
require_once __DIR__ . '/../shared/login_check.php'; // Login checker
include_once __DIR__ . '/../shared/header.php'; // with a shared header 

//display username and role
if (!empty($_SESSION['username'])) {
    echo "You're logging as " . str2html($_SESSION['username']) . "(" . str2html($_SESSION['role']) . ")" . "!";
}

// Check user role for permission
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'editor') {
    echo "You do not have permission to add books.";
    exit;
}

?>
<form action='add.php' method='post'>
    <p>
        <label for='title'>Title (Required Max200 Characters): </label>
        <input type='text' name='title'>
    </p>

    <p>
        <label for='isbn'>ISBN (Max 13 Characters): </label>
        <input type='text' name='isbn'>
    </p>

    <p>
        <label for='price'>Price (Max 6 Digits): </label>
        <input type='text' name='price'>
    </p>

    <p>
        <label for='publish'>Publish Date (YYYY-MM-DD): </label>
        <input type='text' name='publish'>
    </p>

    <p>
        <label for='author'>Author (Max 80 Characters): </label>
        <input type='text' name='author'>
    </p>

    <p class='button'>
        <input type='hidden' name='token' value='<?php echo $token ?>'>
        <input type='submit' value='Submit'>
    </p>
</form>
<?php include_once __DIR__ . '/../shared/footer.php'; // with a shared header
