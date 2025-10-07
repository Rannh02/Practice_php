<?php
require_once 'database.php';

if (!isset($_GET['id'])) {
    die("No student ID provided!");
}

$student_id = $_GET['id'];

try {
    $db = new Database();
    $pdo = $db->connect();

    // ✅ Delete the student
    $stmt = $pdo->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);

    // ✅ Redirect back to list
    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    die("Error deleting student: " . $e->getMessage());
}
?>
