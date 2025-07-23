<?php
require_once '../config/database.php';

function upsertContent($pdo, $section_id, $type, $content, $img_path = null) {
    // Check if the content type already exists for the section
    $stmt = $pdo->prepare("SELECT id FROM homepage_content WHERE section_id = ? AND type = ?");
    $stmt->execute([$section_id, $type]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Update if exists
        if ($type === 'img') {
            $stmt = $pdo->prepare("UPDATE homepage_content SET img = ? WHERE id = ?");
            $stmt->execute([$img_path, $existing['id']]);
        } else {
            $stmt = $pdo->prepare("UPDATE homepage_content SET content = ? WHERE id = ?");
            $stmt->execute([$content, $existing['id']]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $data) {
        if (!is_array($data) || !isset($data['id'])) continue;

        $section_id = $data['id'];

        // Update section background color if provided
        if (!empty($data['background_color'])) {
            $stmt = $pdo->prepare("UPDATE homepage_sections SET background_color = ? WHERE id = ?");
            $stmt->execute([$data['background_color'], $section_id]);
        }

        // Update text
        if (!empty($data['text'])) {
            upsertContent($pdo, $section_id, 'text', $data['text']);
        }

        // Update icons
        if (!empty($data['icons'])) {
            upsertContent($pdo, $section_id, 'icons', $data['icons']);
        }

        // Update image if uploaded
        if (isset($_FILES[$key]) && $_FILES[$key]['error']['img'] === UPLOAD_ERR_OK) {
            $filename = uniqid() . '_' . basename($_FILES[$key]['name']['img']);
            $upload_dir = __DIR__ . '/../uploads/';
            $upload_path = $upload_dir . $filename;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($_FILES[$key]['tmp_name']['img'], $upload_path)) {
                upsertContent($pdo, $section_id, 'img', '', $filename);
            }
        }
    }
}

header("Location: ../views/administrator/edit-homepage.php?update=success");
exit;
