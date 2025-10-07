<?php
session_start();
require_once 'database.php';

$db = new Database();
$pdo = $db->connect(); 


$stmt = $pdo->query("
    SELECT s.student_id, s.first_name, s.last_name, s.Email, c.CourseName
    FROM students s
    JOIN courses c ON s.CourseID = c.CourseID
");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Students</h1>
    <button class="AddButton"onclick="window.location.href='Create.php'">Add Student</button>
    <button class="Course"onclick="window.location.href='Course.php'">Course</button>
    <button class="Course"onclick="window.location.href='Students.php'">Students</button>

    <table class="TableStudents"border="1">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['first_name']) ?></td>
                    <td><?= htmlspecialchars($student['last_name']) ?></td>
                    <td><?= htmlspecialchars($student['Email']) ?></td>
                    <td><?= htmlspecialchars($student['CourseName']) ?></td>
                    <td>
                        <button class="Action" onclick="window.location.href='Update.php?id=<?= $student['student_id'] ?>'">
                            Update
                        </button>
                    </td>
                    <td>
                        <button class="Action"onclick="if(confirm('Are you sure you want to delete this student?')) window.location.href='Delete.php?id=<?= $student['student_id'] ?>'">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</body>
</html>
