<?php
require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$spoken = strtolower(trim($data['spoken']));

$stmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(voice_phrase) = ?");
$stmt->execute([$spoken]);

if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = 'admin';
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
