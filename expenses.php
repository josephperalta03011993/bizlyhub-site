<?php
    include_once('php/conn.php');
    include_once('php/expenses.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Expenses</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/expenses.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
</head>
<body>
<header class="dashboard-header">
        <div class="logo">BizlyHub</div>
        <div class="user-info">
            <span class="welcome-info">Welcome, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role); ?>)</span>
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
        <h1>Expense Management</h1>

        <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <div class="dashboard-widgets">
            <div class="widget">
                <h3>Expense Overview</h3>
                <div class="analytics-container">
                    <div class="analytics-card">
                        <div class="analytics-title">Today's Expenses</div>
                        <div class="analytics-value">₱<?php echo number_format($total_today, 2); ?></div>
                    </div>
                    <div class="analytics-card">
                        <div class="analytics-title">This Week's Expenses</div>
                        <div class="analytics-value">₱<?php echo number_format($total_week, 2); ?></div>
                    </div>
                    <div class="analytics-card">
                        <div class="analytics-title">This Month's Expenses</div>
                        <div class="analytics-value">₱<?php echo number_format($total_month, 2); ?></div>
                    </div>
                </div>
            </div>

            <div class="expense-form-container">
                <h3 class="form-title"><i class="fas fa-wallet"></i> Add New Expense</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="amount" class="form-label"><i class="fas fa-money-bill"></i> Amount (₱) <span class="required">*</span></label>
                            <input type="number" step="0.01" min="0.01" id="amount" name="amount" class="form-control" required placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <label for="expense_date" class="form-label"><i class="fas fa-calendar-days"></i> Date <span class="required">*</span></label>
                            <input type="date" id="expense_date" name="expense_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category_id" class="form-label"><i class="fas fa-list-ul"></i> Category <span class="required">*</span></label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="" disabled selected>Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_method_id" class="form-label"><i class="fas fa-credit-card"></i> Payment Method <span class="required">*</span></label>
                            <select id="payment_method_id" name="payment_method_id" class="form-control" required>
                                <option value="" disabled selected>Select payment method</option>
                                <?php foreach ($payment_methods as $method): ?>
                                <option value="<?php echo $method['id']; ?>"><?php echo htmlspecialchars($method['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes" class="form-label"><i class="fas fa-note-sticky"></i> Notes</label>
                        <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Enter notes (optional)"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="add_expense" class="submit-btn"><i class="fas fa-plus"></i> Add Expense</button>
                    </div>
                </form>
            </div>

            <div class="widget">
                <h3>Recent Expenses (Total: <?php echo $total_records; ?>)</h3>
                
                <div class="table-actions">
                    <div class="date-filters">
                        <form action="" method="get" id="filterForm">
                            <label for="from">From:</label>
                            <input type="date" id="from" name="from" value="<?php echo htmlspecialchars($from_date); ?>">
                            <label for="to">To:</label>
                            <input type="date" id="to" name="to" value="<?php echo htmlspecialchars($to_date); ?>">
                            <br><br>
                            <button type="submit" name="filter" class="filter-btn">Filter</button>
                            <button type="submit" name="export" value="csv" class="export-btn">Export to CSV</button>
                        </form>
                    </div>
                    <div class="search">
                        <input type="text" id="expenseSearch" class="search-box" placeholder="Search expenses...">
                    </div>
                </div>

                <?php if (count($recent_expenses) > 0): ?>
                <table class="expenses-table" id="expensesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row_number = $offset + 1; ?>
                        <?php foreach ($recent_expenses as $expense): ?>
                        <tr>
                            <td><?php echo $row_number++ . '.'; ?></td>
                            <td><?php echo $expense['id']; ?></td>
                            <td>₱<?php echo number_format($expense['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($expense['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($expense['payment_method']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($expense['expense_date'])); ?></td>
                            <td><?php echo htmlspecialchars($expense['notes']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>&from=<?php echo urlencode($from_date); ?>&to=<?php echo urlencode($to_date); ?>&filter=1">Previous</a>
                    <?php else: ?>
                    <a href="#" class="disabled">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&from=<?php echo urlencode($from_date); ?>&to=<?php echo urlencode($to_date); ?>&filter=1" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>&from=<?php echo urlencode($from_date); ?>&to=<?php echo urlencode($to_date); ?>&filter=1">Next</a>
                    <?php else: ?>
                    <a href="#" class="disabled">Next</a>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="no-data">
                    <p>No expenses recorded for the selected date range. Adjust the dates or add a new expense.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="dashboard-footer">
        <p>© <?php echo date('Y'); ?> BizlyHub. All rights reserved.</p>
    </footer>

    <script>
        // Toggle mobile menu
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('mainMenu').classList.toggle('show');
        });
        
        // Search functionality for the expenses table
        document.getElementById('expenseSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const table = document.getElementById('expensesTable');
            if (!table) return;
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                let found = false;
                const cells = rows[i].getElementsByTagName('td');
                
                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent.toLowerCase();
                    
                    if (cellText.includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        });
    </script>
</body>
</html>