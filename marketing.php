<?php
include('php/conn.php');

// Dynamic promo end date
$promo_end_date = date('F j, Y', strtotime('last day of this month'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Marketing Strategy</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="styles/marketing.css">
</head>
<body>
    <?php include('layouts/header.php'); ?>

    <main class="dashboard-content">
        <h1>Monthly Marketing Strategy</h1>

        <h2>Overview</h2>
        <p>This monthly marketing strategy is designed to generate consistent cash flow for BizlyHub's SAAS solutions and website development services. It combines a high-level plan for business growth with a practical guide for marketing assistants to execute daily tasks. The strategy leverages a mix of organic and paid tactics within a budget of ₱5,000–₱20,000 ($100–$400).</p>

        <h2>Monthly Goals</h2>
        <ul class="goals-list">
            <li>Generate 10–20 qualified leads per month (e.g., inquiries for SAAS solutions or website development).</li>
            <li>Convert 20% of leads into clients (2–4 new projects/month).</li>
            <li>Upsell 1–2 existing clients to maintenance plans or add-on services.</li>
            <li>Increase website traffic by 15% and social media engagement by 20% monthly.</li>
            <li>Achieve a churn rate of less than 5% and increase MRR by 10% monthly.</li>
        </ul>

        <h2>Marketing Channels</h2>
        <table class="marketing-table channels">
            <thead>
                <tr>
                    <th>Channel</th>
                    <th>Strategy</th>
                    <th>Tools/Platforms</th>
                    <th>Frequency</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Content Marketing</td>
                    <td>Publish blog posts on SAAS benefits, website development tips, and industry-specific guides; optimize for SEO.</td>
                    <td>WordPress, Google Search Console</td>
                    <td>1–2 posts/month</td>
                </tr>
                <tr>
                    <td>Social Media</td>
                    <td>Post portfolio highlights, client testimonials, and SAAS tips; run targeted ads for SAAS solutions and website packages.</td>
                    <td>Facebook, Instagram, LinkedIn, Twitter/X</td>
                    <td>3–4 posts/week, ads ongoing</td>
                </tr>
                <tr>
                    <td>Email Marketing</td>
                    <td>Send newsletters with promotions (e.g., free SAAS trial) and case studies; offer free resources like "SAAS Implementation Guide."</td>
                    <td>Mailchimp or similar</td>
                    <td>Bi-weekly</td>
                </tr>
                <tr>
                    <td>Paid Ads</td>
                    <td>Run Google Ads for search intent (e.g., "custom SAAS solutions"); LinkedIn Ads for B2B targeting.</td>
                    <td>Google Ads, LinkedIn Ads</td>
                    <td>Ongoing</td>
                </tr>
                <tr>
                    <td>Networking & Partnerships</td>
                    <td>Attend industry events; partner with complementary SAAS providers or service companies for referrals.</td>
                    <td>Eventbrite, LinkedIn, industry forums</td>
                    <td>1–2 events/month</td>
                </tr>
                <tr>
                    <td>Webinars & Demos</td>
                    <td>Host webinars on SAAS topics; offer free demos of SAAS features.</td>
                    <td>Zoom, WebinarJam, or similar</td>
                    <td>Monthly</td>
                </tr>
            </tbody>
        </table>

        <h2>Weekly Action Plan</h2>
        <table class="marketing-table action-plan">
            <thead>
                <tr>
                    <th>Week</th>
                    <th>Tasks</th>
                    <th>Responsible</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Week 1</td>
                    <td>Create blog post on SAAS benefits, schedule social media posts, launch email campaign with SAAS promotion.</td>
                    <td>Marketing Team</td>
                </tr>
                <tr>
                    <td>Week 2</td>
                    <td>Launch social media ads, update website SEO, follow up with leads.</td>
                    <td>Marketing Team, Web Developer</td>
                </tr>
                <tr>
                    <td>Week 3</td>
                    <td>Send newsletter with case studies, attend networking event, analyze ad performance.</td>
                    <td>Marketing Team</td>
                </tr>
                <tr>
                    <td>Week 4</td>
                    <td>Review metrics (leads, traffic, MRR), adjust ad budgets, plan next month’s content and webinars.</td>
                    <td>Marketing Team, Manager</td>
                </tr>
            </tbody>
        </table>

        <h2>Budget Allocation</h2>
        <table class="marketing-table budget">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>PH Budget (₱/Month)</th>
                    <th>Intl Budget ($/Month)</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Social Media Ads</td>
                    <td>₱1,500 – ₱6,000</td>
                    <td>$30 – $120</td>
                    <td>30%</td>
                </tr>
                <tr>
                    <td>Google Ads & LinkedIn Ads</td>
                    <td>₱2,000 – ₱8,000</td>
                    <td>$40 – $160</td>
                    <td>40%</td>
                </tr>
                <tr>
                    <td>Email Marketing Tools</td>
                    <td>₱500 – ₱2,000</td>
                    <td>$10 – $40</td>
                    <td>10%</td>
                </tr>
                <tr>
                    <td>Content Creation & Webinars</td>
                    <td>₱750 – ₱3,000</td>
                    <td>$15 – $60</td>
                    <td>15%</td>
                </tr>
                <tr>
                    <td>Networking/Event Fees</td>
                    <td>₱250 – ₱1,000</td>
                    <td>$5 – $20</td>
                    <td>5%</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>₱5,000 – ₱20,000</strong></td>
                    <td><strong>$100 – $400</strong></td>
                    <td><strong>100%</strong></td>
                </tr>
            </tbody>
        </table>

        <h2>Performance Metrics</h2>
        <ul class="metrics-list">
            <li><strong>Leads:</strong> Track inquiries via contact form and email (target: 10–20/month).</li>
            <li><strong>Conversions:</strong> Measure signed contracts or deposits (target: 2–4 clients/month).</li>
            <li><strong>Website Traffic:</strong> Monitor sessions and page views via Google Analytics (target: +15% monthly).</li>
            <li><strong>Engagement:</strong> Track social media likes, comments, shares, and email open/click rates (target: +20% monthly).</li>
            <li><strong>ROI:</strong> Calculate revenue from new clients vs. marketing spend (target: 2x spend).</li>
            <li><strong>MRR:</strong> Track monthly recurring revenue growth (target: +10% monthly).</li>
            <li><strong>Churn Rate:</strong> Monitor customer churn (target: <5% monthly).</li>
        </ul>

        <h2>Assistant Marketing Guide</h2>
        <div class="assistant-guide">
            <h3>Welcome, BizlyHub Assistant!</h3>
            <p>Your role is crucial to help us grow. Here’s your monthly guide to finding new clients and promoting our SAAS solutions and website services.</p>

            <h4>Weekly Goals</h4>
            <ul>
                <li>Reach out to at least <strong>20 potential clients</strong> per week</li>
                <li>Get <strong>3 responses or interest</strong> per week</li>
                <li>Close at least <strong>1 website sale or SAAS subscription</strong> per week</li>
            </ul>

            <h4>Who to Contact</h4>
            <ul>
                <li>Small businesses without websites or outdated SAAS tools</li>
                <li>Facebook Pages with poor websites or no SAAS integration</li>
                <li>Online sellers (Shopee, Lazada, Facebook Marketplace)</li>
                <li>Restaurants, cafés, or local shops looking to digitize operations</li>
                <li>Church groups, NGOs, and freelancers needing custom SAAS solutions</li>
            </ul>

            <h4>Sample Message to Send</h4>
            <div class="highlight">
                Hi! I'm with BizlyHub. We build affordable websites and custom SAAS solutions for businesses. Are you looking to enhance your online presence or streamline your operations? We offer packages starting at just ₱5,000. 😊
            </div>

            <h4>Selling Points</h4>
            <ul>
                <li>Affordable, professional, and fast</li>
                <li>Mobile-friendly and SEO-ready websites</li>
                <li>Custom SAAS solutions tailored to your business needs</li>
                <li>Full ownership of the website or SAAS platform</li>
                <li>Free consultation and local team support</li>
            </ul>

            <h4>Current Promo (This Month)</h4>
            <div class="highlight">
                10% discount on all website packages or SAAS subscriptions if client pays full upfront. Offer valid until <?php echo $promo_end_date; ?>!
            </div>

            <h4>Daily Checklist</h4>
            <div class="task">🔲 Find 5 new businesses to contact</div>
            <div class="task">🔲 Send at least 5 outreach messages (chat or email)</div>
            <div class="task">🔲 Post 1 marketing story or post on Facebook/Instagram</div>
            <div class="task">🔲 Follow up with old leads</div>
            <div class="task">🔲 Update progress to Trello</div>

            <h4>If a Client is Interested</h4>
            <p>Let them know our developer will meet them online or in-person for a free consultation. If they’re ready, ask them to send their details and pay the 50% down payment to start.</p>

            <h4>Tips</h4>
            <ul>
                <li>Always be polite and friendly</li>
                <li>Listen to the client’s needs before offering a solution</li>
                <li>Use simple words, avoid technical terms unless needed</li>
                <li>Highlight SAAS benefits like scalability, security, and integration</li>
            </ul>

            <p><em>Thank you for your hard work! Let's build BizlyHub together. 💪</em></p>
        </div>
    </main>

    <footer class="dashboard-footer">
        <p>© <?php echo date('Y'); ?> BizlyHub. All rights reserved.</p>
    </footer>
</body>
</html>