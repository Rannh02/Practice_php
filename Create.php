<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new Database();
    $pdo = $db->connect();


    $stmt = $pdo->prepare("SELECT student_id FROM students WHERE Email = ?");
    $stmt->execute([$_POST['email']]);
    $existingStudent = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingStudent) {
        die("❌ Error: This email is already registered. Please use another email.");
    }

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

    $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, Email, CourseID) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['email'], $courseID]);

    header("Location: Students.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Add Student</h1>
    <form class="Form" method="POST">
        <label>First Name: <input type="text" name="first_name" required></label><br>
        <label>Last Name: <input type="text" name="last_name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Course: <input type="text" name="course" required></label><br>
        <button type="submit">Save</button>
        <button type="button" onclick="window.location.href='Students.php'">Cancel</button>
    </form>
</body>
</html>
