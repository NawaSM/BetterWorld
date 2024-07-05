<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BetterWorld</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="navbar">
                <div class="logo">
                    <a href="index.html">BetterWorld</a>
                </div>
                <div class="nav-links">
                    <input type="checkbox" id="checkbox_toggle" />
                    <label for="checkbox_toggle" class="hamburger">&#9776;</label>
                    <ul class="menu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="opportunities.php">Volunteer Opportunities</a></li>
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="contact.html">Contact</a></li>
                        <li><a href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Connect with Purpose</h1>
                <p>Find meaningful volunteer opportunities and make a difference in your community.</p>
                <a href="opportunities.html" class="cta-button">Get Started</a>
            </div>
            <div class="hero-image">
                <img src="1.jpg" alt="Volunteers working together">
            </div>
        </section>

        <section class="featured-opportunities">
            <h2>Featured Opportunities</h2>
            <div class="opportunity-slider">
                <div class="opportunity-card">
                    <img src="opportunity1.jpg" alt="Opportunity 1">
                    <div class="opportunity-card-content">
                        <h3>Beach Cleanup</h3>
                        <p>Help clean up our local beaches and protect marine life.</p>
                        <a href="opportunity-details.html" class="btn">Learn More</a>
                    </div>
                </div>
                <div class="opportunity-card">
                    <img src="opportunity2.jpg" alt="Opportunity 2">
                    <div class="opportunity-card-content">
                        <h3>Community Garden</h3>
                        <p>Volunteer at our community garden and promote sustainable living.</p>
                        <a href="opportunity-details.html" class="btn">Learn More</a>
                    </div>
                </div>
                <div class="opportunity-card">
                    <img src="opportunity3.jpg" alt="Opportunity 3">
                    <div class="opportunity-card-content">
                        <h3>Tutoring Program</h3>
                        <p>Tutor underprivileged students and help them succeed academically.</p>
                        <a href="opportunity-details.html" class="btn">Learn More</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-it-works">
            <h2>How It Works</h2>
            <div class="step-container">
                <div class="step">
                    <img src="step1.png" alt="Step 1">
                    <h3>Create a Profile</h3>
                    <p>Sign up and create your volunteer profile.</p>
                </div>
                <div class="step">
                    <img src="step2.png" alt="Step 2">
                    <h3>Browse Opportunities</h3>
                    <p>Explore various volunteer opportunities in your area.</p>
                </div>
                <div class="step">
                    <img src="step3.png" alt="Step 3">
                    <h3>Apply and Contribute</h3>
                    <p>Apply for the opportunities you're interested in and start making a difference.</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>
</body>
</html>