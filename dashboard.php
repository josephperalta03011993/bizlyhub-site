<?php
include('php/conn.php');

// Get subscriber data
$subscribers = [];
$sql = "SELECT id, email, subscribe_date FROM subscriber_email ORDER BY subscribe_date DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subscribers[] = $row;
    }
}

// Close connection
$conn->close();

// Handle CSV export
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="subscribers-' . date('Y-m-d') . '.csv"');
    
    // Open output stream
    $output = fopen('php://output', 'w');
    
    // Add CSV headers
    fputcsv($output, ['ID', 'Email', 'Subscribe Date']);
    
    // Add data
    foreach ($subscribers as $subscriber) {
        fputcsv($output, $subscriber);
    }
    
    // Close the output stream
    fclose($output);
    exit;
}

// Determine current page for menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Dashboard</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/dashboard.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
</head>
<body>
    <header class="dashboard-header">
        <div class="logo">BizlyHub</div>
        <div class="user-info">
            Welcome, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role); ?>)
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </header>
    
    <!-- New Navigation Menu -->
    <nav class="main-nav">
        <button class="menu-toggle" id="menuToggle">☰</button>
        <ul class="nav-container" id="mainMenu">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="expenses.php" class="nav-link <?php echo ($current_page == 'expenses.php') ? 'active' : ''; ?>">Expenses</a>
            </li>
            <!-- Additional menu items can be added here -->
        </ul>
    </nav>
    
    <main class="dashboard-content">
        <h1>BizlyHub Dashboard</h1>
        
        <div class="dashboard-widgets">
            <div class="widget">
                <h3>Email Subscribers</h3>
                
                <div class="subscriber-count">
                    Total Subscribers: <?php echo count($subscribers); ?>
                </div>
                
                <div class="table-actions">
                    <input type="text" id="searchSubscribers" class="search-box" placeholder="Search emails..." onkeyup="searchTable()">
                    <a href="?export=csv" class="export-btn">Export to CSV</a>
                </div>
                
                <div class="table-container">
                    <table class="subscriber-table" id="subscriberTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Subscribe Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($subscribers) > 0): ?>
                                <?php foreach ($subscribers as $subscriber): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subscriber['id']); ?></td>
                                        <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                        <td><?php echo htmlspecialchars($subscriber['subscribe_date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="no-data">No subscribers found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="dashboard-footer">
        <p>&copy; 2025 BizlyHub. All rights reserved.</p>
    </footer>
    
    <script>
        // Table search functionality
        function searchTable() {
            // Get input value and convert to lowercase
            const input = document.getElementById('searchSubscribers');
            const filter = input.value.toLowerCase();
            
            // Get table and rows
            const table = document.getElementById('subscriberTable');
            const rows = table.getElementsByTagName('tr');
            
            // Loop through rows, hiding those that don't match the search query
            for (let i = 1; i < rows.length; i++) { // Start at 1 to skip header row
                const emailCell = rows[i].getElementsByTagName('td')[1]; // Email is in the second column
                
                if (emailCell) {
                    const emailText = emailCell.textContent || emailCell.innerText;
                    
                    if (emailText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
        
        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('mainMenu').classList.toggle('show');
        });
    </script>
</body>
</html>