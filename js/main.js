// Smooth Scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Navbar Shrink
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    navbar.style.padding = window.scrollY > 50 ? '10px 0' : '20px 0';
});

// Menu Toggle
const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');
menuToggle.addEventListener('click', () => {
    const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', !isExpanded);
    navLinks.classList.toggle('active');
    menuToggle.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
});

// Close mobile menu on outside click
document.addEventListener('click', (e) => {
    if (!navLinks.contains(e.target) && !menuToggle.contains(e.target) && navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.textContent = '☰';
    }
});

// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', () => {
        const parent = item.parentElement;
        parent.classList.toggle('active');
    });
    item.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            item.parentElement.classList.toggle('active');
        }
    });
});

// Testimonial Carousel
const testimonialsGrid = document.querySelector('.testimonials-grid');
const indicators = document.querySelectorAll('.indicator');
let currentIndex = 0;
const totalSlides = 3;

function updateCarousel(index) {
    testimonialsGrid.style.transform = `translateX(-${index * 100}%)`; // Changed to 100% for mobile
    indicators.forEach(ind => ind.classList.remove('active'));
    indicators[index].classList.add('active');
    currentIndex = index;
}

function autoScroll() {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateCarousel(currentIndex);
}

indicators.forEach(indicator => {
    indicator.addEventListener('click', () => {
        const index = parseInt(indicator.getAttribute('data-index'));
        updateCarousel(index);
    });
});

let autoScrollInterval = setInterval(autoScroll, 5000);

document.querySelector('.testimonials-container').addEventListener('mouseenter', () => {
    clearInterval(autoScrollInterval);
});

document.querySelector('.testimonials-container').addEventListener('mouseleave', () => {
    autoScrollInterval = setInterval(autoScroll, 5000);
});

// Lazy Loading and Animations
document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('img');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                observer.unobserve(img);
            }
        });
    });
    images.forEach(img => {
        img.dataset.src = img.src;
        img.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
        observer.observe(img);
    });

    const elements = document.querySelectorAll('.animate-in');
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                animationObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    elements.forEach(el => animationObserver.observe(el));
});

// Back to Top Button
const backToTop = document.querySelector('.back-to-top');
window.addEventListener('scroll', () => {
    backToTop.classList.toggle('visible', window.scrollY > 300);
});

backToTop.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'flex';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Close Modal on Click
document.querySelectorAll('.modal-close').forEach(closeBtn => {
    closeBtn.addEventListener('click', () => {
        closeBtn.closest('.modal').style.display = 'none';
    });
});

// Close Modal on Outside Click
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// Create a global alert container
document.addEventListener('DOMContentLoaded', () => {
    const alertContainer = document.createElement('div');
    alertContainer.className = 'alert-container';
    document.body.appendChild(alertContainer);
});

// Function to show custom alerts
function showAlert(message, isError = false) {
    const alertContainer = document.querySelector('.alert-container');

    // Remove any existing alerts
    const existingAlert = alertContainer.querySelector('.alert');
    if (existingAlert) existingAlert.remove();

    // Create the alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${isError ? 'error' : 'success'}`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
        <span class="icon"></span>
        <span class="message">${message}</span>
    `;

    // Add the alert to the container
    alertContainer.appendChild(alertDiv);

    // Trigger the show animation
    setTimeout(() => alertDiv.classList.add('show'), 10);

    // Auto-dismiss after 3 seconds
    setTimeout(() => {
        alertDiv.classList.remove('show');
        setTimeout(() => alertDiv.remove(), 300); // Wait for fade-out animation
    }, 3000);
}

// Function to show/hide loading spinner
function toggleLoading(form, show = true) {
    if (show) {
        form.classList.add('form-loading');
        const spinner = document.createElement('div');
        spinner.className = 'loading-spinner';
        form.appendChild(spinner);
    } else {
        form.classList.remove('form-loading');
        const spinner = form.querySelector('.loading-spinner');
        if (spinner) spinner.remove();
    }
}

// Update form submission handlers
document.getElementById('subscribeForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    toggleLoading(form, true);

    try {
        const response = await fetch('php/subscribe.php', {
            method: 'POST',
            body: new FormData(form)
        });
        const result = await response.json();
        toggleLoading(form, false);
        showAlert(result.message, !response.ok);
        if (response.ok) form.reset();
    } catch (error) {
        toggleLoading(form, false);
        showAlert('Error subscribing. Please try again.', true);
    }
});

document.getElementById('contactForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    toggleLoading(form, true);

    try {
        const response = await fetch('php/contact.php', {
            method: 'POST',
            body: new FormData(form)
        });
        const result = await response.json();
        toggleLoading(form, false);
        showAlert(result.message, !response.ok);
        if (response.ok) form.reset();
    } catch (error) {
        toggleLoading(form, false);
        showAlert('Error sending inquiry. Please try again.', true);
    }
});