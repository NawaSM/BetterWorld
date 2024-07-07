<header>
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="org-home.php">BetterWorld Org</a>
            </div>
            <button class="hamburger" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="nav-links">
                <ul class="menu">
                    <li><a href="org-home.php">Home</a></li>
                    <li><a href="create-opportunity.php">Create Opportunity</a></li>
                    <li><a href="manage-opportunities.php">Manage Opportunities</a></li>
                    <li><a href="manage-applications.php">Manage Applications</a></li>
                    <li><a href="org-profile.php">Organization Profile</a></li>
                    <?php if (isset($_SESSION['org_id'])): ?>
                        <li><a href="org-logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="org-login.php">Login</a></li>
                        <li><a href="org-register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>