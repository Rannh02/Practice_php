<?php
require_once 'database.php';

$db = new Database();
$pdo = $db->connect();


if (!isset($_GET['id'])) {
    die("No course ID provided!");
}
$course_id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM courses WHERE CourseID = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die("Course not found!");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("UPDATE courses 
                           SET CourseName = ? 
                           WHERE CourseID = ?");
    $stmt->execute([
        $_POST['course_name'],
        $course_id
    ]);

    header("Location: Course.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Course</title>
</head>
<body>
    <h1>Update Course</h1>
    <form method="POST">
        <label>Course Name: 
            <input type="text" name="course_name" value="<?= htmlspecialchars($course['CourseName']) ?>" required>
        </label><br><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
