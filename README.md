# SQLite3 in Python and PHP

This project demonstrates how to use **SQLite3** in both **Python** and **PHP**. It covers essential database operations such as creating tables, inserting records, querying data, updating, deleting, and transaction management. Each implementation includes performance optimizations and best practices for database handling in the respective languages.

## File Structure
````
sqlite3-in-python-php/ 
│ 
├── README.md # Project documentation 
├── sqlite3-php.php # PHP script implementing SQLite3 functionality 
└── sqlite3-python.py # Python script implementing SQLite3 functionality
````
suffixes in file names are used to avoid sqlite circular import error(when implementing, dont name files like sqlite3.py/php)

## General Database Best Practices

1. **Prepared Statements**: Always use prepared statements with placeholders to prevent SQL injection attacks.
   - **PHP**: Use `prepare()` and `bindValue()`.
   - **Python**: Use `?` placeholders in `execute()`.
   
2. **Error Handling with Transactions**: Use transactions for critical operations like inserts, updates, or deletes. This ensures data integrity in case of failures.
   - Use `try-except` blocks in **Python**, Use `try-catch` blocks in **PHP**.

3. **Commit and Rollback**: Always commit your changes at the end of a transaction and use rollback to undo changes in case of errors.
   - Use `conn.commit()` in Python and `$db->exec('COMMIT')` in PHP.
   - Rollback with `conn.rollback()` in Python and `$db->exec('ROLLBACK')` in PHP.

4. **Database Performance**:
   - **Batch Inserts**: Insert multiple records in one operation to reduce overhead.
   - **Minimize Queries in Loops**: Prepare a query once and reuse it to reduce unnecessary database operations.


## Python-Specific Tips

1. **Avoid Repeated `execute()` Calls**: When inserting multiple rows, use `executemany()` instead of multiple `execute()` calls. This improves performance by batching the operations.
   ```python
   cursor.executemany("INSERT INTO players (name, position) VALUES (?, ?)", players_list)
   ````
2. **Use `fetchone()`/`fetchall()` Appropriately**: Use fetchone() for single-row results and fetchall() for multiple rows. Be mindful of memory usage when fetching large datasets.
    ```python
    rows = cursor.fetchall()  # For multiple rows
    row = cursor.fetchone()    # For a single row
    ```
3. **Close Cursors and db connections**: Although Python handles cursor closure automatically, it's a good practice to explicitly close cursors and db connectionsto release database resources.
    ```python
    cursor.close()
    conn.close()
    ```

## PHP-Specific Tips

1. **Numerical vs. Associative Arrays**: Be consistent with array types when fetching data.
Use SQLITE3_NUM for numeric arrays and SQLITE3_ASSOC for associative arrays.
    ```php
    $result->fetchArray(SQLITE3_ASSOC);  // Fetch data as associative array
    ```
2. **Free Memory with `reset()`**: After executing a prepared statement, call $stmt->reset() to free resources if the statement will be reused.
    ```php
    $stmt->reset();  // Free resources after execution
    ````
3. **Reuse Prepared Statements**: Instead of preparing queries inside loops, prepare them once and bind different values during each iteration. This reduces overhead.
    ```php
    $stmt = $db->prepare('INSERT INTO players (name, priceinmill) VALUES (:name, :priceinmill)');
    foreach ($players as $player) {
        $stmt->bindValue(':name', $player[0], SQLITE3_TEXT);
        $stmt->bindValue(':priceinmill', $player[1], SQLITE3_INTEGER);
        $stmt->execute();
    }
    ```

## How to Run the Code

### Python
Install Python and SQLite3 and then Run the Python script:
```bash
python sqlite3-python.py
```

### PHP
Ensure PHP and SQLite3 are installed and Run the PHP script:
```bash
php sqlite3-php.php
```
---
Have a Good day, :v:
