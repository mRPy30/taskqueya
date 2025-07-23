<?php
require_once '../../config/database.php';

// Create folder if not exists
$uploadDir = '../../uploads/faces/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $adminId = $data['admin_id'];
    $imageData = $data['image'];

    if (!$adminId || !$imageData) {
        echo json_encode(['success' => false, 'message' => 'Missing data.']);
        exit;
    }

    // Decode image
    $image = str_replace('data:image/png;base64,', '', $imageData);
    $image = str_replace(' ', '+', $image);
    $imageData = base64_decode($image);

    $filename = "admin_" . $adminId . "_" . time() . ".png";
    $filepath = $uploadDir . $filename;

    // Save image
    if (!file_put_contents($filepath, $imageData)) {
        echo json_encode(['success' => false, 'message' => 'Error saving image.']);
        exit;
    }

    // Save relative path to DB
    $relativePath = 'uploads/faces/' . $filename;
    $stmt = $pdo->prepare("UPDATE users SET face_img = ? WHERE id = ? AND role = 'admin'");
    $stmt->execute([$relativePath, $adminId]);

    echo json_encode(['success' => true, 'message' => 'Face image saved successfully.']);
    exit;
}

// Get admins for dropdown
$admins = $pdo->query("SELECT id, name FROM users WHERE role = 'admin'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Face Registration</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #001E36;
      color: white;
      text-align: center;
      padding-top: 40px;
      display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    #register-form{
        background-color: #fff;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 8px 16px var(--shadow-color);
        width: 100%;
        max-width: 400px;
    }

    select, button {
      padding: 10px 15px;
      border-radius: 8px;
      margin-top: 10px;
    }
    button {
      background-color: #3399ff;
      color: white;
      border: none;
      cursor: pointer;
    }
    video {
      margin-top: 20px;
      border-radius: 10px;
    }
    canvas {
      display: none;
    }
  </style>
</head>
<body>

<h2>Admin Face Registration</h2>

<form id="register-form">
  <label for="admin_id">Select Admin:</label>
  <select name="admin_id" id="admin_id" required>
    <option value="">-- Choose Admin --</option>
    <?php foreach ($admins as $admin): ?>
      <option value="<?= $admin['id'] ?>"><?= htmlspecialchars($admin['name']) ?></option>
    <?php endforeach; ?>
  </select>
  <br>
  <video id="video" width="320" height="240" autoplay muted></video>
  <canvas id="canvas" width="320" height="240"></canvas>
  <br>
  <button type="button" id="capture">Capture & Save Face</button>
</form>

<script>
  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const ctx = canvas.getContext('2d');

  // Start webcam
  async function startVideo() {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: true });
      video.srcObject = stream;
    } catch (err) {
      alert("Camera error: " + err.message);
    }
  }

  startVideo();

  document.getElementById('capture').addEventListener('click', () => {
    const adminId = document.getElementById('admin_id').value;
    if (!adminId) {
      alert("Please select an admin.");
      return;
    }

    // Capture image
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const imageDataUrl = canvas.toDataURL('image/png');

    // Send to server
    fetch('admin-face-register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        admin_id: adminId,
        image: imageDataUrl
      })
    })
    .then(res => res.json())
    .then(res => alert(res.message))
    .catch(err => {
      console.error(err);
      alert("Failed to save face image.");
    });
  });
</script>

</body>
</html>
