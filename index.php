<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Web Design & Development Solutions</title>
    <meta name="description" content="BizlyHub: Elevate your online presence with expert web design and development. Custom, high-performance websites tailored to your business.">
    <meta name="keywords" content="web design, web development, responsive websites, custom web solutions">
    <meta name="author" content="Joseph Peralta">
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/main.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
</head>
<body>
    <nav class="navbar" aria-label="Main navigation">
        <div class="navbar-container">
            <a href="#home" class="logo animate-in" aria-label="BizlyHub Home">BizlyHub</a>
            <button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
            <div class="nav-links" role="menu">
                <a href="#home" role="menuitem">Home</a>
                <a href="#features" role="menuitem">Services</a>
                <a href="#about" role="menuitem">About</a>
                <a href="#portfolio" role="menuitem">Portfolio</a>
                <a href="blogs">Blogs</a>
                <a href="#pricing" role="menuitem">Pricing</a>
                <a href="#contact" role="menuitem">Contact</a>
            </div>
        </div>
    </nav>

    <section id="home" class="hero animate-in" aria-labelledby="hero-title">
        <div class="hero-content">
            <h1 id="hero-title">Craft Your Perfect Website</h1>
            <p>Elevate your online presence with stunning, high-performance websites designed and developed by BizlyHub’s expert team.</p>
            <a href="#pricing" class="cta-button" aria-label="Get started with our services">Get Started <span>→</span></a>
        </div>
    </section>

    <section id="features" class="features animate-in">
        <h2 class="section-title">Our Web Solutions</h2>
        <div class="features-grid">
            <div class="feature-card">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93V15H7v-2h4V8.07l5 5-5 5z"/></svg>
                <h3>Custom Web Design</h3>
                <p>Stand out with a unique, visually stunning website tailored to captivate your audience.</p>
            </div>
            <div class="feature-card">
                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                <h3>Web Development</h3>
                <p>Get a fast, secure, and scalable site that grows with your business effortlessly.</p>
            </div>
            <div class="feature-card">
                <svg viewBox="0 0 24 24"><path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"/></svg>
                <h3>Responsive Design</h3>
                <p>Reach customers anywhere with a seamless experience on all devices.</p>
            </div>
        </div>
    </section>

    <section id="about" class="about animate-in">
        <h2 class="section-title">About BizlyHub</h2>
        <div class="about-content">
            <p>At BizlyHub, we’re more than just a web design company – we’re storytellers who bring your brand to life online. Founded by a team of creative minds and tech enthusiasts, we’ve been crafting exceptional websites since 2018. Our mission? To empower businesses with digital solutions that inspire, engage, and convert. We value innovation, precision, and your success above all.</p>
        </div>
    </section>

    <section id="portfolio" class="portfolio animate-in">
        <h2 class="section-title">Our Work</h2>
        <div class="portfolio-grid">
                <div class="portfolio-card">
                    <a href="#contact">
                        <img src="images/custome-web-app.webp" alt="E-Commerce Store Project" Loading="lazy" width="400" height="200">
                        <div>
                            <h4>Custome Web Application</h4>
                            <p>Unlock the full potential of your business with a Custom Web Application tailored to your unique needs.</p>
                        </div>
                    </a>
                </div>
            <div class="portfolio-card">
                <a href="https://portfolio.bizlyhub.com/petshop/" target="_blank">
                    <img src="images/pawsome-hero-banner.webp" alt="Portfolio Site Project Pawsome" loading="lazy" width="400" height="200">
                    <div>
                        <h4>Pawsome</h4>
                        <p>Your trusted partner in pet care—quality products, expert advice, and compassionate services for your furry friends.</p>
                    </div>
                </a>
            </div>
            <div class="portfolio-card">
                <a href="https://portfolio.bizlyhub.com/va/" target="_blank">
                    <img src="images/eliteva-hero-banner.webp" alt="Business Landing Page Project" loading="lazy" width="400" height="200">
                    <div>
                        <h4>Business Landing Page</h4>
                        <p>A high-converting page for lead generation.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section id="testimonials" class="testimonials animate-in">
        <h2 class="section-title">What Our Clients Say</h2>
        <div class="testimonials-container">
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <p>"BizlyHub turned our vision into a stunning website that’s boosted our business. Their attention to detail is unmatched!"</p>
                    <h4>Sarah Johnson</h4>
                    <span>CEO, BrightFuture Co.</span>
                </div>
                <div class="testimonial-card">
                    <p>"The team delivered a fast, responsive site that our customers love. Highly recommend their development skills."</p>
                    <h4>Mike Chen</h4>
                    <span>Founder, TechTrendz</span>
                </div>
                <div class="testimonial-card">
                    <p>"From design to launch, BizlyHub made the process seamless. Our online presence has never been stronger."</p>
                    <h4>Emily Davis</h4>
                    <span>Marketing Director, GrowEasy</span>
                </div>
            </div>
            <div class="testimonial-indicators">
                <span class="indicator active" data-index="0"></span>
                <span class="indicator" data-index="1"></span>
                <span class="indicator" data-index="2"></span>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing animate-in">
        <h2 class="section-title">Web Design Packages</h2>
        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Basic</h3>
                <div class="price">$499<span style="font-size: 1rem; color: #6B7280;">/one-time</span></div>
                <ul>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>5-Page Website</li>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Basic Design</li>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Mobile Responsive</li>
                </ul>
                <a href="#contact" class="cta-button">Choose Plan</a>
            </div>
            <div class="pricing-card popular">
                <h3>Professional</h3>
                <div class="price">$999<span style="font-size: 1rem; color: #6B7280;">/one-time</span></div>
                <ul>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>10-Page Website</li>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Custom Design</li>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>SEO Optimization</li>
                </ul>
                <a href="#contact" class="cta-button">Choose Plan</a>
            </div>
            <div class="pricing-card">
                <h3>Enterprise</h3>
                <div class="price">$1999<span style="font-size: 1rem; color: #6B7280;">/one-time</span></div>
                <ul>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Unlimited Pages</li>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Advanced Features</li>
                    <li><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Priority Support</li>
                </ul>
                <a href="#contact" class="cta-button">Choose Plan</a>
            </div>
        </div>
    </section>

    <section id="blog" class="blog animate-in">
        <h2 class="section-title">Latest Insights</h2>
        <div class="blog-grid">
            <div class="blog-card">
                <a href="blogs/best-design-practices.php" target="_blank" rel="noopener noreferrer">
                    <img src="images/web-trends-2025.webp" alt="Blog post about web design trends" loading="lazy" width="300" height="200">
                    <div>
                        <h4>Websites Best Design Practices</h4>
                        <p>Crafting captivating websites requires a deep <br>
                        understanding of <strong>effective design practices.</strong></p>
                    </div>
                </a>
            </div>
            <div class="blog-card">
                <a href="blogs/how-to-optimize-your-site-for-speed.php" target="_blank" rel="noopener noreferrer">
                    <img src="images/site-optimization.webp" alt="Blog post about site optimization" loading="lazy" width="300" height="200">
                    <div>
                        <h4>How to Optimize Your Site for Speed</h4>
                        <p>Boost performance with these expert tips.</p>
                    </div>
                </a>
            </div>
            <div class="blog-card">
                <a href="blogs/how-a-well-designed-website-can-boost-your-sales-in-2025.php" target="_blank" rel="noopener noreferrer">
                    <img src="images/seo-basics.webp" alt="Blog post about SEO basics" loading="lazy">
                    <div>
                        <h4>Boost Your Sales in 2025</h4>
                        <p>How a Well-Designed Website Can Boost Your Sales in 2025.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section id="faq" class="faq animate-in">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question" tabindex="0">
                    <h4>How long does it take to build a website?</h4>
                    <span>↓</span>
                </div>
                <div class="faq-answer">
                    <p>Timelines vary by project size. A Basic package takes 2-3 weeks, Professional 4-6 weeks, and Enterprise 8-12 weeks.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" tabindex="0">
                    <h4>Do you offer ongoing maintenance?</h4>
                    <span>↓</span>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer optional maintenance plans starting at $49/month for updates and support.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" tabindex="0">
                    <h4>Can I update the site myself?</h4>
                    <span>↓</span>
                </div>
                <div class="faq-answer">
                    <p>Absolutely! We provide a user-friendly CMS with all packages for easy content updates.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="subscribe" class="subscribe-section animate-in">
        <h2 class="section-title">Get Exclusive Deals & Updates</h2>
        <p>Sign up for our newsletter and be the first to know about new products, special offers, and exclusive content.</p>
        <form class="subscribe-form" id="subscribeForm" action="php/subscribe.php" method="POST">
            <input type="email" name="email" placeholder="Your Email" required aria-label="Email for subscription">
            <button type="submit">Subscribe</button>
        </form>
    </section>

    <section id="contact" class="contact animate-in">
        <h2 class="section-title">Let’s Build Your Website</h2>
        <div class="contact-form">
            <form id="contactForm" action="php/contact.php" method="POST" aria-label="Contact form">
                <div class="form-group">
                    <input type="text" id="name" name="name" placeholder=" " required aria-required="true">
                    <label for="name">Your Name</label>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder=" " required aria-required="true">
                    <label for="email">Your Email</label>
                </div>
                <div class="form-group">
                    <textarea id="message" name="message" placeholder=" " rows="5" required aria-required="true"></textarea>
                    <label for="message">Tell us about your project</label>
                </div>
                <button type="submit" class="submit-button">Send Inquiry</button>
            </form>
        </div>
    </section>

    <footer class="footer animate-in">
        <div class="footer-container">
            <div class="footer-section">
                <h4>BizlyHub</h4>
                <p>Crafting exceptional websites for your success.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Services</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Connect With Us</h4>
                <div class="social-links">
                    <a href="https://x.com/BizlyHub" target="_blank" aria-label="Twitter">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 3H21L13.5 10.92L22 21H15.5L10.26 14.48L4.97 21H1L9.02 12.39L1 3H7.7L12.47 9.07L17.5 3ZM16.39 19H17.87L6.62 5H5.02L16.39 19Z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61567562983142" target="_blank" aria-label="Facebook">
                        <img src="images/fb-icon.png" alt="faceboook" width="30" height="30">
                    </a>
                    <a href="https://www.linkedin.com/in/jdperalta/" target="_blank" aria-label="LinkedIn">
                        <img src="images/linkedin-icon.png" alt="linkedin" width="30" height="30">
                    </a>
                    <a href="https://www.instagram.com/bizlyhub?igsh=aWptN3RucnBmd3Vp&fbclid=IwY2xjawJTCbtleHRuA2FlbQIxMAABHRO6uY5uIwsgszh77ufQduzuZUWuIdGZ9K-JUN8XwbtSjhm9VI6R2X607g_aem_kUZ19BGEEuuTh06xyFP7Wg" target="_blank" aria-label="Instagram">
                        <img src="images/instagram-icon.png" alt="instagram" width="30" height="30">
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 BizlyHub. All rights reserved. <a href="#" onclick="openModal('privacyModal')">Privacy Policy</a> | <a href="#" onclick="openModal('termsModal')">Terms of Service</a></p>
        </div>
    </footer>

    <button class="back-to-top" aria-label="Back to top">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
            <path d="M12 4l-8 8h6v8h4v-8h6l-8-8z"/>
        </svg>
    </button>

    <!-- Modals -->
    <div id="privacyModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h1>Privacy Policy</h1>
            <p>Last Updated: March 26, 2025</p>
            <h2>1. Introduction</h2>
            <p>At BizlyHub, we value your privacy. This Privacy Policy explains how we collect, use, and protect your personal information when you visit our website or use our services.</p>
            <h2>2. Information We Collect</h2>
            <p>We may collect:
                <ul>
                    <li>Name, email, and message from contact forms.</li>
                    <li>Email addresses from newsletter subscriptions.</li>
                    <li>Usage data (e.g., pages visited) via cookies.</li>
                </ul>
            </p>
            <h2>3. How We Use Your Information</h2>
            <p>Your data helps us:
                <ul>
                    <li>Respond to inquiries and provide services.</li>
                    <li>Send updates and marketing emails (with consent).</li>
                    <li>Improve our website and user experience.</li>
                </ul>
            </p>
            <h2>4. Sharing Your Information</h2>
            <p>We do not sell your data. We may share it with trusted third parties (e.g., email providers) only to deliver our services.</p>
            <h2>5. Your Rights</h2>
            <p>You can request access, correction, or deletion of your data by contacting us at support@bizlyhub.com.</p>
            <h2>6. Contact Us</h2>
            <p>For questions, email us at support@bizlyhub.com.</p>
        </div>
    </div>

    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h1>Terms of Service</h1>
            <p>Last Updated: March 26, 2025</p>
            <h2>1. Acceptance of Terms</h2>
            <p>By using BizlyHub’s website or services, you agree to these Terms of Service. If you do not agree, please do not use our services.</p>
            <h2>2. Services</h2>
            <p>We provide web design and development services as outlined on our site. Project scope and pricing are agreed upon in writing before work begins.</p>
            <h2>3. Payment</h2>
            <p>Payments are due as per the agreed schedule. Late payments may incur a 5% fee per month.</p>
            <h2>4. Intellectual Property</h2>
            <p>Upon full payment, you own the website. We retain rights to use it in our portfolio unless otherwise agreed.</p>
            <h2>5. Limitation of Liability</h2>
            <p>BizlyHub is not liable for indirect damages or losses arising from the use of our services.</p>
            <h2>6. Contact Us</h2>
            <p>For questions, email us at support@bizlyhub.com.</p>
        </div>
    </div>

    <script src="js/main.js" defer></script>
</body>
</html>