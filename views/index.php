<?php
require_once '../config/database.php';

// Fetch CTA (section_id = 1) separately
$cta = ['text' => '', 'icons' => '', 'img' => '', 'bg' => '', 'name' => ''];

$ctaStmt = $pdo->prepare("
    SELECT hs.section_name, hs.background_color, hc.type, hc.content, hc.img
    FROM homepage_sections hs
    LEFT JOIN homepage_content hc ON hc.section_id = hs.id
    WHERE hs.id = 1
");
$ctaStmt->execute();
$ctaRows = $ctaStmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($ctaRows as $row) {
    $cta['name'] = $row['section_name'];
    $cta['bg'] = $row['background_color'];

    if ($row['type'] === 'text') {
        $cta['text'] = $row['content'];
    } elseif ($row['type'] === 'icons') {
        $cta['icons'] = $row['content'];
    } elseif ($row['type'] === 'img') {
        $cta['img'] = $row['img'];
    }
}

// Fetch remaining sections (excluding CTA)
$stmt = $pdo->query("
    SELECT hs.id AS section_id, hs.section_name, hs.background_color,
           hc.type, hc.content, hc.img
    FROM homepage_sections hs
    LEFT JOIN homepage_content hc ON hc.section_id = hs.id
    WHERE hs.id != 1
    ORDER BY hs.id ASC
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group other sections
$sections = [];

foreach ($rows as $row) {
    $id = $row['section_id'];
    if (!isset($sections[$id])) {
        $sections[$id] = [
            'name' => $row['section_name'],
            'bg' => $row['background_color'],
            'text' => '',
            'icons' => '',
            'img' => ''
        ];
    }

    if ($row['type'] === 'text') {
        $sections[$id]['text'] = $row['content'];
    } elseif ($row['type'] === 'icons') {
        $sections[$id]['icons'] = $row['content'];
    } elseif ($row['type'] === 'img') {
        $sections[$id]['img'] = $row['img'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!--Title-->
  <link rel="short icon" href="../Logo-TQ.png" type="x-icon">
  <title>TaskQueya</title>

  <!--Css Links-->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/font.css">

  <!--ICON LINKS-->
  <link rel="stylesheet" href="../font-awesome-6/css/all.css">

  <!--navbar header-->
  <?php include '../includes/header.php'; ?>

</head>
<body>

  <main>
  <section class="homepage-section call-to-action">
    <?php if (!empty($cta['text'])): ?>
      <div class="text-content">
        <h5><?= nl2br(htmlspecialchars($cta['text'])) ?></h5>
      </div>
    <?php endif; ?>

    <?php if (!empty($cta['icons'])): ?>
      <div class="icons">
        <?= htmlspecialchars($cta['icons']) ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($cta['img'])): ?>
      <div class="image">
        <img src="uploads/<?= htmlspecialchars($cta['img']) ?>" alt="Call to Action Image">
      </div>
    <?php endif; ?>
  </section>

  <div class="divider"></div>

  <!-- Calendar -->
  <div class="calendar">
    <div id="calendar-day" class="day"></div>
    <div id="calendar-month" class="month"></div>
    <div id="calendar-year" class="year">2025</div>
  </div>
   <!--more content-->
  </main>
  
  <?php foreach ($sections as $section): ?>
  <section class="homepage-section grid text-center" style="background-color: <?= htmlspecialchars($section['bg']) ?>; padding: 40px 20px;">
    <div class="section-inner" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; align-items: center; text-align: center;">
      
      <?php if (in_array($section['name'], ['About Us', 'Contact Us'])): ?>
        <h2 style="font-size: 2em; margin-bottom: 20px;"><?= htmlspecialchars($section['name']) ?></h2>
      <?php endif; ?>

      <?php if (!empty($section['text'])): ?>
        <div class="section-text">
          <p><?= nl2br(htmlspecialchars($section['text'])) ?></p>
        </div>
      <?php endif; ?>

      <?php if (!empty($section['icons'])): ?>
        <div class="section-icons">
          <?= $section['icons'] ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($section['img'])): ?>
        <div class="section-image">
          <img src="uploads/<?= htmlspecialchars($section['img']) ?>" alt="<?= htmlspecialchars($section['name']) ?> Image" style="max-width: 100%; height: auto; border-radius: 8px;">
        </div>
      <?php endif; ?>

    </div>
  </section>
<?php endforeach; ?>

  <script src="assets/js/index.js"></script>

</body>
<?php include '../includes/footer.php'; ?>

</html>
