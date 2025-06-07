<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ECWA Payment Collection Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        /* Modern Global Styles */
        :root {
            --primary-color: #003366;
            --secondary-color: #ff6600;
            --accent-color: #f8f9fa;
            --text-color: #333;
            --light-color: #fff;
            --dark-color: #222;
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--accent-color);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: var(--transition);
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 25px;
        }

        .btn {
            display: inline-block;
            background: var(--secondary-color);
            color: var(--light-color);
            padding: 14px 32px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.2);
        }

        .btn:hover {
            background: #e65c00;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 102, 0, 0.3);
        }

        .btn-primary {
            background: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.2);
        }

        .btn-primary:hover {
            background: #002244;
            box-shadow: 0 15px 30px rgba(0, 51, 102, 0.3);
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            text-align: center;
            position: relative;
            padding-bottom: 15px;
            font-weight: 700;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--secondary-color);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            text-align: center;
            max-width: 700px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        .section-padding {
            padding: 100px 0;
        }

        /* Animated Elements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate {
            animation: fadeInUp 1s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        .delay-3 {
            animation-delay: 0.6s;
        }

        .delay-4 {
            animation-delay: 0.8s;
        }

        /* Header Styles */
        header {

            background-color: var(--light-color);
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header.scrolled {
            padding: 5px 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            transition: all 0.3s ease;
        }

        header.scrolled .navbar {
            padding: 10px 0;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 60px;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        header.scrolled .logo img {
            height: 50px;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: 700;
            transition: all 0.3s ease;
        }

        header.scrolled .logo-text h1 {
            font-size: 1.3rem;
        }

        .logo-text span {
            color: var(--secondary-color);
        }

        .nav-links {
            display: flex;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            color: var(--text-color);
            font-weight: 600;
            font-size: 1rem;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-links li:nth-child(4) a {
            color: var(--secondary-color);
            font-weight: 700;
        }

        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--primary-color);
        }

        /* Hero Section with Video Background */
        .hero {
            position: relative;
            height: 100vh;
            min-height: 700px;
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--light-color);
            overflow: hidden;
        }

        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        #hero-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .hero-content .slogan {
            font-size: 1.5rem;
            margin-bottom: 30px;
            font-weight: 300;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .hero-content p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* Services Section */
        .services {
            background-color: var(--light-color);
            position: relative;
            overflow: hidden;
        }

        .services::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            opacity: 0.03;
            z-index: 0;
        }

        .services .container {
            position: relative;
            z-index: 1;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .service-card {
            background: var(--accent-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            z-index: 1;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .service-img {
            height: 220px;
            overflow: hidden;
        }

        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-card:hover .service-img img {
            transform: scale(1.1);
        }

        .service-content {
            padding: 25px;
        }

        .service-content h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .service-content p {
            margin-bottom: 20px;
            color: #666;
        }

        /* Fleet Section */
        .fleet {
            background-color: var(--accent-color);
            position: relative;
        }

        .fleet::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1494972308805-463bc619d34e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            opacity: 0.03;
            z-index: 0;
        }

        .fleet .container {
            position: relative;
            z-index: 1;
        }

        .fleet-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .car-card {
            background: var(--light-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .car-img {
            height: 220px;
            overflow: hidden;
        }

        .car-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-img img {
            transform: scale(1.1);
        }

        .car-details {
            padding: 25px;
        }

        .car-details h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .car-specs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #666;
        }

        .car-specs span {
            display: flex;
            align-items: center;
        }

        .car-specs i {
            margin-right: 5px;
            color: var(--secondary-color);
        }

        .car-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        /* Locations Section */
        .locations {
            background-color: var(--light-color);
            position: relative;
        }

        .locations::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1483728642387-6c3bdd6c93e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            opacity: 0.03;
            z-index: 0;
        }

        .locations .container {
            position: relative;
            z-index: 1;
        }

        .location-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .location-card {
            background: var(--accent-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .location-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .location-img {
            height: 220px;
            overflow: hidden;
        }

        .location-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .location-card:hover .location-img img {
            transform: scale(1.1);
        }

        .location-info {
            padding: 25px;
        }

        .location-info h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .location-info p {
            margin-bottom: 20px;
            color: #666;
        }

        /* IEC Service Section */
        .iec-service {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            position: relative;
            overflow: hidden;
        }

        .iec-service .container {
            position: relative;
            z-index: 1;
        }

        .service-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .service-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .service-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-card:hover .service-image img {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.5) 100%);
        }

        .service-content {
            padding: 25px;
            text-align: center;
            position: relative;
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #004080 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -40px auto 20px;
            color: white;
            font-size: 24px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 2;
            position: relative;
        }

        .service-content h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .service-content p {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .modern-select-btn {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #ff8533 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.2);
            transition: var(--transition);
        }

        .modern-select-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);
        }

        .modern-select-btn i {
            transition: transform 0.3s ease;
        }

        .modern-select-btn:hover i {
            transform: translateX(5px);
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(rgba(0, 51, 102, 0.9), rgba(0, 51, 102, 0.9)), url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            color: var(--light-color);
            text-align: center;
            padding: 120px 0;
            position: relative;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .cta p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        /* Contact Section */
        .contact {
            background-color: var(--light-color);
            position: relative;
        }

        .contact::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            opacity: 0.03;
            z-index: 0;
        }

        .contact .container {
            position: relative;
            z-index: 1;
        }

        .contact-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 50px;
            margin-top: 50px;
        }

        .contact-info h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .contact-details {
            margin-bottom: 30px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .contact-item i {
            font-size: 1.2rem;
            color: var(--secondary-color);
            margin-right: 15px;
            margin-top: 5px;
        }

        .contact-form {
            background: var(--accent-color);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .contact-form h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.2);
            outline: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .social-links {
            display: flex;
            margin-top: 30px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: var(--primary-color);
            color: var(--light-color);
            border-radius: 50%;
            margin-right: 15px;
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .social-links a:hover {
            background: var(--secondary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 102, 0, 0.3);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: var(--light-color);
            margin: 5% auto;
            padding: 40px;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 700px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalopen 0.5s;
        }

        @keyframes modalopen {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.8rem;
            color: #777;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--secondary-color);
            transform: rotate(90deg);
        }

        /* IEC Quote Form Styles */
        .iec-form-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .iec-form-title h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .iec-form-title p {
            color: #666;
        }

        .form-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: 700;
            color: #666;
            position: relative;
            transition: all 0.3s ease;
        }

        .step.active {
            background: var(--secondary-color);
            color: white;
        }

        .step.completed {
            background: var(--primary-color);
            color: white;
        }

        .step::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 20px;
            height: 2px;
            background: #ddd;
        }

        .step:last-child::after {
            display: none;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .checkbox-group {
            margin-bottom: 20px;
        }

        .checkbox-group h4 {
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .checkbox-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
        }

        .checkbox-item input {
            margin-right: 10px;
            width: auto;
        }

        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .form-navigation button {
            padding: 12px 30px;
        }

        /* Success Modal */
        .success-modal {
            text-align: center;
            padding: 40px;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 50px;
        }

        .success-modal h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .success-modal p {
            margin-bottom: 30px;
            font-size: 1.1rem;
            color: #666;
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 80px 0 30px;
            position: relative;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-col h4 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            color: var(--secondary-color);
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--secondary-color);
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: #bbb;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-col ul li a:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }

        .company-description {
            color: #bbb;
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #444;
            font-size: 0.9rem;
            color: #bbb;
        }

        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .legal-links a {
            color: #bbb;
            margin-left: 20px;
            transition: color 0.3s ease;
        }

        .legal-links a:hover {
            color: var(--secondary-color);
        }

        /* Form State Styles */
        .form-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .form-loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .form-success-message {
            display: none;
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .form-error-message {
            display: none;
            background: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .hero-content h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 992px) {
            .section-title {
                font-size: 2.2rem;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content .slogan {
                font-size: 1.3rem;
            }

            .section-padding {
                padding: 80px 0;
            }

            .cta {
                padding: 100px 0;
            }

            .cta h2 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--light-color);
                flex-direction: column;
                padding: 20px 0;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                z-index: 999;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links li {
                margin: 10px 0;
                text-align: center;
            }

            .mobile-menu {
                display: block;
            }

            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-content .slogan {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .footer-bottom-content {
                flex-direction: column;
            }

            .legal-links a {
                margin: 0 10px;
            }

            .modal-content {
                padding: 30px;
            }
        }

        @media (max-width: 576px) {
            .hero {
                min-height: 600px;
            }

            .hero-content h1 {
                font-size: 1.8rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .btn {
                padding: 12px 25px;
                font-size: 14px;
            }

            .section-padding {
                padding: 60px 0;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .cta {
                padding: 80px 0;
            }

            .cta h2 {
                font-size: 1.8rem;
            }

            .modal-content {
                padding: 20px;
            }

            .footer-col {
                text-align: center;
            }

            .footer-col h4::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-links {
                justify-content: center;
            }
        }
    </style>
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
                <h1 class="animate">ECWA Education Levy Management System</h1>
                <p class="slogan animate delay-1">Making school payments easier and faster.</p>
                <div class="hero-buttons animate delay-3">
                    <a href="#login" class="btn">LOGIN</a>
                    <a href="#register" class="btn btn-primary">REGISTER</a>
                </div>
            </div>
        </div>
    </section>

    <?php
    session_start();
    if (isset($_SESSION['message'])) {
        echo "<p style='color: green;'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>


    <!-- Register Section -->
    <form id="registerForm" action="process_form.php" method="POST">
        <section id="register" class="section-padding">
            <div class="container">
                <h3 class="section-title animate">Register</h3>
                <form id="registerForm" action="process_form.php">

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
                    <input type="hidden" name="form_type" value="register" />
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
                        <!-- Forgot password link -->
                        <div style="text-align: right; margin-top: 5px;">
                            <a href="forgot_password.php"
                                style="font-size: 0.9rem; color: #007bff; text-decoration: none;">
                                Forgot Password?
                            </a>
                        </div>
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
    </form>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>(c) 2025 ECWA Education. All rights reserved</p>
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