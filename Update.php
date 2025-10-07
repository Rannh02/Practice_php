<?php
require_once 'database.php';

$db = new Database();
$pdo = $db->connect();


if (!isset($_GET['id'])) {
    die("No student ID provided!");
}
$student_id = $_GET['id'];


$stmt = $pdo->prepare("
    SELECT s.student_id, s.first_name, s.last_name, s.Email, c.CourseName
    FROM students s
    JOIN courses c ON s.CourseID = c.CourseID
    WHERE s.student_id = ?
");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found!");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $stmt = $pdo->prepare("SELECT CourseID FROM courses WHERE CourseName = ?");
    $stmt->execute([$_POST['course']]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($course) {
        $courseID = $course['CourseID'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO courses (CourseName) VALUES (?)");
        $stmt->execute([$_POST['course']]);
        $courseID = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("UPDATE students 
                           SET first_name = ?, last_name = ?, Email = ?, CourseID = ? 
                           WHERE student_id = ?");
    $stmt->execute([
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $courseID,
        $student_id
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
</head>
<body>
    <h1>Update Student</h1>
    <form method="POST">
        <label>First Name: 
            <input type="text" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" required>
        </label><br>
        <label>Last Name: 
            <input type="text" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" required>
        </label><br>
        <label>Email: 
            <input type="email" name="email" value="<?= htmlspecialchars($student['Email']) ?>" required>
        </label><br>
        <label>Course: 
            <input type="text" name="course" value="<?= htmlspecialchars($student['CourseName']) ?>" required>
        </label><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
