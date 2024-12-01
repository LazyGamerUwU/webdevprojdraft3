<?php
require '../classes/account.class.php';
require '../classes/database.class.php';
require '../tools/functions.php';
session_start();

// Redirect if the user is not an admin
Account::redirect_if_not_logged_in('admin');

global $pdo;

// Initialize variables
$student_number = $last_name = $first_name = $middle_name = $course = $year_level = $section = $birthdate = $sex = $address = $wmsu_email = $personal_email = $status = "";
$student_number_err = $name_err = $course_err = $year_level_err = $section_err = $birthdate_err = $sex_err = $address_err = $wmsu_email_err = $personal_email_err = $status_err = "";

// Handle Create and Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (empty(trim($_POST['student_number']))) {
        $student_number_err = "Please enter the student number.";
    } else {
        $student_number = trim($_POST['student_number']);
    }

    if (empty(trim($_POST['last_name'])) || empty(trim($_POST['first_name'])) || empty(trim($_POST['middle_name']))) {
        $name_err = "Please enter the student's full name.";
    } else {
        $last_name = trim($_POST['last_name']);
        $first_name = trim($_POST['first_name']);
        $middle_name = trim($_POST['middle_name']);
    }

    if (empty(trim($_POST['course']))) {
        $course_err = "Please enter the course.";
    } else {
        $course = trim($_POST['course']);
    }

    if (empty(trim($_POST['year_level']))) {
        $year_level_err = "Please enter the year level.";
    } else {
        $year_level = trim($_POST['year_level']);
    }
    if (empty(trim($_POST['section'] ?? ''))) { 
        $section_err = "Please enter the section.";
    } else {
        $section = trim($_POST['section']);
    }

    if (empty(trim($_POST['birthdate']))) {
        $birthdate_err = "Please enter the birthdate.";
    } else {
        $birthdate = trim($_POST['birthdate']);
    }
    if (empty(trim($_POST['sex'] ?? ''))) { 
        $sex_err = "Please enter the sex.";
    } else {
        $sex = trim($_POST['sex']);
    }

    if (empty(trim($_POST['address']))) {
        $address_err = "Please enter the address.";
    } else {
        $address = trim($_POST['address']);
    }

    if (empty(trim($_POST['wmsu_email']))) {
        $wmsu_email_err = "Please enter the WMSU email.";
    } else {
        $wmsu_email = trim($_POST['wmsu_email']);
    }

    if (empty(trim($_POST['personal_email']))) {
        $personal_email_err = "Please enter the personal email.";
    } else {
        $personal_email = trim($_POST['personal_email']);
    }
    if (empty(trim($_POST['status'] ?? ''))) { 
        $status_err = "Please enter the status.";
    } else {
        $status = trim($_POST['status']);
    }

    // Check input errors before inserting or updating in the database
    if (empty($student_number_err) && empty($name_err) && empty($course_err) && empty($year_level_err) && empty($section_err) && empty($birthdate_err) && empty($sex_err) && empty($address_err) && empty($wmsu_email_err) && empty($personal_email_err) && empty($status_err)) {
        if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
            // Prepare an update statement
            $sql = "UPDATE students SET student_number = :student_number, last_name = :last_name, first_name = :first_name, middle_name = :middle_name, course = :course, year_level = :year_level, section = :section, birthdate = :birthdate, sex = :sex, address = :address, wmsu_email = :wmsu_email, personal_email = :personal_email, status = :status WHERE id = :id";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":student_number", $student_number);
                $stmt->bindParam(":last_name", $last_name);
                $stmt->bindParam(":first_name", $first_name);
                $stmt->bindParam(":middle_name", $middle_name);
                $stmt->bindParam(":course", $course);
                $stmt->bindParam(":year_level", $year_level);
                $stmt->bindParam(":section", $section);
                $stmt->bindParam(":birthdate", $birthdate);
                $stmt->bindParam(":sex", $sex);
                $stmt->bindParam(":address", $address);
                $stmt->bindParam(":wmsu_email", $wmsu_email);
                $stmt->bindParam(":personal_email", $personal_email);
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":id", $_POST['update_id']);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Record updated successfully. Redirect to landing page
                    header("Location: students.php");
                    exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        } else {
            // Prepare an insert statement
            $sql = "INSERT INTO students (student_number, last_name, first_name, middle_name, course, year_level, section, birthdate, sex, address, wmsu_email, personal_email, status) VALUES (:student_number, :last_name, :first_name, :middle_name, :course, :year_level, :section, :birthdate, :sex, :address, :wmsu_email, :personal_email, :status)";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":student_number", $student_number);
                $stmt->bindParam(":last_name", $last_name);
                $stmt->bindParam(":first_name", $first_name);
                $stmt->bindParam(":middle_name", $middle_name);
                $stmt->bindParam(":course", $course);
                $stmt->bindParam(":year_level", $year_level);
                $stmt->bindParam(":section", $section);
                $stmt->bindParam(":birthdate", $birthdate);
                $stmt->bindParam(":sex", $sex);
                $stmt->bindParam(":address", $address);
                $stmt->bindParam(":wmsu_email", $wmsu_email);
                $stmt->bindParam(":personal_email", $personal_email);
                $stmt->bindParam(":status", $status);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Record created successfully. Redirect to landing page
                    header("Location: students.php");
                    exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $sql = "DELETE FROM students WHERE id = :id";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $_GET['delete_id']);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Record deleted successfully. Redirect to landing page
            header("Location: students.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}

// Fetch all students
$sql = "SELECT * FROM students ORDER BY last_name ASC, first_name ASC";
$students = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
    .table td .btn {
        margin: 3px;  /* This adds space around all buttons in table cells */
    }
</style>
<body>
<?php include '../includes/_topnav.php'; ?>
<script src="../js/bootstrap.bundle.min.js"></script>
<div class="container mt-4">
    <h1>Manage Students</h1>

    <!-- Form for Create and Update -->
    <form method="POST" class="mb-4">
        <input type="hidden" id="update_id" name="update_id">
        <div class="form-group">
            <label for="student_number">Student Number</label>
            <input type="text" class="form-control <?= !empty($student_number_err) ? 'is-invalid' : '' ?>" id="student_number" name="student_number" value="<?= htmlspecialchars($student_number) ?>">
            <span class="invalid-feedback"><?= $student_number_err ?></span>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>    
            <input type="text" class="form-control <?= !empty($name_err) ? 'is-invalid' : '' ?>" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name) ?>">
            <span class="invalid-feedback"><?= $name_err ?></span>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control <?= !empty($name_err) ? 'is-invalid' : '' ?>" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name) ?>">
            <span class="invalid-feedback"><?= $name_err ?></span>
        </div>
        <div class="form-group">
            <label for="middle_name">Middle Name</label>
            <input type="text" class="form-control <?= !empty($name_err) ? 'is-invalid' : '' ?>" id="middle_name" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">
            <span class="invalid-feedback"><?= $name_err ?></span>
        </div>
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" class="form-control <?= !empty($course_err) ? 'is-invalid' : '' ?>" id="course" name="course" value="<?= htmlspecialchars($course) ?>">
            <span class="invalid-feedback"><?= $course_err ?></span>
        </div>
        <div class="form-group">
            <label for="year_level">Year Level</label>
            <input type="number" class="form-control <?= !empty($year_level_err) ? 'is-invalid' : '' ?>" id="year_level" name="year_level" value="<?= htmlspecialchars($year_level) ?>">
            <span class="invalid-feedback"><?= $year_level_err ?></span>
        </div>
        <div class="form-group">
            <label for="section">Section</label>
            <select class="form-select <?= !empty($section_err) ? 'is-invalid' : '' ?>" id="section" name="section" >
                <option value="" disabled selected>Select Section</option>
                <option value="A" <?= ($section ?? '') === 'A' ? 'selected' : '' ?>>A</option>
                <option value="B" <?= ($section ?? '') === 'B' ? 'selected' : '' ?>>B</option>
                <option value="C" <?= ($section ?? '') === 'C' ? 'selected' : '' ?>>C</option>
            </select>
            <span class="invalid-feedback"><?= $section_err ?? '' ?></span>
        </div>

        <div class="form-group">
            <label for="birthdate">Birthdate</label>
            <input type="date" class="form-control <?= !empty($birthdate_err) ? 'is-invalid' : '' ?>" id="birthdate" name="birthdate" value="<?= htmlspecialchars($birthdate) ?>">
            <span class="invalid-feedback"><?= $birthdate_err ?></span>
        </div>
        <div class="form-group">
            <label for="sex">Sex</label>
            <select class="form-select <?= !empty($sex_err) ? 'is-invalid' : '' ?>" id="sex" name="sex">
                <option value="" disabled selected>Select Sex</option>
                <option value="Male" <?= ($sex ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= ($sex ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
            <span class="invalid-feedback"><?= $sex_err ?? '' ?></span>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control <?= !empty($address_err) ? 'is-invalid' : '' ?>" id="address" name="address" value="<?= htmlspecialchars($address) ?>">
            <span class="invalid-feedback"><?= $address_err ?></span>
        </div>
        <div class="form-group">
            <label for="wmsu_email">WMSU Email</label>
            <input type="email" class="form-control <?= !empty($wmsu_email_err) ? 'is-invalid' : '' ?>" id="wmsu_email" name="wmsu_email" value="<?= htmlspecialchars($wmsu_email) ?>">
            <span class="invalid-feedback"><?= $wmsu_email_err ?></span>
        </div>
        <div class="form-group">
            <label for="personal_email">Personal Email</label>
            <input type="email" class="form-control <?= !empty($personal_email_err) ? 'is-invalid' : '' ?>" id="personal_email" name="personal_email" value="<?= htmlspecialchars($personal_email) ?>">
            <span class="invalid-feedback"><?= $personal_email_err ?></span>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-select <?= !empty($status_err) ? 'is-invalid' : '' ?>" id="status" name="status">
                <option value="" disabled selected>Select Status</option>
                <option value="Regular" <?= ($status ?? '') === 'Regular' ? 'selected' : '' ?>>Regular</option>
                <option value="Irregular" <?= ($status ?? '') === 'Irregular' ? 'selected' : '' ?>>Irregular</option>
            </select>
            <span class="invalid-feedback"><?= $status_err ?? '' ?></span>
        </div>

        <button type="submit" class="btn btn-primary" id="form-submit-btn">Add Student</button>
    </form>

    <h2>Student List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Section</th>
                <th>Birthdate</th>
                <th>Sex</th>
                <th>Address</th>
                <th>WMSU Email</th>
                <th>Personal Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['student_number']) ?></td>
                    <td><?= htmlspecialchars($student['last_name']) ?>, <?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['middle_name']) ?></td>
                    <td><?= htmlspecialchars($student['course']) ?></td>
                    <td><?= htmlspecialchars($student['year_level']) ?></td>
                    <td><?= htmlspecialchars($student['section']) ?></td>
                    <td><?= htmlspecialchars($student['birthdate']) ?></td>
                    <td><?= htmlspecialchars($student['sex']) ?></td>
                    <td><?= htmlspecialchars($student['address']) ?></td>
                    <td><?= htmlspecialchars($student['wmsu_email']) ?></td>
                    <td><?= htmlspecialchars($student['personal_email']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-btn" 
                                data-id="<?= $student['id'] ?>" 
                                data-student_number="<?= htmlspecialchars($student['student_number']) ?>" 
                                data-last_name="<?= htmlspecialchars($student['last_name']) ?>" 
                                data-first_name="<?= htmlspecialchars($student['first_name']) ?>" 
                                data-middle_name="<?= htmlspecialchars($student['middle_name']) ?>" 
                                data-course="<?= htmlspecialchars($student['course']) ?>" 
                                data-year_level="<?= htmlspecialchars($student['year_level']) ?>"
                                data-section="<?= htmlspecialchars($student['section']) ?>"
                                data-birthdate="<?= htmlspecialchars($student['birthdate']) ?>"
                                data-sex="<?= htmlspecialchars($student['sex']) ?>"
                                data-address="<?= htmlspecialchars($student['address']) ?>"
                                data-wmsu_email="<?= htmlspecialchars($student['wmsu_email']) ?>"
                                data-personal_email="<?= htmlspecialchars($student['personal_email']) ?>"
                                data-status="<?= htmlspecialchars($student['status']) ?>">
                            Edit
                        </button>
                        <a href="students.php?delete_id=<?= $student['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer class="text-center py-3 mt-5">
    <p class="mb-0">&copy; 2024 Event Management System. All Rights Reserved.</p>
</footer>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script>
    // Populate the form for editing
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('update_id').value = this.dataset.id;
            document.getElementById('student_number').value = this.dataset.student_number;
            document.getElementById('last_name').value = this.dataset.last_name;
            document.getElementById('first_name').value = this.dataset.first_name;
            document.getElementById('middle_name').value = this.dataset.middle_name;
            document.getElementById('course').value = this.dataset.course;
            document.getElementById('year_level').value = this.dataset.year_level;
            document.getElementById('section').value = this.dataset.section;
            document.getElementById('birthdate').value = this.dataset.birthdate;
            document.getElementById('sex').value = this.dataset.sex;
            document.getElementById('address').value = this.dataset.address;
            document.getElementById('wmsu_email').value = this.dataset.wmsu_email;
            document.getElementById('personal_email').value = this.dataset.personal_email;
            document.getElementById('status').value = this.dataset.status;
            document.getElementById('form-submit-btn').textContent = 'Update Student';
        });
    });
</script>

</body>
</html>

