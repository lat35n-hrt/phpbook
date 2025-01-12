<?php
session_start();
require_once __DIR__ . '/../shared/login_check.php';
require_once __DIR__ . '/../shared/functions.php';

if (empty($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    echo "Invalid book ID.";
    exit;
}

$bookId = (int)$_GET['book_id'];
$userId = $_SESSION['id']; // User ID in session

try {
    $dbh = db_open();

    // Start the transaction
    $dbh->beginTransaction();

    // Check book availability
    $stmt = $dbh->prepare('SELECT is_borrowed FROM books WHERE id = :id');
    $stmt->bindValue(':id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book || $book['is_borrowed']) { // Check if book exists and is available
        echo "Book is not available or does not exist.";
        exit;
    }

    // Borrow the book
    $borrowDate = new DateTime();
    $dueDate = (clone $borrowDate)->modify('+14 days')->setTime(20, 0, 0); // 14-day borrowing period -> Set time to 20:00:00; 
    $dueDateString = $dueDate->format('Y-m-d H:i:s');

    $stmt = $dbh->prepare('INSERT INTO borrowed_books (book_id, user_id, borrow_date, due_date) VALUES (:book_id, :user_id, :borrow_date, :due_date)');
    $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':borrow_date', $borrowDate->format('Y-m-d H:i:s'));
    $stmt->bindValue(':due_date', $dueDateString);
    $stmt->execute();

    //Database Normalization: The is_borrowed status is an attribute of the book itself, not the borrowing transaction.
    $stmt = $dbh->prepare('UPDATE books SET is_borrowed = TRUE WHERE id = :id');
    $stmt->bindValue(':id', $bookId, PDO::PARAM_INT);
    $stmt->execute();

    // Commit the transaction
    $dbh->commit();

    header("Location: index_search.php?borrow_success=1"); // Redirect with success message
    exit;

} catch (PDOException $e) {

    // Rollback on any exception
    if ($dbh->inTransaction()) { // Check if a transaction is active before rollback
        $dbh->rollBack();
    }

    error_log($e->getMessage());
    echo "An error occurred while borrowing the book.";
    exit;
}