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
