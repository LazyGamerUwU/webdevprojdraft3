<?php
require '../classes/account.class.php';
require '../classes/database.class.php';
require '../classes/events.class.php';
require '../tools/functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if the user is not an admin
Account::redirect_if_not_logged_in('admin');

global $pdo;
$eventsClass = new Events($pdo);

// Initialize variables
$title = $description = $organizers = $starttime = $endtime = $venue = $event_date = "";
$title_err = $description_err = $organizers_err = $starttime_err = $endtime_err = $venue_err = $event_date_err = "";

// Handle Create and Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs (validation logic remains the same as the original)
    if (empty(trim($_POST['title']))) {
        $title_err = "Please enter the event title.";
    } else {
        $title = trim($_POST['title']);
    }

    if (empty(trim($_POST['description']))) {
        $description_err = "Please enter the event description.";
    } else {
        $description = trim($_POST['description']);
    }

    if (empty(trim($_POST['organizers']))) {
        $organizers_err = "Please enter the organizers.";
    } else {
        $organizers = trim($_POST['organizers']);
    }

    if (empty(trim($_POST['starttime']))) {
        $starttime_err = "Please enter the start time.";
    } else {
        $starttime = trim($_POST['starttime']);
    }

    if (empty(trim($_POST['endtime']))) {
        $endtime_err = "Please enter the end time.";
    } elseif ($starttime >= trim($_POST['endtime'])) {
        $endtime_err = "End time cannot be earlier than or equal to the start time.";
    } else {
        $endtime = trim($_POST['endtime']);
    }

    if (empty(trim($_POST['venue']))) {
        $venue_err = "Please enter the venue.";
    } else {
        $venue = trim($_POST['venue']);
    }

    if (empty(trim($_POST['event_date']))) {
        $event_date_err = "Please enter the event date.";
    } else {
        $event_date = trim($_POST['event_date']);
    }

    // Check input errors before inserting or updating
    if (empty($title_err) && empty($description_err) && empty($organizers_err) &&
        empty($starttime_err) && empty($endtime_err) && empty($venue_err) && empty($event_date_err)) {

        if (!empty($_POST['update_id'])) {
            // Update existing event
            $eventsClass->updateEvent($_POST['update_id'], $title, $description, $organizers, $starttime, $endtime, $venue, $event_date);
        } else {
            // Add new event
            $eventsClass->addEvent($title, $description, $organizers, $starttime, $endtime, $venue, $event_date);
        }
        header("Location: events.php");
        exit();
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $eventsClass->deleteEvent($_GET['delete_id']);
    header("Location: events.php");
    exit();
}

// Fetch all events
$events = $eventsClass->getAllEvents();
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
    .form-control {
        border-color: #a5d6a7;
    }
    .form-control:focus {
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
    <h1>Manage Events</h1>

    <!-- Form for Create and Update -->
    <form method="POST" class="mb-4">
        <input type="hidden" id="update_id" name="update_id">
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" class="form-control <?= !empty($title_err) ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= htmlspecialchars($title) ?>">
            <span class="invalid-feedback"><?= $title_err ?></span>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control <?= !empty($description_err) ? 'is-invalid' : '' ?>" id="description" name="description"><?= htmlspecialchars($description) ?></textarea>
            <span class="invalid-feedback"><?= $description_err ?></span>
        </div>
        <div class="form-group">
            <label for="organizers">Organizers</label>
            <input type="text" class="form-control <?= !empty($organizers_err) ? 'is-invalid' : '' ?>" id="organizers" name="organizers" value="<?= htmlspecialchars($organizers) ?>">
            <span class="invalid-feedback"><?= $organizers_err ?></span>
        </div>
        <div class="form-group">
            <label for="starttime">Start Time</label>
            <input type="time" class="form-control <?= !empty($starttime_err) ? 'is-invalid' : '' ?>" id="starttime" name="starttime" value="<?= htmlspecialchars($starttime) ?>">
            <span class="invalid-feedback"><?= $starttime_err ?></span>
        </div>
        <div class="form-group">
            <label for="endtime">End Time</label>
            <input type="time" class="form-control <?= !empty($endtime_err) ? 'is-invalid' : '' ?>" id="endtime" name="endtime" value="<?= htmlspecialchars($endtime) ?>">
            <span class="invalid-feedback"><?= $endtime_err ?></span>
        </div>
        <div class="form-group">
            <label for="venue">Venue</label>
            <input type="text" class="form-control <?= !empty($venue_err) ? 'is-invalid' : '' ?>" id="venue" name="venue" value="<?= htmlspecialchars($venue) ?>">
            <span class="invalid-feedback"><?= $venue_err ?></span>
        </div>
        <div class="form-group">
            <label for="event_date">Event Date</label>
            <input type="date" class="form-control <?= !empty($event_date_err) ? 'is-invalid' : '' ?>" id="event_date" name="event_date" value="<?= htmlspecialchars($event_date) ?>">
            <span class="invalid-feedback"><?= $event_date_err ?></span>
        </div>
        <button type="submit" class="btn btn-primary" id="form-submit-btn">Add Event</button>
    </form>

    <h2>Event List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Organizers</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Venue</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['title']) ?></td>
                    <td><?= htmlspecialchars($event['description']) ?></td>
                    <td><?= htmlspecialchars($event['organizers']) ?></td>
                    <td><?= htmlspecialchars($event['starttime']) ?></td>
                    <td><?= htmlspecialchars($event['endtime']) ?></td>
                    <td><?= htmlspecialchars($event['venue']) ?></td>
                    <td><?= htmlspecialchars($event['event_date']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-btn" 
                                data-id="<?= $event['id'] ?>" 
                                data-title="<?= htmlspecialchars($event['title']) ?>" 
                                data-description="<?= htmlspecialchars($event['description']) ?>" 
                                data-organizers="<?= htmlspecialchars($event['organizers']) ?>"
                                data-starttime="<?= htmlspecialchars($event['starttime']) ?>"
                                data-endtime="<?= htmlspecialchars($event['endtime']) ?>"
                                data-venue="<?= htmlspecialchars($event['venue']) ?>"
                                data-event_date="<?= htmlspecialchars($event['event_date']) ?>">
                            Edit
                        </button>
                        <a href="events.php?delete_id=<?= $event['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
<script>
    // Populate the form for editing
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('update_id').value = this.dataset.id;
            document.getElementById('title').value = this.dataset.title;
            document.getElementById('description').value = this.dataset.description;
            document.getElementById('organizers').value = this.dataset.organizers;
            document.getElementById('starttime').value = this.dataset.starttime;
            document.getElementById('endtime').value = this.dataset.endtime;
            document.getElementById('venue').value = this.dataset.venue;
            document.getElementById('event_date').value = this.dataset.event_date;
            document.getElementById('form-submit-btn').textContent = 'Update Event';
        });
    });
</script>
</body>
</html>
