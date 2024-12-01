<?php
require './classes/account.class.php';
require './classes/database.class.php';
session_start();

global $pdo;
$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-light px-4">
            <div class="container-fluid">
                <img src="images/CCS logo.jpg" alt="CCS Logo" class="navbar-logo">
                <a class="navbar-brand" href="index.php">Ocesion Event Management System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav me-5">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="events_index.php">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="account/login.php">Log In</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<div class="container mt-5">
    <h1 class="text-center mb-4 text-white">Event Calendar</h1>
    <div class="card shadow border-success">
        <div class="card-header bg-success text-white">
            <h2 class="card-title mb-0">Event List</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-success text-white">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Organizers</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Venue</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?= htmlspecialchars($event['title']) ?></td>
                                <td><?= htmlspecialchars($event['description']) ?></td>
                                <td><?= htmlspecialchars($event['organizers']) ?></td>
                                <td><?= htmlspecialchars($event['starttime']) ?></td>
                                <td><?= htmlspecialchars($event['endtime']) ?></td>
                                <td><?= htmlspecialchars($event['venue']) ?></td>
                                <td><?= htmlspecialchars($event['event_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger">No events found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
<?php include './includes/_footer.php'; ?>
</body>
</html>
