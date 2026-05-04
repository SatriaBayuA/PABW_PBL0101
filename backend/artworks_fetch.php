<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config.php';

$result = $mysqli->query("SELECT id, title, description, image_path FROM artworks ORDER BY id DESC");
$artworks = [];

while ($row = $result->fetch_assoc()) {
    $artworks[] = $row;
}

echo json_encode(['success' => true, 'data' => $artworks]);

$mysqli->close();