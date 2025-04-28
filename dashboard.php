<?php
// Start or resume session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php?error=Please login to access the dashboard");
    exit();
}

// Get user information from session
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Database connection
// $servername = "localhost";
// $password = '8d$Z[1Dm';
// $dbname = "u414060592_landing";
// $username = "u414060592_landing";

$servername = "localhost";
$db_username = "root"; 
$password = ""; 
$dbname = "bizlyhub"; 

// Create connection
$conn = new mysqli($servername, $db_username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <style>
        /* Additional styling for subscriber table */
        .subscriber-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .subscriber-table th, 
        .subscriber-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .subscriber-table th {
            background-color: #f9f9f9;
            font-weight: 600;
            color: #333;
        }
        
        .subscriber-table tr:last-child td {
            border-bottom: none;
        }
        
        .subscriber-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .dashboard-widgets {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        
        .widget {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .widget h3 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .export-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        
        .search-box {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }
        
        .subscriber-count {
            background-color: #e9f7fe;
            color: #3498db;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        
        /* Mobile responsiveness */
        @media screen and (max-width: 768px) {
            .subscriber-table {
                display: block;
                overflow-x: auto;
            }
            
            .subscriber-table thead, 
            .subscriber-table tbody, 
            .subscriber-table th, 
            .subscriber-table td, 
            .subscriber-table tr {
                display: block;
            }
            
            .subscriber-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            
            .subscriber-table tr {
                border: 1px solid #ccc;
                margin-bottom: 15px;
                border-radius: 6px;
                overflow: hidden;
            }
            
            .subscriber-table td {
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%;
                text-align: right;
            }
            
            .subscriber-table td:before {
                position: absolute;
                top: 12px;
                left: 12px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                font-weight: 600;
                text-align: left;
            }
            
            .subscriber-table td:nth-of-type(1):before { content: "ID"; }
            .subscriber-table td:nth-of-type(2):before { content: "Email"; }
            .subscriber-table td:nth-of-type(3):before { content: "Subscribe Date"; }
            
            .table-actions {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
            }
        }
    </style>
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
    </script>
</body>
</html>