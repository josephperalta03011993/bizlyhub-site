<?php 
    include_once('php/conn.php');
    
    // Initialize variables
    $message = '';
    $messageType = '';
    $recent_expenses = [];
    $total_today = 0.00;
    $total_week = 0.00;
    $total_month = 0.00;
    $total_quarter = 0.00;
    $total_year = 0.00;
    $categories = [];
    $payment_methods = [];

    // Redirect if not logged in
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }
    $username = $_SESSION['username'];
    $role = $_SESSION['role'] ?? 'user';

    // Determine current page
    $current_page = basename($_SERVER['PHP_SELF']);

    // Pagination settings
    $records_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $records_per_page;

    // Date filter settings
    $from_date = isset($_GET['from']) ? $_GET['from'] : date('Y-m-d');
    $to_date = isset($_GET['to']) ? $_GET['to'] : date('Y-m-d');
    $apply_filter = isset($_GET['filter']);

    // Fetch categories
    $sql = "SELECT id, name FROM expense_categories ORDER BY name";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    // Fetch payment methods
    $sql = "SELECT id, name FROM payment_methods ORDER BY name";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $payment_methods[] = $row;
        }
    }

    // Handle form submission (Add Expense)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_expense'])) {
        $amount = floatval($_POST['amount']);
        $category_id = intval($_POST['category_id']);
        $payment_method_id = intval($_POST['payment_method_id']);
        $expense_date = $_POST['expense_date'];
        $notes = trim($_POST['notes']);
        $created_by = $username;

        // Validate inputs
        if ($amount <= 0 || $category_id <= 0 || $payment_method_id <= 0 || empty($expense_date)) {
            $message = "All required fields must be filled correctly.";
            $messageType = "error";
        } else {
            try {
                $sql = "INSERT INTO expenses (amount, category_id, payment_method_id, notes, expense_date, created_by) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("diisss", $amount, $category_id, $payment_method_id, $notes, $expense_date, $created_by);
                if ($stmt->execute()) {
                    $message = "Expense added successfully!";
                    $messageType = "success";
                } else {
                    throw new Exception("Database error: " . $conn->error);
                }
                $stmt->close();
            } catch (Exception $e) {
                $message = "Error adding expense: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }

    // Handle edit expense
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_expense'])) {
        $expense_id = intval($_POST['expense_id']);
        $amount = floatval($_POST['amount']);
        $category_id = intval($_POST['category_id']);
        $payment_method_id = intval($_POST['payment_method_id']);
        $expense_date = $_POST['expense_date'];
        $notes = trim($_POST['notes']);

        // Validate inputs
        if ($expense_id <= 0 || $amount <= 0 || $category_id <= 0 || $payment_method_id <= 0 || empty($expense_date)) {
            $message = "All required fields must be filled correctly.";
            $messageType = "error";
        } else {
            try {
                $sql = "UPDATE expenses SET amount = ?, category_id = ?, payment_method_id = ?, notes = ?, expense_date = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("diissi", $amount, $category_id, $payment_method_id, $notes, $expense_date, $expense_id);
                if ($stmt->execute()) {
                    $message = "Expense updated successfully!";
                    $messageType = "success";
                } else {
                    throw new Exception("Database error: " . $conn->error);
                }
                $stmt->close();
            } catch (Exception $e) {
                $message = "Error updating expense: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }

    // Handle delete expense
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_expense'])) {
        $expense_id = isset($_POST['expense_id']) ? intval($_POST['expense_id']) : 0;
        error_log('Delete expense_id: ' . $expense_id); // Log to error log
        if ($expense_id <= 0) {
            $message = "Invalid expense ID.";
            $messageType = "error";
        } else {
            try {
                $sql = "DELETE FROM expenses WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $expense_id);
                if ($stmt->execute()) {
                    $message = "Expense deleted successfully!";
                    $messageType = "success";
                } else {
                    throw new Exception("Database error: " . $conn->error);
                }
                $stmt->close();
            } catch (Exception $e) {
                $message = "Error deleting expense: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }

    // Fetch analytics data
    try {
        // Today's expenses
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE DATE(expense_date) = CURDATE()";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $total_today = floatval($row['total'] ?? 0.00);
        }

        // This week's expenses
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE YEARWEEK(expense_date) = YEARWEEK(CURDATE())";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $total_week = floatval($row['total'] ?? 0.00);
        }

        // This month's expenses
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE YEAR(expense_date) = YEAR(CURDATE()) AND MONTH(expense_date) = MONTH(CURDATE())";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $total_month = floatval($row['total'] ?? 0.00);
        }

        // This quarter's expenses
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE QUARTER(expense_date) = QUARTER(CURDATE()) AND YEAR(expense_date) = YEAR(CURDATE())";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $total_quarter = floatval($row['total'] ?? 0.00);
        }

        // This year's expenses
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE YEAR(expense_date) = YEAR(CURDATE())";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $total_year = floatval($row['total'] ?? 0.00);
        }

        // Count total expenses for pagination (based on filter)
        $sql = "SELECT COUNT(*) as total FROM expenses";
        if ($apply_filter) {
            $sql .= " WHERE expense_date BETWEEN ? AND ?";
        } else {
            $sql .= " WHERE DATE(expense_date) = CURDATE()";
        }
        $stmt = $conn->prepare($sql);
        if ($apply_filter) {
            $stmt->bind_param("ss", $from_date, $to_date);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $total_records = $result->fetch_assoc()['total'];
        $total_pages = ceil($total_records / $records_per_page);
        $stmt->close();

        // Fetch recent expenses with pagination (filtered by date)
        $sql = "SELECT e.id, e.amount, e.expense_date, e.notes, ec.id as category_id, ec.name as category_name, pm.id as payment_method_id, pm.name as payment_method
                FROM expenses e
                JOIN expense_categories ec ON e.category_id = ec.id
                JOIN payment_methods pm ON e.payment_method_id = pm.id";
        if ($apply_filter) {
            $sql .= " WHERE e.expense_date BETWEEN ? AND ?";
        } else {
            $sql .= " WHERE DATE(e.expense_date) = CURDATE()";
        }
        $sql .= " ORDER BY e.expense_date DESC LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        if ($apply_filter) {
            $stmt->bind_param("ssii", $from_date, $to_date, $records_per_page, $offset);
        } else {
            $stmt->bind_param("ii", $records_per_page, $offset);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $recent_expenses[] = $row;
            }
        }
        $stmt->close();
    } catch (Exception $e) {
        $message = "Error fetching data: " . $e->getMessage();
        $messageType = "error";
    }

    // Handle CSV export (export filtered results)
    if (isset($_GET['export']) && $_GET['export'] == 'csv') {
        $from_date = date('Y-m-d', strtotime($_GET['from'] ?? date('Y-m-d')));
        $to_date = date('Y-m-d', strtotime($_GET['to'] ?? date('Y-m-d')));
        if (strtotime($from_date) > strtotime($to_date)) {
            $from_date = date('Y-m-01');
            $to_date = date('Y-m-t');
        }

        try {
            $sql = "SELECT e.id, e.amount, ec.name as category_name, pm.name as payment_method, e.expense_date, e.notes
                    FROM expenses e
                    JOIN expense_categories ec ON e.category_id = ec.id
                    JOIN payment_methods pm ON e.payment_method_id = pm.id
                    WHERE e.expense_date BETWEEN ? AND ?
                    ORDER BY e.expense_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $from_date, $to_date);
            $stmt->execute();
            $result = $stmt->get_result();

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="expenses-' . date('Y-m-d') . '.csv"');
            
            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID', 'Amount', 'Category', 'Payment Method', 'Date', 'Notes']);
            
            while ($row = $result->fetch_assoc()) {
                fputcsv($output, [
                    $row['id'],
                    $row['amount'],
                    $row['category_name'],
                    $row['payment_method'],
                    $row['expense_date'],
                    $row['notes']
                ]);
            }
            
            fclose($output);
            $stmt->close();
            exit;
        } catch (Exception $e) {
            $message = "Error exporting CSV: " . $e->getMessage();
            $messageType = "error";
        }
    }

    // Fetch expenses by category for the pie chart
    $current_month_start = date('Y-m-01');
    $current_month_end = date('Y-m-t');
    $sql_pie = "SELECT c.name, SUM(e.amount) as total
                FROM expenses e
                JOIN expense_categories c ON e.category_id = c.id
                WHERE e.expense_date BETWEEN '$current_month_start' AND '$current_month_end'
                GROUP BY c.id, c.name";
    $result_pie = $conn->query($sql_pie);
    $pie_data = [];
    $pie_labels = [];
    $pie_colors = ['#3a86ff', '#ff6b6b', '#28a745', '#feca57', '#8338ec', '#06d6a0', '#ff006e'];
    $color_index = 0;

    if ($result_pie && $result_pie->num_rows > 0) {
        while ($row = $result_pie->fetch_assoc()) {
            $pie_labels[] = $row['name'];
            $pie_data[] = $row['total'];
            $pie_colors[$color_index] = isset($pie_colors[$color_index]) ? $pie_colors[$color_index] : '#'.substr(md5(rand()), 0, 6);
            $color_index++;
        }
    }

    // Fetch projected expenses (average of last 3 months)
    $projected_expenses = 0;
    $sql_projected = "SELECT AVG(monthly_total) as avg_expenses
                    FROM (
                        SELECT SUM(amount) as monthly_total
                        FROM expenses
                        WHERE expense_date >= DATE_SUB('$current_month_start', INTERVAL 3 MONTH)
                        AND expense_date < '$current_month_start'
                        GROUP BY YEAR(expense_date), MONTH(expense_date)
                    ) as monthly_totals";
    $result_projected = $conn->query($sql_projected);
    if ($result_projected && $result_projected->num_rows > 0) {
        $row = $result_projected->fetch_assoc();
        $projected_expenses = round($row['avg_expenses'], 2);
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Expenses</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/expenses.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
</head>
<body>
    <?php include('layouts/header.php'); ?>

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
                    <div class="analytics-card">
                        <div class="analytics-title">This Quarter's Expenses</div>
                        <div class="analytics-value">₱<?php echo number_format($total_quarter, 2); ?></div>
                    </div>
                    <div class="analytics-card">
                        <div class="analytics-title">This Year's Expenses</div>
                        <div class="analytics-value">₱<?php echo number_format($total_year, 2); ?></div>
                    </div>
                    <div class="analytics-card">
                        <div class="analytics-title">Projected Next Month</div>
                        <div class="analytics-value">₱<?php echo number_format($projected_expenses, 2); ?></div>
                    </div>
                </div>
                <div class="chart-container">
                    <h3>Expenses by Category (This Month)</h3>
                    <canvas id="expensePieChart"></canvas>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row_number = $offset + 1; ?>
                        <?php foreach ($recent_expenses as $expense): ?>
                        <tr data-expense-id="<?php echo $expense['id']; ?>">
                            <td><?php echo $row_number++ . '.'; ?></td>
                            <td><?php echo $expense['id']; ?></td>
                            <td>₱<?php echo number_format($expense['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($expense['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($expense['payment_method']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($expense['expense_date'])); ?></td>
                            <td><?php echo htmlspecialchars($expense['notes']); ?></td>
                            <td>
                                <button class="edit-btn" data-expense='<?php echo json_encode($expense); ?>'><i class="fas fa-edit"></i> Edit</button>
                                <button class="delete-btn" data-expense-id="<?php echo $expense['id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                                <script>console.log('Expense ID: <?php echo $expense['id']; ?>');</script>
                            </td>
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

        <!-- Edit Expense Modal -->
        <div id="editExpenseModal" class="modal">
            <div class="modal-content">
                <span class="modal-close">×</span>
                <h3>Edit Expense</h3>
                <form id="editExpenseForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" id="edit_expense_id" name="expense_id">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit_amount" class="form-label"><i class="fas fa-money-bill"></i> Amount (₱) <span class="required">*</span></label>
                            <input type="number" step="0.01" min="0.01" id="edit_amount" name="amount" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_expense_date" class="form-label"><i class="fas fa-calendar-days"></i> Date <span class="required">*</span></label>
                            <input type="date" id="edit_expense_date" name="expense_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit_category_id" class="form-label"><i class="fas fa-list-ul"></i> Category <span class="required">*</span></label>
                            <select id="edit_category_id" name="category_id" class="form-control" required>
                                <option value="" disabled>Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_payment_method_id" class="form-label"><i class="fas fa-credit-card"></i> Payment Method <span class="required">*</span></label>
                            <select id="edit_payment_method_id" name="payment_method_id" class="form-control" required>
                                <option value="" disabled>Select payment method</option>
                                <?php foreach ($payment_methods as $method): ?>
                                <option value="<?php echo $method['id']; ?>"><?php echo htmlspecialchars($method['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_notes" class="form-label"><i class="fas fa-note-sticky"></i> Notes</label>
                        <textarea id="edit_notes" name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="modal-actions">
                        <button type="submit" name="edit_expense" class="submit-btn">Update Expense</button>
                        <button type="button" class="cancel-btn modal-close">X</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteExpenseModal" class="modal">
            <div class="modal-content">
                <span class="modal-close">×</span>
                <h3>Confirm Deletion</h3>
                <p>Are you sure you want to delete this expense? This action cannot be undone.</p>
                <form id="deleteExpenseForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" id="delete_expense_id" name="expense_id">
                    <div class="modal-actions">
                        <button type="submit" name="delete_expense" class="delete-btn">Delete</button>
                        <button type="button" class="cancel-btn modal-close">X</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="dashboard-footer">
        <p>© <?php echo date('Y'); ?> BizlyHub. All rights reserved.</p>
    </footer>

    <script>
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

        // Pie chart for expenses by category
        if (document.getElementById('expensePieChart')) {
            const pieCtx = document.getElementById('expensePieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($pie_labels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($pie_data); ?>,
                        backgroundColor: <?php echo json_encode($pie_colors); ?>,
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Poppins',
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ₱';
                                    }
                                    label += Number(context.raw).toFixed(2);
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Modal functionality
        const editModal = document.getElementById('editExpenseModal');
        const deleteModal = document.getElementById('deleteExpenseModal');
        const editButtons = document.querySelectorAll('.edit-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const closeButtons = document.querySelectorAll('.modal-close');

        // Open edit modal and populate fields
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const expense = JSON.parse(button.getAttribute('data-expense'));
                document.getElementById('edit_expense_id').value = expense.id;
                document.getElementById('edit_amount').value = expense.amount;
                document.getElementById('edit_expense_date').value = expense.expense_date;
                document.getElementById('edit_category_id').value = expense.category_id;
                document.getElementById('edit_payment_method_id').value = expense.payment_method_id;
                document.getElementById('edit_notes').value = expense.notes || '';
                editModal.style.display = 'block';
            });
        });

        // Open delete confirmation modal
        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const expenseId = button.getAttribute('data-expense-id');
                if (!expenseId || isNaN(expenseId) || parseInt(expenseId) <= 0) {
                    console.error('Invalid expense ID:', expenseId);
                    return;
                }
                document.getElementById('delete_expense_id').value = expenseId;
                console.log('Set delete_expense_id to:', expenseId);
                deleteModal.style.display = 'block';
            });
        });

        // Close modals
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                editModal.style.display = 'none';
                deleteModal.style.display = 'none';
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
            if (event.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>