<?php
session_start();
require_once __DIR__ . '/../shared/login_check.php';
require_once __DIR__ . '/../shared/functions.php';

if (empty($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    echo "Invalid book ID.";
    exit;
}

$bookId = (int)$_GET['book_id'];
$userId = $_SESSION['id']; // Assumes you store user ID in session

try {
    $dbh = db_open();
    $dbh->beginTransaction(); 

    // Check book availability
    $stmt = $dbh->prepare('SELECT is_borrowed FROM books WHERE id = :id');
    $stmt->bindValue(':id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book || !$book['is_borrowed']) { // Check if book exists and is borrowed
        $dbh->rollBack();
        echo "Book is not currently borrowed or does not exist.";
        exit;
    }

    // Borrow the book
    $returnDate = new DateTime();
    $returnDateString = $returnDate->format('Y-m-d H:i:s');

    $stmt = $dbh->prepare('UPDATE borrowed_books SET return_date = :return_date, returned_by = :returned_by where book_id = :book_id AND return_date IS NULL');
    $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->bindValue(':return_date', $returnDateString);
    $stmt->bindValue(':returned_by', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Check if any rows were affected. This is important to ensure that the book was actually borrowed by anyone.
    if ($stmt->rowCount() == 0) {
        $dbh->rollBack();
        echo "This book is not currently borrowed by anyone.";
        exit;
    }

    $stmt = $dbh->prepare('UPDATE books SET is_borrowed = FALSE WHERE id = :id');
    $stmt->bindValue(':id', $bookId, PDO::PARAM_INT);
    $stmt->execute();

    $dbh->commit();

    header("Location: index_search.php?return_success=1"); // Redirect with success message
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Error!!: " . str2html($e->getMessage()) . "<br>";
    //$e->getMessage() for a training purpose to know how it works
    echo "An error occurred while borrowing the book.";
    exit;
}