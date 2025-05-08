<?php
include('php/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Pricing</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="styles/pricing.css">
</head>
<body>
    <?php include('layouts/header.php'); ?>

    <main class="dashboard-content">
        <h1>Website Design & Development</h1>

        <h2>Website Development Packages</h2>
        <table class="pricing-table development">
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Description</th>
                    <th>PH Price</th>
                    <th>Intl Price</th>
                    <th>Timeline</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Starter Website</td>
                    <td>3 pages (Home, About, Contact), responsive design.</td>
                    <td>₱5,000</td>
                    <td>$150</td>
                    <td>3 – 5 working days</td>
                </tr>
                <tr>
                    <td>Basic Business Site</td>
                    <td>5 pages, contact form, social links, mobile optimized.</td>
                    <td>₱8,000 – ₱10,000</td>
                    <td>$250 – $300</td>
                    <td>5 – 7 working days</td>
                </tr>
                <tr>
                    <td>Standard Website</td>
                    <td>7 pages with animations, gallery, maps, contact form.</td>
                    <td>₱12,000 – ₱15,000</td>
                    <td>$350 – $500</td>
                    <td>7 – 10 working days</td>
                </tr>
                <tr>
                    <td>E-Commerce Lite</td>
                    <td>5 products, cart, checkout, payment integration.</td>
                    <td>₱18,000 – ₱25,000</td>
                    <td>$500 – $800</td>
                    <td>10 – 15 working days</td>
                </tr>
                <tr>
                    <td>Premium Business Site</td>
                    <td>10 pages, blog, SEO, booking, newsletter integration.</td>
                    <td>₱30,000 – ₱40,000</td>
                    <td>$900 – $1,200</td>
                    <td>2 – 3 weeks</td>
                </tr>
                <tr>
                    <td>Enterprise Website</td>
                    <td>Full SaaS/dashboard with user logins, analytics, portals.</td>
                    <td>Starts at ₱60,000</td>
                    <td>Starts at $2,000</td>
                    <td>4 – 8 weeks (or more)</td>
                </tr>
                <tr>
                    <td>Landing Page</td>
                    <td>1-page promotional site, scrolling layout.</td>
                    <td>₱3,000 – ₱4,000</td>
                    <td>$80 – $120</td>
                    <td>2 – 3 working days</td>
                </tr>
            </tbody>
        </table>

        <h2>Website Maintenance Plans</h2>
        <table class="pricing-table maintenance">
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>PH Price/Month</th>
                    <th>Intl Price/Month</th>
                    <th>Inclusions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic</td>
                    <td>₱1,000</td>
                    <td>$25</td>
                    <td>Up to 2 content or image updates/month, Monthly website health check, Basic uptime monitoring</td>
                </tr>
                <tr>
                    <td>Standard</td>
                    <td>₱2,000</td>
                    <td>$40</td>
                    <td>Up to 4 content updates/month, CMS/plugin updates, Speed optimization, Weekly backups, Malware scan</td>
                </tr>
                <tr>
                    <td>Premium</td>
                    <td>₱3,500 – ₱5,000</td>
                    <td>$70 – $100</td>
                    <td>Unlimited small updates, Priority support, Security patching, Monthly reports, Daily/weekly backups</td>
                </tr>
                <tr>
                    <td>Enterprise</td>
                    <td>Starts at ₱8,000</td>
                    <td>Starts at $200</td>
                    <td>Custom SLA, Up to 10 dev hours/month, Full monitoring & analytics, Emergency bug fixing, Feature planning</td>
                </tr>
            </tbody>
        </table>

        <h2>Optional Add-On Services</h2>
        <table class="pricing-table add-ons">
            <thead>
                <tr>
                    <th>Add-on Service</th>
                    <th>PH Price</th>
                    <th>Intl Price</th>
                    <th>Est. Timeline</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Extra Web Page (per page)</td>
                    <td>₱500 – ₱800</td>
                    <td>$20 – $30</td>
                    <td>1 day per 1–2 pages</td>
                </tr>
                <tr>
                    <td>Domain & Hosting Setup</td>
                    <td>₱1,000 – ₱1,500</td>
                    <td>$30 – $50</td>
                    <td>1 day</td>
                </tr>
                <tr>
                    <td>Blog or Booking System</td>
                    <td>₱3,000 – ₱5,000</td>
                    <td>$80 – $150</td>
                    <td>1 – 2 days</td>
                </tr>
                <tr>
                    <td>SEO Setup (Basic)</td>
                    <td>₱2,000 – ₱4,000</td>
                    <td>$50 – $100</td>
                    <td>2 – 3 days</td>
                </tr>
                <tr>
                    <td>Google Analytics & FB Pixel</td>
                    <td>₱1,000</td>
                    <td>$25</td>
                    <td>1 day</td>
                </tr>
                <tr>
                    <td>Email Automation / CRM</td>
                    <td>₱3,000 – ₱7,000</td>
                    <td>$80 – $200</td>
                    <td>3 – 7 days</td>
                </tr>
                <tr>
                    <td>E-Commerce Expansion (10+ items)</td>
                    <td>Starts at ₱5,000</td>
                    <td>Starts at $150</td>
                    <td>2 – 5 days</td>
                </tr>
                <tr>
                    <td>Multilingual Support</td>
                    <td>₱3,000 – ₱6,000</td>
                    <td>$100 – $180</td>
                    <td>2 – 4 days</td>
                </tr>
            </tbody>
        </table>

        <h2>Payment Terms</h2>
        <div class="payment-terms">
            <ul>
                <li>50% down payment to begin development</li>
                <li>50% upon final delivery and client approval</li>
                <li>Maintenance plans are billed monthly or quarterly</li>
            </ul>
        </div>

        <h2>Contact Information</h2>
        <div class="contact-info">
            <p><strong>Name:</strong> [Your Name]</p>
            <p><strong>Business:</strong> BizlyHub</p>
            <p><strong>Email:</strong> [Your Email]</p>
            <p><strong>Phone:</strong> [Your Phone]</p>
            <p><strong>Portfolio/Website:</strong> [Insert Link]</p>
        </div>
    </main>

    <footer class="dashboard-footer">
        <p>© 2025 BizlyHub. All rights reserved.</p>
    </footer>
</body>
</html>