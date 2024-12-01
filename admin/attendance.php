<?php
require '../classes/account.class.php';
require '../classes/database.class.php';
require '../tools/functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Redirect if the user is not an admin
Account::redirect_if_not_logged_in('admin');

global $pdo;

// Initialize variables
$event_id = $student_number = $student_name = $time_in = $time_out = $course = "";
$event_id_err = $student_number_err = $time_in_err = $time_out_err = "";

// Fetch all events for the dropdown
$events = $pdo->query("SELECT * FROM events ORDER BY event_date ASC")->fetchAll(PDO::FETCH_ASSOC);

// Handle Create and Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (empty(trim($_POST['event_id']))) {
        $event_id_err = "Please select an event.";
    } else {
        $event_id = trim($_POST['event_id']);
    }

    if (empty(trim($_POST['student_number']))) {
        $student_number_err = "Please enter the student number.";
    } else {
        $student_number = trim($_POST['student_number']);
        // Fetch student name and course
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
            $student_name = $student['name'];
            $course = $student['course'];
        } else {
            $student_number_err = "Student not found.";
        }
    }

    if (empty(trim($_POST['time_in']))) {
        $time_in_err = "Please enter the time in.";
    } else {
        $time_in = trim($_POST['time_in']);
    }

    if (empty(trim($_POST['time_out']))) {
        $time_out_err = "Please enter the time out.";
    } elseif ($time_in >= trim($_POST['time_out'])) {
        $time_out_err = "Time out cannot be earlier than or equal to the time in.";
    } else {
        $time_out = trim($_POST['time_out']);
    }

    // Check input errors before inserting or updating in the database
    if (empty($event_id_err) && empty($student_number_err) && empty($time_in_err) && empty($time_out_err)) {
        if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
            $sql = "UPDATE attendance SET event_id = :event_id, student_number = :student_number, student_name = :student_name, time_in = :time_in, time_out = :time_out WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":event_id", $event_id);
            $stmt->bindParam(":student_number", $student_number);
            $stmt->bindParam(":student_name", $student_name);
            $stmt->bindParam(":time_in", $time_in);
            $stmt->bindParam(":time_out", $time_out);
            $stmt->bindParam(":id", $_POST['update_id']);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO attendance (event_id, student_number, student_name, time_in, time_out) VALUES (:event_id, :student_number, :student_name, :time_in, :time_out)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":event_id", $event_id);
            $stmt->bindParam(":student_number", $student_number);
            $stmt->bindParam(":student_name", $student_name);
            $stmt->bindParam(":time_in", $time_in);
            $stmt->bindParam(":time_out", $time_out);
            $stmt->execute();
        }
        header("Location: attendance.php?event_id=$event_id");
        exit();
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $sql = "DELETE FROM attendance WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_GET['delete_id']);
    $stmt->execute();
    header("Location: attendance.php?event_id=" . clean_input($_GET['event_id']));
    exit();
}

// Fetch attendance data for the selected event
$attendance_data = [];
if (isset($_GET['event_id'])) {
    $event_id = clean_input($_GET['event_id']);
    $stmt = $pdo->prepare("
        SELECT 
            a.id, a.student_number, a.time_in, a.time_out, 
            CONCAT(s.last_name, ', ', s.first_name, ' ', s.middle_name) AS student_name, 
            s.course 
        FROM attendance a 
        INNER JOIN students s ON a.student_number = s.student_number 
        WHERE a.event_id = :event_id 
        ORDER BY a.time_in ASC
    ");
    $stmt->bindParam(':event_id', $event_id);
    $stmt->execute();
    $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../includes/_head.php'; ?>
<style>
    body {
        background-image: url('../images/9713c927-ce90-4aa7-8850-a69ca4024a49.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: Arial, sans-serif;
        color: #2e7d32;
        min-height: 100vh;
    }
    .container {
        background-color: #ffffff;
        border: 1px solid #a5d6a7;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 50px auto;
    }
    h1, h2 {
        color: #1b5e20;
        margin-bottom: 20px;
    }
    .form-control, .form-select {
        border-color: #a5d6a7;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
    }
    .btn-primary {
        background-color: #2e7d32;
        border-color: #2e7d32;
        margin-top: 20px;
    }
    .btn-primary:hover {
        background-color: #1b5e20;
        border-color: #1b5e20;
    }
    .table {
        color: #2e7d32;
    }
    .table thead th {
        background-color: #c8e6c9;
        border-color: #a5d6a7;
        color: #1b5e20;
    }
    .table td {
        border-color: #a5d6a7;
    }
    footer p {
        color: #ffffff !important;
        text-align: center;
        margin-bottom: 0;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
</style>
<body>
<?php include '../includes/_topnav.php'; ?>

<div class="container mt-4">
    <h1>Manage Attendance</h1>

    <!-- Event Selection -->
    <form method="GET" class="mb-4">
        <div class="form-group">
            <label for="event_id">Select Event</label>
            <select class="form-control" id="event_id" name="event_id" onchange="this.form.submit()">
                <option value="">Select...</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['id'] ?>" <?= $event_id == $event['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if (!empty($event_id)): ?>
        <!-- Form for Create and Update -->
        <form method="POST" class="mb-4">
            <input type="hidden" id="update_id" name="update_id">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <div class="form-group">
                <label for="student_number">Student Number</label>
                <input type="text" class="form-control <?= !empty($student_number_err) ? 'is-invalid' : '' ?>" id="student_number" name="student_number" value="<?= htmlspecialchars($student_number) ?>">
                <span class="invalid-feedback"><?= $student_number_err ?></span>
            </div>
            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" readonly>
            </div>
            <div class="form-group">
                <label for="student_course">Course</label>
                <input type="text" class="form-control" id="student_course" name="student_course" readonly>
            </div>
            <div class="form-group">
                <label for="time_in">Time In</label>
                <input type="time" class="form-control <?= !empty($time_in_err) ? 'is-invalid' : '' ?>" id="time_in" name="time_in" value="<?= htmlspecialchars($time_in) ?>">
                <span class="invalid-feedback"><?= $time_in_err ?></span>
            </div>
            <div class="form-group">
                <label for="time_out">Time Out</label>
                <input type="time" class="form-control <?= !empty($time_out_err) ? 'is-invalid' : '' ?>" id="time_out" name="time_out" value="<?= htmlspecialchars($time_out) ?>">
                <span class="invalid-feedback"><?= $time_out_err ?></span>
            </div>
            <button type="submit" class="btn btn-primary" id="form-submit-btn">Add Attendance</button>
        </form>

        <!-- Attendance List -->
        <h2>Attendance List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance_data as $entry): ?>
                    <tr>
                        <td><?= htmlspecialchars($entry['student_number']) ?></td>
                        <td><?= htmlspecialchars($entry['student_name']) ?></td>
                        <td><?= htmlspecialchars($entry['course']) ?></td>
                        <td><?= htmlspecialchars($entry['time_in']) ?></td>
                        <td><?= htmlspecialchars($entry['time_out']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $entry['id'] ?>" data-student_number="<?= $entry['student_number'] ?>" data-time_in="<?= $entry['time_in'] ?>" data-time_out="<?= $entry['time_out'] ?>">
                                Edit
                            </button>
                            <a href="attendance.php?delete_id=<?= $entry['id'] ?>&event_id=<?= $event_id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<footer class="text-center py-3 mt-5">
    <p class="mb-0">&copy; 2024 Event Management System. All Rights Reserved.</p>
</footer>

<script>
    document.getElementById('student_number').addEventListener('input', function () {
        const studentNumber = this.value;
        if (studentNumber.length > 0) {
            fetch(`get_student_name.php?student_number=${studentNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('student_name').value = data.name;
                        document.getElementById('student_course').value = data.course;
                    } else {
                        document.getElementById('student_name').value = '';
                        document.getElementById('student_course').value = '';
                    }
                });
        } else {
            document.getElementById('student_name').value = '';
            document.getElementById('student_course').value = '';
        }
    });
</script>
</body>
</html>
