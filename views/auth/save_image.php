<?php
require_once '../../config/database.php';

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

$admin_id = $data['admin_id'];
$image_data = $data['image'];

if (!$admin_id || !$image_data) {
    echo json_encode(['success' => false, 'message' => 'Missing data.']);
    exit;
}

// Extract base64 image data
$image_parts = explode(";base64,", $image_data);
$image_base64 = base64_decode($image_parts[1]);

// Save the image to server
$target_dir = '../../public/faces/';
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$image_path = $target_dir . 'admin_' . $admin_id . '.png';
if (file_put_contents($image_path, $image_base64)) {
    echo json_encode(['success' => true, 'message' => 'Face image saved.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving image.']);
}
