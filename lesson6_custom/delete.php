<?php
session_start();
require_once __DIR__ . '/../shared/login_check.php'; // Login checker
require_once __DIR__ . '/../shared/functions.php'; // Contains functions like str2html() and db_open()

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

// Validate CSRF token
if (empty($_POST['token']) || empty($_SESSION['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "Invalid CSRF token.";
    exit;
}

// Validate and sanitize the 'id'
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id === false) {
    echo "Invalid ID.";
    exit;
}

// Check user role for permission
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'editor') {
    echo "You do not have permission to edit books.";
    exit;
}


try {
    // Database connection
    $dbh = db_open();

    // Start transaction: Auto-Commit is now disabled
    $dbh->beginTransaction();

    // Check if the record exists
    $sql = 'SELECT COUNT(*) FROM books WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        echo "The specified book ID was not found.";
        // Rollback the transaction
        $dbh->rollBack();
        exit;
    }

    // Delete the record
    $sql = 'DELETE FROM books WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Commit the transaction
    $dbh->commit();

    echo "Book information has been deleted.<br>";
    echo "<a href='index.php'>Return to the list</a>";
} catch (PDOException $e) {
    // Rollback in case of error
    if ($dbh->inTransaction()) {
        $dbh->rollBack();
    }
    echo "An error occurred: " . str2html($e->getMessage()) . "<br>";
    exit;
}
?>