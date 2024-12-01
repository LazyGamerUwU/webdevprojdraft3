<?php
require '../classes/database.class.php';

global $pdo;

if (isset($_GET['student_number'])) {
    $student_number = trim($_GET['student_number']);
    $stmt = $pdo->prepare("
        SELECT 
            CONCAT(last_name, ', ', first_name, ' ', middle_name) AS name, 
            course 
        FROM students 
        WHERE student_number = :student_number
    ");
    $stmt->bindParam(':student_number', $student_number);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        echo json_encode(['success' => true, 'name' => $student['name'], 'course' => $student['course']]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
