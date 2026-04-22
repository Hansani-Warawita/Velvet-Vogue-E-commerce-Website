<?php
try {
    require_once('connection.php');

    // Enable error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Read SQL file
    $sqlFile = 'create_orders_tables.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: $sqlFile");
    }

    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception("Error reading SQL file: $sqlFile");
    }

    // Split SQL by semicolon to get individual queries
    $queries = array_filter(array_map('trim', explode(';', $sql)));

    // Begin transaction
    $conn->begin_transaction();

    try {
        foreach ($queries as $query) {
            if (!empty($query)) {
                $conn->query($query);
            }
        }

        // If we get here, commit the changes
        $conn->commit();
        
        echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background-color: #f0f8ff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);'>";
        echo "<h2 style='color: #008000;'>Success!</h2>";
        echo "<p>Orders tables have been created successfully.</p>";
        echo "<p>Created tables:</p>";
        echo "<ul>";
        echo "<li>orders</li>";
        echo "<li>order_items</li>";
        echo "</ul>";
        echo "<p><a href='../index.php' style='color: #0066cc; text-decoration: none;'>Return to homepage</a></p>";
        echo "</div>";

    } catch (Exception $e) {
        // An error occurred, rollback changes
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
    echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff0f0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);'>";
    echo "<h2 style='color: #cc0000;'>Error</h2>";
    echo "<p>An error occurred while setting up the database:</p>";
    echo "<pre style='background-color: #f8f8f8; padding: 10px; border-radius: 4px;'>";
    echo htmlspecialchars($e->getMessage());
    echo "</pre>";
    echo "<p><a href='../index.php' style='color: #0066cc; text-decoration: none;'>Return to homepage</a></p>";
    echo "</div>";
}

// Close connection
if (isset($conn)) {
    $conn->close();
}
?>
