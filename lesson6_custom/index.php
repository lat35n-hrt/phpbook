<?php
session_start();
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<?php 
require_once __DIR__ . '/../shared/login_check.php'; // Login checker
require_once __DIR__ . '/../shared/functions.php'; // with a function for XSS (str2html)


try {
    // Establish a database connection using db_open() from /shared/functions.php
    $dbh = db_open();
    $sql = 'SELECT * FROM books';
    $statement = $dbh->query($sql);
?>

<table>
    <tr><th>Delete</th><th>Update</th><th>Title</th><th>ISBN</th><th>Price</th><th>Publish Date</th><th>Author</th>
    <?php while ($row = $statement->fetch()): ?>
    <tr>
        <td>
            <form method="POST" action="delete.php">
                <input type="hidden" name="id" value="<?php echo (int) $row['id']; ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
        <td><a href="edit.php?id=<?php echo (int) $row['id']; ?>">Edit</a></td>
        <td><?php echo str2html($row['title']) ?></td>
        <td><?php echo str2html($row['isbn']) ?></td>
        <td><?php echo str2html($row['price']) ?></td>
        <td><?php echo str2html($row['publish']) ?></td>
        <td><?php echo str2html($row['author']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
}
catch(PDOException $e){
    echo "Error!!: " . str2html($e->getMessage()) . "<br>";
    //$e->getMessage() for a training purpose to know how it works
    exit;
}
?>
<?php include_once __DIR__ . '/../shared/footer.php'; // with a shared header
?>