<?php
// Determine current page for menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="dashboard-header">
    <div class="logo">BizlyHub</div>
    <div class="user-info">
        Welcome, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role); ?>)
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<nav class="main-nav">
    <button class="menu-toggle" id="menuToggle">☰</button>
    <ul class="nav-container" id="mainMenu">
        <!-- <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
        </li> -->
        <li class="nav-item">
            <a href="expenses.php" class="nav-link <?php echo ($current_page == 'expenses.php') ? 'active' : ''; ?>">Expenses</a>
        </li>
        <li class="nav-item">
            <a href="pricing.php" class="nav-link <?php echo ($current_page == 'pricing.php') ? 'active' : ''; ?>">Pricing</a>
        </li>
        <li class="nav-item">
            <a href="subscribers.php" class="nav-link <?php echo ($current_page == 'subscribers.php') ? 'active' : ''; ?>">Subscribers</a>
        </li>
    </ul>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.getElementById('mainMenu').classList.toggle('show');
    });
</script>   