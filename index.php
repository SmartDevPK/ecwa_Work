<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ECWA Payment Collection Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="main.css" />
</head>

<body>
    <!-- Header -->
    <header id="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <img src="download.jpeg" alt="ECWA Logo" />
                    <div class="logo-text">
                        <h1>ECWA</h1>
                    </div>
                </div>
                <ul class="nav-links" id="navLinks">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#register">Register</a></li>
                    <li><a href="#login">Login</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <div class="mobile-menu" id="mobileMenu">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="video-container">
            <video autoplay muted loop playsinline id="hero-video">
                <source src="hero video 2.mp4" type="video/mp4" />
                <source src="hero video 2.mp4" type="video/webm" />
                <img src="https://solacebase.com/wp-content/uploads/2023/10/Senate-justifies-luxury-vehicles-for-members-says-Nigerian-roads-bad.jpg"
                    alt="Luxury Vehicles" />
            </video>
            <div class="video-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="animate">ECWA Payment Collection Center for All School Fees</h1>
                <p class="slogan animate delay-1">Making school payments easier and faster.</p>
                <div class="hero-buttons animate delay-3">
                    <a href="#login" class="btn">LOGIN</a>
                    <a href="#register" class="btn btn-primary">REGISTER</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Register Section -->
    <section id="register" class="section-padding">
        <div class="container">
            <h3 class="section-title animate">Register</h3>
            <form id="registerForm" action="process_form.php">
                <div class="form-group">
                    <label for="reg-username">Username</label>
                    <input type="text" id="reg-username" name="username" required />
                    <input type="hidden" name="form_type" value="register" />
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="reg-email">Email</label>
                        <input type="email" id="reg-email" name="email" required />
                    </div>
                    <div class="form-group">
                        <label for="reg-password">Password</label>
                        <input type="password" id="reg-password" name="password" required />
                    </div>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="form-response" id="registerResponse"></div>
            </form>
        </div>
    </section>

    <!-- Login Section -->
    <section id="login" class="section-padding">
        <div class="container">
            <h3 class="section-title animate">Login</h3>
            <form id="loginForm" action="process_form.php">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" required />
                    <input type="hidden" name="form_type" value="login" />
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required />
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="form-response" id="loginResponse"></div>
            </form>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-padding">
        <div class="container">
            <h2 class="section-title animate">Contact Us</h2>
            <p class="section-subtitle animate delay-1">
                Get in touch with our team for any inquiries or special requests
            </p>
            <div class="contact-form animate delay-3">
                <h3>Send Us a Message</h3>
                <form id="contactForm" action="process_form.php">
                    <div class="form-group">
                        <label for="contact-name">Full Name</label>
                        <input type="text" id="contact-name" name="contact_name" required />
                        <input type="hidden" name="form_type" value="contact" />
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-email">Email</label>
                            <input type="email" id="contact-email" name="contact_email" required />
                        </div>
                        <div class="form-group">
                            <label for="contact-phone">Phone Number</label>
                            <input type="tel" id="contact-phone" name="contact_phone" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact-subject">Subject</label>
                        <input type="text" id="contact-subject" name="contact_subject" required />
                    </div>
                    <div class="form-group">
                        <label for="contact-message">Message</label>
                        <textarea id="contact-message" name="contact_message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn">Send Message</button>
                    <div class="form-response" id="contactResponse"></div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; 2025 ECWA. All Rights Reserved.</p>
                    <div class="legal-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <a href="#">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenu = document.getElementById('mobileMenu');
            const navLinks = document.getElementById('navLinks');

            mobileMenu.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                mobileMenu.classList.toggle('fa-times');
                mobileMenu.classList.toggle('fa-bars');
            });

            document.querySelectorAll('#navLinks a').forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('active');
                    mobileMenu.classList.remove('fa-times');
                    mobileMenu.classList.add('fa-bars');
                });
            });

            window.addEventListener('scroll', () => {
                const header = document.getElementById('header');
                header.classList.toggle('scrolled', window.scrollY > 50);
            });

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(anchor.getAttribute('href'));
                    if (target) {
                        navLinks.classList.remove('active');
                        mobileMenu.classList.remove('fa-times');
                        mobileMenu.classList.add('fa-bars');
                        window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
                    }
                });
            });

            function animateOnScroll() {
                document.querySelectorAll('.animate').forEach(el => {
                    if (el.getBoundingClientRect().top < window.innerHeight / 1.2) {
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }
                });
            }

            window.addEventListener('load', () => {
                document.querySelectorAll('.animate').forEach(el => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(30px)';
                    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                });
                animateOnScroll();
            });

            window.addEventListener('scroll', animateOnScroll);

            async function handleFormSubmit(form, type) {
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const responseElement = document.getElementById(`${type}Response`);

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                responseElement.style.display = 'none';

                try {
                    const response = await fetch('process_form.php', { method: 'POST', body: formData });
                    const data = await response.json();

                    responseElement.style.display = 'block';
                    responseElement.className = `form-response ${data.success ? 'success' : 'error'}`;
                    responseElement.textContent = data.message;

                    if (data.success) {
                        if (type === 'register') {
                            setTimeout(() => window.location.href = '#login', 2000);
                        } else if (type === 'login') {
                            window.location.href = 'ecwaUser.php';
                        }
                        if (type !== 'contact') form.reset();
                    }
                } catch (err) {
                    responseElement.style.display = 'block';
                    responseElement.className = 'form-response error';
                    responseElement.textContent = 'An error occurred. Please try again.';
                    console.error(err);
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = type === 'login' ? 'Login' : type === 'register' ? 'Register' : 'Send Message';
                }
            }

            document.getElementById('registerForm')?.addEventListener('submit', e => {
                e.preventDefault();
                handleFormSubmit(e.target, 'register');
            });

            document.getElementById('loginForm')?.addEventListener('submit', e => {
                e.preventDefault();
                handleFormSubmit(e.target, 'login');
            });

            document.getElementById('contactForm')?.addEventListener('submit', e => {
                e.preventDefault();
                handleFormSubmit(e.target, 'contact');
            });
        });
    </script>
</body>

</html>