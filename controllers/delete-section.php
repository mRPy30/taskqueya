<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_section'])) {
    $section_id = intval($_POST['delete_section']);

    try {
        // Delete associated content first
        $stmt = $pdo->prepare("DELETE FROM homepage_content WHERE section_id = ?");
        $stmt->execute([$section_id]);

        // Then delete the section
        $stmt = $pdo->prepare("DELETE FROM homepage_sections WHERE id = ?");
        $stmt->execute([$section_id]);

        header("Location: ../views/administrator/edit-homepage.php?deleted=1");
        exit;
    } catch (PDOException $e) {
        echo "Error deleting section: " . $e->getMessage();
    }
} else {
    header("Location: ../views/administrator/edit-homepage.php");
    exit;
}
