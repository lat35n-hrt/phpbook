<?php
require_once __DIR__ . '/../shared/functions.php';
require_once __DIR__ . '/../shared/header.php';

if (empty($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    echo "Invalid book ID.";
    exit;
}

$bookId = (int)$_GET['book_id'];

try {
    $dbh = db_open();

    // Get book details
    $stmt = $dbh->prepare('SELECT * FROM books WHERE id = :id');
    $stmt->bindValue(':id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        echo "Book not found.";
        exit;
    }

    // Get reviews for the book
    $stmt = $dbh->prepare('SELECT * FROM reviews WHERE book_id = :book_id');
    $stmt->bindValue(':book_id', $bookId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display book details
    echo "<h1>" . str2html($book['title']) . "</h1>";
    // ... display other book details

    // Display reviews
    echo "<h2>Reviews</h2>";
    if ($reviews) {
        foreach ($reviews as $review) {
            echo "<p>Rating: " . $review['rating'] . "/5<br>";
            echo "Review: " . str2html($review['review_text']) . "</p>";
        }
    } else {
        echo "<p>No reviews yet.</p>";
    }

    // Review Form
    if(isset($_GET['book_id'])){
    echo '<h2>Submit a Review</h2>
        <form action="submit_review.php" method="post">
            <input type="hidden" name="book_id" value="' . $bookId . '">
            <label for="rating">Rating (1-5):</label>
            <select name="rating" id="rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br>
            <label for="review_text">Review:</label><br>
            <textarea name="review_text" rows="4" cols="50"></textarea><br>
            <input type="submit" value="Submit Review">
        </form>';
    } else {
        echo "<p>Please <a href='login.php'>login</a> to submit review</p>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

require_once __DIR__ . '/../shared/footer.php';
?>