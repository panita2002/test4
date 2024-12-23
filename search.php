<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = $_GET['query'];
    $stmt = $pdo->prepare("SELECT id, file_name, content FROM documents WHERE content LIKE :query");
    $stmt->execute(['query' => '%' . $query . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Search Results</h1>";
    foreach ($results as $result) {
        echo "<p><strong>{$result['file_name']}:</strong> " . htmlspecialchars($result['content']) . "</p>";
    }
}
?>
<form method="GET">
    <input type="text" name="query" placeholder="Search content">
    <button type="submit">Search</button>
</form>

<!-- หน้าค้นหา search.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>
    
    <p><a href="index.php">Home</a></p>
</body>
</html>
