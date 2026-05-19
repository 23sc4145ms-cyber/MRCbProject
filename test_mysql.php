<?php
echo "Testing MySQL connection...\n";
try {
    $pdo = new PDO(
        'mysql:host=localhost;port=3306;dbname=msgsularaveldb',
        'root',
        '',
        [PDO::ATTR_TIMEOUT => 5, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ Connection successful!\n";
    
    // Test a query
    $result = $pdo->query('SELECT 1 as test');
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "✓ Query works: " . json_encode($row) . "\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
}
?>
