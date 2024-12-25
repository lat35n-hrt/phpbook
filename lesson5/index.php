<?php
require_once __DIR__ . '/../shared/functions.php'; // with a function for XSS (str2html)

try {
    // Establish a database connection using db_open() from /shared/functions.php
    $dbh = db_open();
    $sql = 'SELECT * FROM books';
    $statement = $dbh->query($sql);
?>

<table>
    <tr><th>Update</th><th>Title</th><th>ISBN</th><th>Price</th><th>Publish Date</th><th>Author</th>
    <?php while ($row = $statement->fetch()): ?>
    <tr>
        <!-- Added an Update Column -->
        <td><a href="edit2.php?id=<?php echo (int) $row['id']; ?>">Edit</a></td>
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