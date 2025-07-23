<?php
require_once '../config/database.php';

if (isset($_POST['new_section']) && !empty($_POST['new_section']['name'])) {
    $name = trim($_POST['new_section']['name']);
    $bg = $_POST['new_section']['background_color'] ?? '#ffffff';
    $text = $_POST['new_section']['text'] ?? null;
    $icons = $_POST['new_section']['icons'] ?? null;

    // Insert new section
    $stmt = $pdo->prepare("INSERT INTO homepage_sections (section_name, background_color, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$name, $bg]);
    $section_id = $pdo->lastInsertId();

    // Insert content if any
    if ($text) {
        $stmt = $pdo->prepare("INSERT INTO homepage_content (section_id, type, content, created_at) VALUES (?, 'text', ?, NOW())");
        $stmt->execute([$section_id, $text]);
    }

    if ($icons) {
        $stmt = $pdo->prepare("INSERT INTO homepage_content (section_id, type, content, created_at) VALUES (?, 'icons', ?, NOW())");
        $stmt->execute([$section_id, $icons]);
    }

    // Handle image upload
    if (isset($_FILES['new_section']) && $_FILES['new_section']['error']['img'] === UPLOAD_ERR_OK) {
        $img_name = uniqid() . "_" . basename($_FILES['new_section']['name']['img']);
        $upload_path = __DIR__ . '/../uploads/' . $img_name;
        move_uploaded_file($_FILES['new_section']['tmp_name']['img'], $upload_path);

        $stmt = $pdo->prepare("INSERT INTO homepage_content (section_id, type, img, created_at) VALUES (?, 'img', ?, NOW())");
        $stmt->execute([$section_id, $img_name]);
    }
}

header("Location: ../views/administrator/edit-homepage.php?success=1");
exit;
