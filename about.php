<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About CCS - Ocesion Event Management System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .highlight {
            color: green;
            font-weight: bold;
        }
        .program-card {
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .program-card:hover {
            transform: translateY(-5px);
        }
        .program-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        .cs-card { background: linear-gradient(145deg, #f8f9fa, #e9ecef); }
        .it-card { background: linear-gradient(145deg, #f8f9fa, #e9ecef); }
        .act-card { background: linear-gradient(145deg, #f8f9fa, #e9ecef); }
        .vision-mission {
            background-color: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <!-- Include your existing header/navigation here -->
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
            <div class="text-center mb-5">
                <h1 class="display-4">About <span class="highlight">CCS</span></h1>
                <p class="lead">Shaping the Future of Technology Education</p>
            </div>

            <div class="vision-mission">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Our Vision</h2>
                        <p>By 2040, WMSU is a smart research university generating competent professionals and global citizens engendered by knowledge from the sciences and liberal education, empowering communities, promoting peace, harmony & cultural diversity.</p>
                    </div>
                    <div class="col-md-6">
                        <h2>Our Mission</h2>
                        <p>WMSU commits to create a vibrant atmosphere of learning where science, technology, innovation, research, the arts & humanities, and community engagement flourish and produce world class professionals committed to sustainable development & peace.</p>
                    </div>
                </div>
            </div>

            <h2 class="text-center mb-4">Our Academic Programs</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="program-card cs-card text-center">
                        <div class="program-icon"></div>
                        <h3 class="highlight">BS in Computer Science</h3>
                        <p>Dive deep into the theoretical foundations of computing, algorithms, and software development. Our CS program prepares you for:</p>
                        <ul class="list-unstyled">
                            <li>Software Development</li>
                            <li>Artificial Intelligence</li>
                            <li>Machine Learning</li>
                            <li>Algorithm Design</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="program-card it-card text-center">
                        <div class="program-icon"></div>
                        <h3 class="highlight">BS in Information Technology</h3>
                        <p>Master the practical applications of technology in business and industry. Focus areas include:</p>
                        <ul class="list-unstyled">
                            <li>Web Development</li>
                            <li>Network Administration</li>
                            <li>Database Management</li>
                            <li>Systems Integration</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="program-card act-card text-center">
                        <div class="program-icon"></div>
                        <h3 class="highlight">Associate in Computer Technology</h3>
                        <p>Get hands-on training in computer systems and applications. Perfect for:</p>
                        <ul class="list-unstyled">
                            <li>Technical Support</li>
                            <li>Computer Maintenance</li>
                            <li>Basic Programming</li>
                            <li>Office Applications</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <h2>Why Choose CCS?</h2>
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="feature-item">
                            <h3></h3>
                            <h4>Excellence</h4>
                            <p>Award-winning faculty and programs</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-item">
                            <h3></h3>
                            <h4>Hands-on</h4>
                            <p>Modern laboratories and equipment</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-item">
                            <h3></h3>
                            <h4>Industry Links</h4>
                            <p>Strong partnerships with tech companies</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-item">
                            <h3></h3>
                            <h4>Global</h4>
                            <p>International opportunities and exposure</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="cta">Ready to start your journey in technology? Join us at CCS!</p>
                <a href="events.php" class="btn btn-primary btn-lg mt-3">Explore Our Events</a>
            </div>
        </div>
    </main>

    <!-- Include your existing footer here -->
    <footer class="text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 Event Management System. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 