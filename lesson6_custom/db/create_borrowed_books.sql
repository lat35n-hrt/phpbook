CREATE TABLE borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    user_id INT NOT NULL,
    borrow_date DATETIME NOT NULL,
    return_date DATETIME NULL,
    due_date DATETIME NOT NULL,
    returned_by INT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (returned_by) REFERENCES users(id)
);