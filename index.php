<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocesion Event Management System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .highlight {
            color: green;
            font-weight: bold;
        }
        .organizations {
            margin-top: 30px;
        }
        .org-list {
            list-style-type: none;
            padding: 0;
        }
        .org-list li {
            margin: 5px 0;
        }
        .cta {
            margin-top: 20px;
            font-size: 1.2em;
        }
    </style>
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

    <main>
        <div class="container mt-5">
            <div class="text-center">
                <h1 class="display-4">OCESION EVENT MANAGEMENT SYSTEM</h1>
                <p class="lead">Here at the <span class="highlight">College of Computing Studies</span>, we turn dreams into <strong>digital reality</strong>.</p>
                <p>Whether you're coding your way through the exciting world of <span class="highlight">Computer Science</span> or mastering the art of managing data with <span class="highlight">Information Management</span>, this is where innovation begins!</p>
                <div class="organizations">
                    <h2 class="text-center mb-4">Be Part of Our Vibrant Community!</h2>
                    <p class="text-center mb-4">We're not just about academics – we're about building a community of leaders and innovators. Join one of our dynamic organizations:</p>
                    <div class="org-container">
                        <div class="org-card tech-card">
                            <h3>PhiCSS</h3>
                            <p>The <i>Philippine Computing Students Society</i>, where passion for tech meets fun and collaboration.</p>
                        </div>
                        
                        <div class="org-card diversity-card">
                            <h3>GenderClub</h3>
                            <p>Promoting inclusivity, diversity, and empowerment within the department.</p>
                        </div>
                        
                        <div class="org-card leadership-card">
                            <h3>CSC</h3>
                            <p>Your College Student Council, dedicated to making every student's journey unforgettable!</p>
                        </div>
                        
                        <div class="org-card dev-card">
                            <h3>Google Developer Student Club</h3>
                            <p>Build, code, and innovate with a community of dreamers and doers.</p>
                        </div>
                        
                        <div class="org-card creative-card">
                            <h3>Venom Publication</h3>
                            <p>Where words and creativity come alive in every post and article.</p>
                        </div>
                    </div>
                </div>
                <p class="cta">Ready to create, innovate, and lead? The College of Computing Studies is your gateway to endless possibilities!</p>
                <a href="events.php" class="btn btn-primary btn-lg mt-3">Discover Our Events</a>
            </div>
        </div>
    </main>

    <footer class="text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 Event Management System. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>