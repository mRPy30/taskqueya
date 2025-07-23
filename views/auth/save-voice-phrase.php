<?php
session_start();
require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$phrase = strtolower(trim($data['phrase']));
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("UPDATE users SET voice_phrase = ? WHERE id = ?");
if ($stmt->execute([$phrase, $user_id])) {
    echo "Voice phrase saved.";
} else {
    echo "Error saving voice phrase.";
}
?>
