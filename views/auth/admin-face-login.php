<?php
require_once '../../config/database.php';

$API_KEY    = '';
$API_SECRET = '';
$COMPARE_URL= 'https://api-us.faceplusplus.com/facepp/v3/compare';

session_start();

if (!isset($_POST['face_image']) || !isset($_POST['admin_id'])) {
    die('Missing face image or admin ID');
}

$admin_id = $_POST['admin_id'];
$img_data = base64_decode(explode(',', $_POST['face_image'])[1]);

$temp_path = '../../uploads/temp/login_' . uniqid() . '.jpg';
file_put_contents($temp_path, $img_data);

// Get stored face image path from DB
$stmt = $pdo->prepare("SELECT id, name, face_img FROM users WHERE id = ? AND role = 'admin'");
$stmt->execute([$admin_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !file_exists('../../' . $user['face_image_path'])) {
    unlink($temp_path);
    die('Stored face not found.');
}

// Compare via API
$post_fields = [
    'api_key' => $API_KEY,
    'api_secret' => $API_SECRET,
    'image_file1' => new CURLFile(realpath($temp_path)),
    'image_file2' => new CURLFile(realpath('../../' . $user['face_image_path']))
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $COMPARE_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
$response = curl_exec($ch);
curl_close($ch);

unlink($temp_path);

$result = json_decode($response, true);

if (isset($result['confidence']) && $result['confidence'] >= 80) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['role']    = 'admin';
    header("Location: ../administrator/dashboard.php");
    exit;
} else {
    echo "<script>alert('Face not recognized.'); window.location.href='admin-login.php';</script>";
}
?>
