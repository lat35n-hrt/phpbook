<?php
session_start();
require_once __DIR__ . '/../shared/functions.php'; // with a function for XSS (str2html) and db_open()
include __DIR__ . '/../shared/header.php'; // with a shared header

// Check if already logged in
if (!empty($_SESSION['login'])) {
    echo "Already logged in<br>";
    echo "<a href=index.php>Return to the List</a>";
    exit;
}

// Handle account creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_account'])) {
    if (empty($_POST['new_username']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
        echo "Please fill in all fields for account creation.";
    } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
        echo "Passwords do not match.";
    } else {
        try {
            $dbh = db_open();
            $dbh->beginTransaction(); // Start the transaction

            // Check if username already exists
            $stmt = $dbh->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->bindParam(':username', $_POST['new_username'], PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                echo "Username already exists. Please choose a different one.";
            } else {
                $hashedPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $defaultRole = 'viewer'; // Default role is "viewer" for new users

                $stmt = $dbh->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
                $stmt->bindParam(':username', $_POST['new_username'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                $stmt->bindParam(':role', $defaultRole, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $dbh->commit(); // Commit the transaction if insert is successful
                    echo "Account created successfully. You can now <a href='login.php'>log in</a>.";
                } else {
                    $dbh->rollBack(); // Rollback on any exception
                    echo "Error creating account.";
                }
            }
        } catch (PDOException $e) {
            echo "Error!!: " . str2html($e->getMessage()) . "<br>";
        }
    }
}
?>


<h2>Create Account</h2>
<form method="post" action="create_account.php">
    <p>
        <label for="new_username">New User Name:</label>
        <input type="text" name="new_username" required>
    </p>
    <p>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
    </p>
    <p>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>
    </p>
    <input type="submit" name="create_account" value="Create Account">
</form>