<?php
// Run Python script
$output = shell_exec("python3 ../views/auth/verify_face.py");

// Parse output (from Python)
$response = json_decode($output, true);

if ($response['status'] === 'success') {
    session_start();
    $_SESSION['admin_email'] = $response['email']; // store email to session

    // Redirect to admin dashboard
    header("Location: ../views/admininistrator/dashboard.php");
    exit;
} else {
    // Return to login page with error
    header("Location: ../views/auth/admin-login.php?error=face_not_recognized");
    exit;
}
?>