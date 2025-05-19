<?php
include('php/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bill Reminder - Manage Monthly Bills</title>
    <meta name="description" content="Manage your monthly bills and set email reminders for due dates.">
    <meta name="keywords" content="bill reminder, monthly bills, email notifications">
    <meta name="author" content="Bill Reminder App">
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/bills.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
</head>
<body>
    <?php include('layouts/header.php'); ?>

    <main class="dashboard-content">
        <section aria-labelledby="bill-reminder-title">
            <h1 id="bill-reminder-title">Bill Reminder</h1>
            <div class="contact-form">
                <form id="billForm" aria-label="Add new bill form">
                    <div class="form-group">
                        <input type="text" id="billName" name="billName" placeholder=" " required aria-required="true">
                        <label for="billName">Bill Name (e.g., Internet)</label>
                    </div>
                    <div class="form-group">
                        <input type="number" id="dueDate" name="dueDate" placeholder=" " min="1" max="31" required aria-required="true">
                        <label for="dueDate">Due Date (Day of Month, 1-31)</label>
                    </div>
                    <div class="form-group">
                        <input type="number" id="notifyDay" name="notifyDay" placeholder=" " min="1" max="31" required aria-required="true">
                        <label for="notifyDay">Notify Me On (Day of Month, 1-31)</label>
                    </div>
                    <div class="form-group email-group">
                        <input type="text" id="emails" name="emails" placeholder=" " required aria-required="true">
                        <label for="emails">Notification Emails (comma or space separated)</label>
                        <div class="email-tags" id="emailTags"></div>
                    </div>
                    <button type="submit" class="submit-button">Add Bill</button>
                </form>
            </div>
        </section>

        <section aria-labelledby="bills-list-title">
            <h2 id="bills-list-title">Your Bills</h2>
            <div class="table-container">
                <table class="bills-table" id="billsTable">
                    <thead>
                        <tr>
                            <th>Bill Name</th>
                            <th>Due Date</th>
                            <th>Notify On</th>
                            <th>Notification Emails</th>
                            <th>Notifications</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="billsTableBody"></tbody>
                </table>
            </div>
        </section>

        <div class="alert-container" id="alertContainer"></div>
    </main>

    <footer class="dashboard-footer">
        <p>© <?php echo date('Y'); ?> Bill Reminder. All rights reserved.</p>
    </footer>

    <script>
        // Show alert
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert ${type} show`;
            alert.innerHTML = `
                <span class="icon"></span>
                <span class="message">${message}</span>
            `;
            alertContainer.appendChild(alert);
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }, 3000);
        }

        // Handle email tags
        function updateEmailTags() {
            const emailInput = document.getElementById('emails');
            const emailTags = document.getElementById('emailTags');
            const emails = emailInput.value.split(/[, ]+/).filter(email => email.trim());
            emailTags.innerHTML = '';
            emails.forEach(email => {
                if (email) {
                    const tag = document.createElement('span');
                    tag.className = 'email-tag';
                    tag.textContent = email;
                    const removeBtn = document.createElement('span');
                    removeBtn.className = 'remove-tag';
                    removeBtn.textContent = '×';
                    removeBtn.onclick = () => {
                        emailInput.value = emails.filter(e => e !== email).join(', ');
                        updateEmailTags();
                    };
                    tag.appendChild(removeBtn);
                    emailTags.appendChild(tag);
                }
            });
        }

        document.getElementById('emails').addEventListener('input', updateEmailTags);
        document.getElementById('emails').addEventListener('blur', () => {
            updateEmailTags();
            const emailInput = document.getElementById('emails');
            emailInput.value = emailInput.value.split(/[, ]+/).filter(email => email.trim()).join(', ');
        });

        // Fetch and render bills
        function fetchBills() {
            fetch('php/get_bills.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched bills:', data);
                    const tbody = document.getElementById('billsTableBody');
                    tbody.innerHTML = '';
                    data.forEach(bill => {
                        // Handle notifications as boolean (0/1, "0"/"1", true/false)
                        const isNotificationsOn = bill.notifications === true || bill.notifications === 1 || bill.notifications === "1";
                        console.log(`Bill ${bill.id}: notifications=${bill.notifications} (type: ${typeof bill.notifications}), isNotificationsOn=${isNotificationsOn}`);
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${bill.name}</td>
                            <td>Day ${bill.due_date}</td>
                            <td>Day ${bill.notify_day}</td>
                            <td>${bill.emails}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" ${isNotificationsOn ? 'checked' : ''} 
                                        onchange="toggleNotifications('${bill.id}')">
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                <button class="cta-button" onclick="editBill('${bill.id}')">Edit</button>
                                <button class="cta-button danger" onclick="deleteBill('${bill.id}')">Delete</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => {
                    showAlert('Error loading bills.', 'error');
                    console.error('Fetch bills error:', error);
                });
        }

        // Handle form submission
        document.getElementById('billForm').addEventListener('submit', e => {
            e.preventDefault();
            const form = e.target;
            const dueDate = parseInt(form.dueDate.value);
            const notifyDay = parseInt(form.notifyDay.value);
            const emails = form.emails.value.split(/[, ]+/).filter(email => email.trim());

            if (dueDate < 1 || dueDate > 31 || notifyDay < 1 || notifyDay > 31) {
                showAlert('Due date and notify day must be between 1 and 31.', 'error');
                return;
            }
            if (emails.length === 0 || !emails.every(email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))) {
                showAlert('Please enter at least one valid email address.', 'error');
                return;
            }

            const data = {
                id: form.dataset.editId || '',
                name: form.billName.value,
                due_date: dueDate,
                notify_day: notifyDay,
                emails: emails.join(', ')
            };

            fetch('php/save_bill.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers.get('Content-Type'));
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    console.log('Response JSON:', result);
                    if (result.success) {
                        showAlert(result.message, 'success');
                        form.reset();
                        document.getElementById('emailTags').innerHTML = '';
                        delete form.dataset.editId;
                        form.querySelector('button').textContent = 'Add Bill';
                        fetchBills();
                    } else {
                        showAlert(result.message, 'error');
                    }
                })
                .catch(error => {
                    showAlert('Error saving bill.', 'error');
                    console.error('Save bill error:', error);
                });
        });

        // Toggle notifications
        function toggleNotifications(id) {
            fetch('php/toggle_notification.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        showAlert(result.message, 'success');
                        fetchBills();
                    } else {
                        showAlert(result.message, 'error');
                    }
                })
                .catch(error => {
                    showAlert('Error toggling notifications.', 'error');
                    console.error('Toggle notifications error:', error);
                });
        }

        // Edit bill
        function editBill(id) {
            fetch(`php/get_bill.php?id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(bill => {
                    const form = document.getElementById('billForm');
                    form.billName.value = bill.name;
                    form.dueDate.value = bill.due_date;
                    form.notifyDay.value = bill.notify_day;
                    form.emails.value = bill.emails;
                    updateEmailTags();
                    form.dataset.editId = id;
                    form.querySelector('button').textContent = 'Update Bill';
                })
                .catch(error => {
                    showAlert('Error loading bill.', 'error');
                    console.error('Edit bill error:', error);
                });
        }

        // Delete bill
        function deleteBill(id) {
            if (confirm('Are you sure you want to delete this bill?')) {
                fetch('php/delete_bill.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(result => {
                        if (result.success) {
                            showAlert(result.message, 'success');
                            fetchBills();
                        } else {
                            showAlert(result.message, 'error');
                        }
                    })
                    .catch(error => {
                        showAlert('Error deleting bill.', 'error');
                        console.error('Delete bill error:', error);
                    });
            }
        }

        // Initial fetch
        fetchBills();
    </script>
</body>
</html>