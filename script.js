const menuToggle = document.getElementById('menu-toggle');
const navLinks = document.querySelector('.nav-links');

menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

// Initialize EmailJS with your public key (replace with your actual public key)
emailjs.init('mdmobashir178@gmail.com'); // e.g. 'user_xxx123'

// Smooth scrolling for nav links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        navLinks.classList.remove('active'); // Close menu on link click (optional)
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Fade-in animation on scroll using IntersectionObserver
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target); // Stop observing after fade-in
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
});

// Contact form submission using EmailJS
const form = document.getElementById('contact-form');
const status = document.getElementById('form-status');

if (form && status) {
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Replace 'service_abc123' and 'template_xyz456' with your EmailJS service and template IDs
        emailjs.sendForm('service_abc123', 'template_xyz456', this)
            .then(() => {
                status.textContent = "Message sent successfully!";
                status.style.color = "green";
                form.reset();
            }, (err) => {
                status.textContent = "Oops! Something went wrong: " + JSON.stringify(err);
                status.style.color = "red";
            });
    });
} else {
    console.warn('Contact form or status element not found in the DOM.');
}