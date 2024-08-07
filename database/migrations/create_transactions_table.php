<?php

require_once __DIR__ . '/../Database.php';

class CreateTransactionsTable
{
    public static function up()
    {
        $db = (new Database())->getConnection();
        $sql = "CREATE TABLE IF NOT EXISTS transactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT,
            recipient_id INT,
            amount DECIMAL(10, 2),
            type ENUM('deposit', 'withdrawal', 'transfer'),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES customers(id),
            FOREIGN KEY (recipient_id) REFERENCES customers(id)
        )";
        if ($db->query($sql) === TRUE) {
            echo "Table transactions created successfully\n";
        } else {
            echo "Error creating table: " . $db->error . "\n";
        }
         $db->close();
    }
}

CreateTransactionsTable::up();
?>
