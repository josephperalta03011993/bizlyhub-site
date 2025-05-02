<?php 
    // Initialize variables
    $message = '';
    $messageType = '';
    $recent_expenses = [];
    $total_today = 0.00;
    $total_week = 0.00;
    $total_month = 0.00;
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

    // Handle form submission
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
        $sql = "SELECT e.id, e.amount, e.expense_date, e.notes, ec.name as category_name, pm.name as payment_method
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

    $conn->close();
?>