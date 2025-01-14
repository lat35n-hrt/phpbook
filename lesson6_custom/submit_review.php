<?php
session_start();
require_once __DIR__ . '/../shared/functions.php';
require_once __DIR__ . '/../shared/login_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (Validate input: book_id, rating, review_text)
    $bookId = (int)$_POST['book_id'];
    $rating = (int)$_POST['rating'];
    $reviewText = $_POST['review_text'];
    $userId = $_SESSION['id'];
    $reviewDate = (new DateTime())->format('Y-m-d H:i:s');
    try {
        $dbh = db_open();
        $dbh->beginTransaction();
        $stmt = $dbh->prepare('INSERT INTO reviews (book_id, user_id, rating, review_text, review_date) VALUES (:book_id, :user_id, :rating, :review_text, :review_date)');
        $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindValue(':review_text', $reviewText, PDO::PARAM_STR);
        $stmt->bindValue(':review_date', $reviewDate, PDO::PARAM_STR);

        echo '<pre>';
        var_dump($stmt);
        var_dump($bookId, $userId, $rating, $reviewText, $reviewDate);
        echo '</pre>';
        
        $stmt->execute();

        echo "---Debug---";

        //Update average rating
        //$stmt = $dbh->prepare('UPDATE books SET average_rating = (SELECT AVG(rating) FROM reviews WHERE book_id = :book_id) WHERE id = :book_id');
        $updateStmt = $dbh->prepare('UPDATE books SET average_rating = COALESCE((SELECT AVG(rating) FROM reviews WHERE book_id = :book_id_subquery), 0.00) WHERE id = :book_id_outer');
        $updateStmt->bindValue(':book_id_subquery', $bookId, PDO::PARAM_INT);
        $updateStmt->bindValue(':book_id_outer', $bookId, PDO::PARAM_INT);
        $updateStmt->execute();
        $dbh->commit();

        header("Location: book_details.php?book_id=" . $bookId . "&review_success=1");
        exit;
    } catch (PDOException $e) {
        $dbh->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>