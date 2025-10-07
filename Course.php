<?php
session_start();
require_once 'database.php';

$db = new Database();
$pdo = $db->connect(); 


$stmt = $pdo->query("
    SELECT CourseID, CourseName
    FROM courses
    ORDER BY CourseName ASC
");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Courses</h1>
    <button style="margin-left:25%;"class="Coursebtn" onclick="window.location.href='Course.php'">Course</button>
    <button class="Course" onclick="window.location.href='Students.php'">Students</button>

    <table class="TableCourses" border="1">
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= htmlspecialchars($course['CourseID']) ?></td>
                    <td><?= htmlspecialchars($course['CourseName']) ?></td>
                    <td>
                        <button class="Action" onclick="window.location.href='UpdateCourse.php?id=<?= $course['CourseID'] ?>'">
                            Update
                        </button>
                    </td>
                    <td>
                        <button class="Action" onclick="if(confirm('Are you sure you want to delete this course?')) window.location.href='DeleteCourse.php?id=<?= $course['CourseID'] ?>'">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
