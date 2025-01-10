<?php
session_start();
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<?php
require_once __DIR__ . '/../shared/functions.php';
require_once __DIR__ . '/../shared/login_check.php';

if (!empty($_SESSION['username'])) { // Correct check
    echo "Welcome, " . str2html($_SESSION['username']) . "(" . str2html($_SESSION['role']) . ")" . "!"; // Display username and role
}

try {
    $dbh = db_open();

    // Explicitly check if the input is not only set but also not an empty string before calling filter_var():
    if (isset($_GET['min_price']) && trim($_GET['min_price']) !== '') { // Check if set AND not empty/whitespace
        $minPrice = filter_var($_GET['min_price'], FILTER_VALIDATE_INT);
        if ($minPrice === false) { // Check if validation failed (e.g., non-numeric input)
            echo "Invalid minimum price entered.";
        }
    } else {
        $minPrice = null; // Explicitly set to null if the input is empty
    }

    if (isset($_GET['max_price']) && trim($_GET['max_price']) !== '') { // Check if set AND not empty/whitespace
        $maxPrice = filter_var($_GET['max_price'], FILTER_VALIDATE_INT);
        if ($maxPrice === false) { // Check if validation failed (e.g., non-numeric input)
            echo "Invalid maximum price entered.";
        }
    } else {
        $maxPrice = null; // Explicitly set to null if the input is empty
    }

    if (isset($_GET['year']) && trim($_GET['year']) !== '') {
        $year = filter_var($_GET['year'], FILTER_VALIDATE_INT);
        if ($year === false || $year < 1000 || $year > 9999) { // Check for non-integer or out-of-range year
            echo "Invalid year entered (must be a 4-digit year).";
        }
    } else {
        $year = null; // Explicitly set to null if the input is empty
    }

    // Build the SQL query dynamically
    $sql = 'SELECT * , is_borrowed FROM books WHERE 1=1';

    $params = [];

    if ($minPrice !== null) {
        $sql .= ' AND price >= :min_price';
        $params[':min_price'] = $minPrice;
    }

    if ($maxPrice !== null) {
        $sql .= ' AND price <= :max_price';
        $params[':max_price'] = $maxPrice;
    }

    if ($year !== null) {
        $sql .= ' AND YEAR(publish) = :year'; // MySQL specific: YEAR() function
        $params[':year'] = $year;
    }

    var_dump($sql); // Debugging
    var_dump($params); // Debugging

    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    ?>

    <form method="GET" action="index_search.php">
        Min Price: <input type="number" name="min_price" step="1" value="<?php echo htmlspecialchars($minPrice ?? ''); ?>"><br>
        Max Price: <input type="number" name="max_price" step="1" value="<?php echo htmlspecialchars($maxPrice ?? ''); ?>"><br>
        Year: <input type="number" name="year" value="<?php echo htmlspecialchars($year ?? ''); ?>"><br>
        <input type="submit" value="Search">
    </form>

    <table>
        <tr>
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'editor'): ?>
                <th>Delete</th>
                <th>Update</th>
            <?php endif; ?>
            <th>Title</th>
            <th>ISBN</th>
            <th>Price</th>
            <th>Publish Date</th>
            <th>Author</th>
            <th>Status</th><th>Borrow</th>
        </tr>
        <?php while ($row = $statement->fetch()): ?>
            <tr>
                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'editor'): ?>
                    <td>
                    <form method="POST" action="delete.php">
                        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        <button type="submit">Delete</button>
                    </form>
                    </td>
                    <td><a href="edit.php?id=<?php echo (int)$row['id']; ?>">Edit</a></td>
                <?php endif; ?>
                <td><?php echo str2html($row['title']) ?></td>
                <td><?php echo str2html($row['isbn']) ?></td>
                <td><?php echo str2html($row['price']) ?></td>
                <td><?php echo str2html($row['publish']) ?></td>
                <td><?php echo str2html($row['author']) ?></td>
                <td><?php echo str2html($row['is_borrowed']) ? 'Borrowed' : 'Available'; ?></td> <td>
                    <?php if (!$row['is_borrowed']): ?> <a href="borrow.php?book_id=<?php echo (int)$row['id']; ?>">Borrow</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
} catch (PDOException $e) {
    echo "Error!!: " . str2html($e->getMessage()) . "<br>";
    exit;
}
?>
<?php include_once __DIR__ . '/../shared/footer.php'; ?>