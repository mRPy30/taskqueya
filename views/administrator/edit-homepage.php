<?php
require_once '../../config/database.php';

// Fetch all content with section names and background color
$stmt = $pdo->query("SELECT hc.*, hs.id AS section_id, hs.section_name, hs.background_color
    FROM homepage_content hc
    JOIN homepage_sections hs ON hc.section_id = hs.id
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group by section
$grouped = [];
foreach ($rows as $row) {
    $key = strtolower(str_replace(' ', '_', $row['section_name']));
    if (!isset($grouped[$key])) {
        $grouped[$key] = [
          'section_name' => $row['section_name'],
          'section_id' => $row['section_id'],
          'background_color' => $row['background_color'],
          'text' => '',
          'icons' => '',
          'img' => ''
      ];
    }

    if ($row['type'] === 'text') {
        $grouped[$key]['text'] = $row['content'];
    } elseif ($row['type'] === 'icons') {
        $grouped[$key]['icons'] = $row['content'];
    } elseif ($row['type'] === 'img') {
        $grouped[$key]['img'] = $row['img'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Homepage</title>
  <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>
<h2>Hello, Admin!</h2>
<p>You're logged in with <strong>administrator access</strong>.</p>

<?php include '../../includes/admin-sidebar.php'; ?>

<h2>🛠️ Edit Homepage Content</h2>

<form method="POST" enctype="multipart/form-data">
<?php foreach ($grouped as $section_key => $section): ?>
  <div class="section-block">
    <h3><?= htmlspecialchars($section['section_name']) ?></h3>

    <label>Text Content:</label>
    <textarea name="<?= $section_key ?>[text]"><?= htmlspecialchars($section['text']) ?></textarea>

    <label>Icons:</label>
    <input type="text" name="<?= $section_key ?>[icons]" value="<?= htmlspecialchars($section['icons']) ?>">

    <label>Background Color:</label>
    <?php if (strtolower($section['section_name']) === 'call to actions'): ?>
      <span style="margin-left: 10px; font-style: italic; color: #555;">Default Background Color</span>
    <?php else: ?>
      <input 
        type="color" 
        name="<?= $section_key ?>[background_color]" 
        value="<?= htmlspecialchars($section['background_color']) ?>">
    <?php endif; ?>

    <label>Image (optional):</label>
    <?php if (!empty($section['img'])): ?>
      <div><img src="uploads/<?= htmlspecialchars($section['img']) ?>" style="max-width:150px;"></div>
    <?php endif; ?>
    <input type="file" name="<?= $section_key ?>[img]" accept="image/*">

    <input type="hidden" name="<?= $section_key ?>[id]" value="<?= $section['section_id'] ?>">
    <button type="submit" name="save_changes" value="<?= $section['section_id'] ?>" formaction="../../controllers/update-section.php">Save Changes</button>
    <button type="submit" formaction="../../controllers/delete-section.php" formmethod="POST" name="delete_section" value="<?= $section['section_id'] ?>" class="remove-btn">Remove Section🗑️</button>
  </div>
<?php endforeach; ?>
</form>

<form action="../../controllers/save-homepage.php" method="POST" enctype="multipart/form-data">
  <button type="button" id="show-new-section">➕ Add Section</button>
  <div id="new-section-form">
    <h3>➕ Create New Section</h3>

    <label>Section Name:</label>
    <input type="text" name="new_section[name]" required>

    <label>Background Color:</label>
    <input type="color" name="new_section[background_color]" value="#ffffff">

    <label>Text Content:</label>
    <textarea name="new_section[text]"></textarea>

    <label>Icons:</label>
    <input type="text" name="new_section[icons]">

    <label>Image:</label>
    <input type="file" name="new_section[img]" accept="image/*">
    <input type="submit" value="📂 Save Changes">

  </div>
</form>

<script src="../assets/js/admin.js"></script>

</body>
</html>