<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هدية - تطبيق العمرة الإلكتروني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #1e3a5f;
            --accent-color: #4a90e2;
            --success-color: #28a745;
            --gold-color: #ffd700;
            --green-color: #2ecc71;
        }

        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .hero-section {
            background: transparent;
            color: white;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            min-width: 100%;
            min-height: 100%;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: transparent;
            z-index: -1;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="stars" patternUnits="userSpaceOnUse" width="50" height="50"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.2)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23stars)"/></svg>');
            animation: twinkle 3s ease-in-out infinite alternate;
            z-index: 0;
        }

        .video-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .video-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" patternUnits="userSpaceOnUse" width="20" height="20"><circle cx="10" cy="10" r="1" fill="rgba(102,126,234,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23dots)"/></svg>');
            opacity: 0.5;
        }

        .video-container {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            background: #000;
            transition: all 0.3s ease;
        }

        .video-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.25);
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            overflow: hidden;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .video-container:hover .video-overlay {
            opacity: 1;
        }

        .play-button {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #667eea;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .play-button:hover {
            background: white;
            transform: scale(1.1);
            color: #764ba2;
        }

        .video-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            text-align: center;
        }

        .video-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Ensure content appears above video */
        .hero-section .container {
            position: relative;
            z-index: 10;
        }

        .hero-section .text-center {
            position: relative;
            z-index: 10;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0;
                min-height: 80vh;
            }
            
            .app-title {
                font-size: 3rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
        }

        @keyframes twinkle {
            0% { opacity: 0.3; }
            100% { opacity: 0.7; }
        }

        .logo {
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6), 0 0 30px rgba(0,0,0,0.3);
            position: relative;
            z-index: 10;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .logo i {
            font-size: 70px;
            color: var(--primary-color);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .app-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.8), 0 0 20px rgba(0,0,0,0.5);
            position: relative;
            z-index: 10;
            color: white;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 30px;
            opacity: 1;
            position: relative;
            z-index: 10;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 0 0 15px rgba(0,0,0,0.5);
            color: white;
            font-weight: 500;
        }

        .package-card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .package-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--gold-color));
        }

        .package-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            border-color: var(--accent-color);
        }

        .btn-custom {
            padding: 18px 45px;
            font-size: 1.3rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s ease;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            color: white;
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.3);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(44, 90, 160, 0.4);
            color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: white;
            font-size: 2rem;
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            margin: 20px 0;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -10px;
            right: 20px;
            font-size: 4rem;
            color: var(--accent-color);
            opacity: 0.3;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin: 10px 0;
            backdrop-filter: blur(10px);
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 5;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 20px;
            height: 20px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 15px;
            height: 15px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 25px;
            height: 25px;
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .stats-counter {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
        }

        .parallax-section {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .gradient-text {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Modern Package Cards Styles */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .bg-gradient-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .package-card-modern {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateY(0);
        }

        .package-card-modern:hover {
            transform: translateY(-20px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .package-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .package-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .package-image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .package-card-modern:hover .package-image {
            transform: scale(1.1);
        }

        .package-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .package-card-modern:hover .package-overlay {
            opacity: 1;
        }

        .package-badge {
            background: rgba(255, 255, 255, 0.9);
            color: #667eea;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .package-card-modern:hover .package-badge {
            transform: translateY(0);
        }

        .package-content {
            padding: 25px;
            position: relative;
        }

        .package-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .package-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .package-subtitle {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin: 0;
        }

        .package-price {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
        }

        .price-amount {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }

        .price-currency {
            font-size: 1rem;
            opacity: 0.9;
        }

        .package-duration {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #7f8c8d;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .package-description {
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .package-features {
            margin-bottom: 25px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        .feature-item i {
            color: #27ae60;
            font-size: 0.8rem;
        }

        .package-actions {
            display: flex;
            gap: 10px;
            flex-direction: column;
        }

        .btn-package-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-package-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-package-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-package-primary:hover::before {
            left: 100%;
        }

        .btn-package-secondary {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-package-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .package-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .package-card-modern:hover .package-glow {
            opacity: 1;
        }

        .empty-packages {
            padding: 60px 20px;
        }

        .empty-packages i {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 20px;
        }

        /* Animation delays for staggered effect */
        .package-card-modern[data-delay="0"] { animation-delay: 0ms; }
        .package-card-modern[data-delay="100"] { animation-delay: 100ms; }
        .package-card-modern[data-delay="200"] { animation-delay: 200ms; }
        .package-card-modern[data-delay="300"] { animation-delay: 300ms; }
        .package-card-modern[data-delay="400"] { animation-delay: 400ms; }
        .package-card-modern[data-delay="500"] { animation-delay: 500ms; }

        /* User Dropdown Styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 15px;
            padding: 10px 0;
            margin-top: 10px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .dropdown-item {
            padding: 12px 20px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(-5px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 8px 0;
            border-color: rgba(0, 0, 0, 0.1);
        }

        /* Enhanced Button Styling */
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 90, 160, 0.3);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 90, 160, 0.3);
        }

        .btn-warning {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background: linear-gradient(45deg, #e67e22, #d35400);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230, 126, 34, 0.3);
            color: white;
        }

        .btn-outline-danger {
            border: 2px solid #e74c3c;
            color: #e74c3c;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .package-card-modern {
                margin-bottom: 30px;
            }
            
            .package-content {
                padding: 20px;
            }
            
            .package-title {
                font-size: 1.3rem;
            }
            
            .price-amount {
                font-size: 1.8rem;
            }
            
            .package-actions {
                flex-direction: column;
            }

            .dropdown-menu {
                margin-top: 5px;
                border-radius: 10px;
            }

            .dropdown-item {
                padding: 10px 15px;
                margin: 1px 5px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top animate-on-scroll">
        <div class="container">
                    <a class="navbar-brand fw-bold text-primary" href="/">
                        <img src="/images/logo.jpg" alt="هدية" style="height: 40px; width: auto;" class="me-2" onerror="this.style.display='none'">
                        هدية
                    </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#packages">حزم العمرة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">المميزات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">اتصل بنا</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @guest
                        <!-- Guest User Navigation -->
                        <a href="{{ route('orders.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-1"></i>طلب عمرة
                        </a>
                        <a href="/login" class="btn btn-outline-primary">تسجيل الدخول</a>
                    @else
                        @if(auth()->user()->role !== 'admin')
                            <!-- Regular User Navigation -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle me-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>
                                    {{ auth()->user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                 
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>طلباتي
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user-edit me-2"></i>الملف الشخصي
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>طلب عمرة جديد
                            </a>
                        @else
                            <!-- Admin User - Redirect to Admin Dashboard -->
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning me-2">
                                <i class="fas fa-cog me-1"></i>لوحة الإدارة
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-sign-out-alt me-1"></i>تسجيل الخروج
                                </button>
                            </form>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Dynamic Sections -->
    @foreach($sections as $section)
        @if($section->type === 'hero')
            <!-- Hero Section -->
            <section id="home" class="hero-section">
                <!-- Video Background -->
                @if($section->video_url)
                    <iframe 
                        class="hero-video-background" 
                        src="{{ $section->video_url }}?autoplay=1&mute=1&loop=1&playlist={{ last(explode('/', $section->video_url)) }}&controls=0&showinfo=0&rel=0&modestbranding=1&iv_load_policy=3&fs=0&disablekb=1" 
                        title="{{ $section->title_ar }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                        style="border: none;">
                    </iframe>
                @endif
                
                <div class="floating-elements">
                    <div class="floating-element"></div>
                    <div class="floating-element"></div>
                    <div class="floating-element"></div>
                    <div class="floating-element"></div>
                    <div class="floating-element"></div>
                </div>
                <div class="container">
                    <div class="text-center">
                        <div class="logo animate-on-scroll page-load-animation">
                            <img src="/images/logo.jpg" alt="هدية" style="height: 120px; width: auto;" onerror="this.style.display='none'" class="icon-pulse">
                        </div>
                        <h1 class="app-title animate-on-scroll page-load-animation-delay-1 typing-effect">
                            {{ app()->getLocale() == 'ar' ? $section->title_ar : $section->title_en }}
                        </h1>
                        <p class="hero-subtitle animate-on-scroll page-load-animation-delay-2">
                            {{ app()->getLocale() == 'ar' ? $section->subtitle_ar : $section->subtitle_en }}
                        </p>
                        <div class="mt-5 animate-on-scroll page-load-animation-delay-3">
                            @if($section->button_text_ar)
                                <a href="{{ $section->button_link ?? route('orders.create') }}" class="btn btn-primary-custom btn-custom me-3 hover-lift">
                                    <i class="fas fa-shopping-cart me-2 icon-animated"></i>
                                    {{ app()->getLocale() == 'ar' ? $section->button_text_ar : $section->button_text_en }}
                                </a>
                            @endif
                            @guest
                                <a href="/login" class="btn btn-outline-light btn-custom hover-lift">
                                    <i class="fas fa-sign-in-alt me-2 icon-animated"></i>تسجيل الدخول
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </section>

        @elseif($section->type === 'about')
            <!-- About Section -->
            <section id="about" class="py-5 bg-white">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-5">
                            <h2 class="section-title text-end animate-on-scroll">
                                {{ app()->getLocale() == 'ar' ? $section->title_ar : $section->title_en }}
                            </h2>
                            <p class="lead text-muted mb-4 animate-on-scroll">
                                {{ app()->getLocale() == 'ar' ? $section->subtitle_ar : $section->subtitle_en }}
                            </p>
                            @if($section->button_text_ar)
                            <a href="{{ $section->button_link }}" class="btn btn-primary-custom btn-custom hover-lift">
                                {{ app()->getLocale() == 'ar' ? $section->button_text_ar : $section->button_text_en }}
                            </a>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center animate-on-scroll">
                                <img src="{{ $section->image ?? 'https://omra.site/assets/images/3.png' }}" 
                                     alt="{{ $section->title_ar }}" class="img-fluid rounded-3 shadow-lg hover-scale">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        @elseif($section->type === 'stats')
            <!-- Stats Section -->
            <section class="py-5 bg-light">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="section-title animate-on-scroll">
                                {{ app()->getLocale() == 'ar' ? $section->title_ar : $section->title_en }}
                            </h2>
                            <p class="text-muted animate-on-scroll">
                                {{ app()->getLocale() == 'ar' ? $section->subtitle_ar : $section->subtitle_en }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="text-center p-4 animate-on-scroll hover-lift">
                                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 icon-animated" style="width: 80px; height: 80px;">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <span class="stats-counter">{{ $stats['total_users'] }}</span>
                                <p class="text-muted">مستخدم مسجل</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="text-center p-4 animate-on-scroll hover-lift">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 icon-animated" style="width: 80px; height: 80px;">
                                    <i class="fas fa-shopping-cart fa-2x"></i>
                                </div>
                                <span class="stats-counter">{{ $stats['total_orders'] }}</span>
                                <p class="text-muted">طلب عمرة</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="text-center p-4 animate-on-scroll hover-lift">
                                <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 icon-animated" style="width: 80px; height: 80px;">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <span class="stats-counter">{{ $stats['completed_orders'] }}</span>
                                <p class="text-muted">عمرة مكتملة</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="text-center p-4 animate-on-scroll hover-lift">
                                <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 icon-animated" style="width: 80px; height: 80px;">
                                    <i class="fas fa-star fa-2x"></i>
                                </div>
                                <span class="stats-counter">4.9</span>
                                <p class="text-muted">تقييم المستخدمين</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        @elseif($section->type === 'features')
            <!-- Features Section -->
            <section id="features" class="py-5 bg-white">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="section-title animate-on-scroll">
                                {{ app()->getLocale() == 'ar' ? $section->title_ar : $section->title_en }}
                            </h2>
                            <p class="text-muted animate-on-scroll">
                                {{ app()->getLocale() == 'ar' ? $section->subtitle_ar : $section->subtitle_en }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        @php 
                            $features = app()->getLocale() == 'ar' ? ($section->content_ar ?? []) : ($section->content_en ?? []);
                        @endphp
                        @foreach($features as $feature)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card animate-on-scroll">
                                <div class="feature-icon icon-animated">
                                    <i class="{{ $feature['icon'] ?? 'fas fa-check' }}"></i>
                                </div>
                                <h5 class="mb-3">{{ $feature['title'] ?? '' }}</h5>
                                <p class="text-muted">{{ $feature['text'] ?? '' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    <!-- Umrah Packages Section (Keep static as it has its own logic) -->
    <section id="packages" class="py-5 bg-gradient-primary">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="section-title text-white animate-on-scroll">حزم العمرة المتاحة</h2>
                    <p class="text-white-50 animate-on-scroll">اختر الحزمة المناسبة لك وابدأ رحلتك الروحية</p>
                </div>
            </div>
            
            @if($packages->count() > 0)
                <div class="row justify-content-center">
                    @foreach($packages as $index => $package)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="package-card-modern animate-on-scroll" data-delay="{{ $index * 100 }}">
                                <div class="package-image-container">
                                    @if($package->image && !empty($package->image) && file_exists(public_path($package->image)))
                                        <img src="{{ asset($package->image) }}" alt="{{ $package->name_ar }}" class="package-image">
                                    @else
                                        <div class="package-image-placeholder">
                                            <i class="fas fa-kaaba"></i>
                                        </div>
                                    @endif
                                    <div class="package-overlay">
                                        <div class="package-badge">
                                            <i class="fas fa-kaaba"></i>
                                            <span>مميز</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="package-content">
                                    <div class="package-header">
                                        <h4 class="package-title">{{ $package->name_ar }}</h4>
                                        @if($package->name_en)
                                            <p class="package-subtitle">{{ $package->name_en }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="package-price">
                                        <span class="price-amount">{{ number_format($package->price) }}</span>
                                        <span class="price-currency">{{ $package->currency }}</span>
                                    </div>
                                    
                                    @if($package->duration)
                                        <div class="package-duration">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $package->duration }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($package->description_ar)
                                        <p class="package-description">{{ Str::limit($package->description_ar, 100) }}</p>
                                    @endif
                                    
                                    <div class="package-features">
                                        <div class="feature-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>توثيق بالفيديو</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>مزود خدمة مؤهل</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span>متابعة مستمرة</span>
                                        </div>
                                    </div>
                                    
                                    <div class="package-actions">
                                        <a href="{{ route('orders.create') }}?package={{ $package->id }}" class="btn-package-primary">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>اطلب الآن</span>
                                        </a>
                                        
                                    
                                    </div>
                                </div>
                                
                                <div class="package-glow"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-packages">
                        <i class="fas fa-box-open"></i>
                        <h4 class="text-white">لا توجد حزم متاحة حالياً</h4>
                        <p class="text-white-50">سيتم إضافة حزم جديدة قريباً</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

   
    <!-- Testimonials Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="section-title animate-on-scroll">آراء عملائنا</h2>
                    <p class="text-muted animate-on-scroll">ماذا يقول عملاؤنا عن تجربتهم مع هدية</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="testimonial-card animate-on-scroll hover-lift">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                 alt="عميل" class="rounded-circle me-3 hover-scale" width="50" height="50">
                            <div>
                                <h6 class="mb-0">أحمد محمد</h6>
                                <small class="text-muted">من الرياض</small>
                            </div>
                        </div>
                        <p class="text-muted">خدمة ممتازة ومتخصصة، تم توثيق عمرة والدي بالفيديو وأرسلوا لي التسجيلات. أنصح الجميع بهذه الخدمة.</p>
                        <div class="text-warning">
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="testimonial-card animate-on-scroll hover-lift">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                 alt="فاطمة أحمد - عميلة" class="rounded-circle me-3 hover-scale" width="50" height="50">
                            <div>
                                <h6 class="mb-0">فاطمة أحمد</h6>
                                <small class="text-muted">من جدة</small>
                            </div>
                        </div>
                        <p class="text-muted">مزودو الخدمة مؤهلون جداً ومتخصصون، تم أداء عمرة والدتي بأعلى مستوى من الدقة والاحترافية.</p>
                        <div class="text-warning">
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="testimonial-card animate-on-scroll hover-lift">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                 alt="عميل" class="rounded-circle me-3 hover-scale" width="50" height="50">
                            <div>
                                <h6 class="mb-0">محمد علي</h6>
                                <small class="text-muted">من الدمام</small>
                            </div>
                        </div>
                        <p class="text-muted">تطبيق سهل الاستخدام وخدمة عملاء ممتازة، تم متابعة طلبي من البداية للنهاية مع تحديثات مستمرة.</p>
                        <div class="text-warning">
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                            <i class="fas fa-star icon-animated"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="section-title text-white">اتصل بنا</h2>
                    <p class="text-white-50">نحن هنا لمساعدتك في أي وقت</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="contact-info text-center">
                        <div class="feature-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5 class="mb-3">الهاتف</h5>
                        <p class="mb-0">0125401111</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="contact-info text-center">
                        <div class="feature-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h5 class="mb-3">الجوال</h5>
                        <p class="mb-0">966508508111</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="contact-info text-center">
                        <div class="feature-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="mb-3">البريد الإلكتروني</h5>
                        <p class="mb-0">info@hadiyah.org.sa</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-info mb-3">
                        <i class="fas fa-kaaba me-2"></i>هدية
                    </h5>
                    <p class="text-white-50">تطبيق العمرة الإلكتروني الذي يربط بين المستفيدين ومزودي الخدمة المؤهلين شرعياً من طلبة العلم وحَمَلة كتاب الله من سكان مكة المكرمة.</p>
                    <div class="mt-3">
                        <a href="https://www.facebook.com/hajigift.org" target="_blank" class="text-white me-3">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/hajigift/" target="_blank" class="text-white me-3">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="https://x.com/hajigift" target="_blank" class="text-white me-3">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/%D8%AC%D9%85%D8%B9%D9%8A%D8%A9-%D9%87%D8%AF%D9%8A%D8%A9-%D8%A7%D9%84%D8%AD%D8%A7%D8%AC-%D9%88%D8%A7%D9%84%D9%85%D8%B9%D8%AA%D9%85%D8%B1-%D8%A7%D9%84%D8%AE%D9%8A%D8%B1%D9%8A%D8%A9/" target="_blank" class="text-white me-3">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                        <a href="https://www.youtube.com/user/hajigift" target="_blank" class="text-white me-3">
                            <i class="fab fa-youtube fa-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 mb-4">
                    <h6 class="text-info mb-3">روابط سريعة</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="text-white-50 text-decoration-none">الرئيسية</a></li>
                        <li class="mb-2"><a href="#about" class="text-white-50 text-decoration-none">من نحن</a></li>
                        <li class="mb-2"><a href="#packages" class="text-white-50 text-decoration-none">حزم العمرة</a></li>
                        <li class="mb-2"><a href="#features" class="text-white-50 text-decoration-none">المميزات</a></li>
                        <li class="mb-2"><a href="#contact" class="text-white-50 text-decoration-none">اتصل بنا</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="text-info mb-3">معلومات الاتصال</h6>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> 0125401111</li>
                        <li class="mb-2"><i class="fas fa-mobile-alt me-2"></i> 966508508111</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@hadiyah.org.sa</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> report@hadiyah.org.sa</li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="text-info mb-3">جمعية هدية الحاج والمعتمر</h6>
                    <p class="text-white-50 small">أول جمعية سعودية متخصصة في خدمة ضيوف الرحمن وتقديم الخدمات المتنوعة لهم</p>
                    <div class="mt-3">
                        @guest
                            <a href="{{ route('orders.create') }}" class="btn btn-outline-light btn-sm me-2">طلب عمرة الآن</a>
                            <a href="/login" class="btn btn-light btn-sm">تسجيل الدخول</a>
                        @else
                            @if(auth()->user()->role !== 'admin')
                                <a href="{{ route('orders.create') }}" class="btn btn-outline-light btn-sm me-2">طلب عمرة جديد</a>
                                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">لوحة التحكم</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm me-2">لوحة الإدارة</a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-white-50">&copy; {{ date('Y') }} هدية - جمعية هدية الحاج والمعتمر الخيرية. جميع الحقوق محفوظة.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-white-50">
                        <a href="#" class="text-white-50 text-decoration-none me-3">شروط الاستخدام</a>
                        <a href="#" class="text-white-50 text-decoration-none">سياسة الخصوصية</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    <script>
        // Enhanced smooth scrolling with offset for fixed navbar
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Enhanced counter animation with easing
        function animateCounters() {
            const counters = document.querySelectorAll('.stats-counter');
            counters.forEach(counter => {
                const target = parseFloat(counter.textContent.replace(/,/g, ''));
                const duration = 2000;
                const startTime = performance.now();
                
                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    // Easing function for smooth animation
                    const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                    const current = target * easeOutQuart;
                    
                    if (target % 1 === 0) {
                        counter.textContent = Math.floor(current).toLocaleString();
                    } else {
                        counter.textContent = current.toFixed(1);
                    }
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                }
                
                requestAnimationFrame(updateCounter);
            });
        }

        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.bg-light');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Enhanced navbar scroll effect
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Hide/show navbar on scroll
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });

        // Add loading animation to buttons
        document.querySelectorAll('a[href="/register"]').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!this.classList.contains('loading')) {
                    this.classList.add('loading');
                    this.innerHTML = '<span class="loading-dots">جاري التحميل</span>';
                }
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                const rate = scrolled * -0.5;
                heroSection.style.transform = `translateY(${rate}px)`;
            }
        });

        // Add typing effect to title
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';
            element.style.borderRight = '2px solid #4a90e2';
            
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                } else {
                    setTimeout(() => {
                        element.style.borderRight = 'none';
                    }, 1000);
                }
            }
            
            type();
        }

        // Initialize typing effect when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const titleElement = document.querySelector('.typing-effect');
            if (titleElement) {
                const originalText = titleElement.textContent;
                setTimeout(() => {
                    typeWriter(titleElement, originalText, 150);
                }, 1000);
            }
        });

        // Add hover effects to social media links
        document.querySelectorAll('footer a[target="_blank"]').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.1)';
                this.style.transition = 'all 0.3s ease';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add click animation to cards
        document.querySelectorAll('.card, .feature-card, .testimonial-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(74, 144, 226, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    z-index: 1000;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Package details modal functionality
        function showPackageDetails(packageId) {
            // This would typically show a modal with more details
            // For now, we'll just show an alert
            alert('تفاصيل الحزمة رقم: ' + packageId + '\n\nسيتم إضافة نافذة تفاصيل كاملة قريباً');
        }

        // Enhanced package card animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add staggered animation to package cards
            const packageCards = document.querySelectorAll('.package-card-modern');
            
            packageCards.forEach((card, index) => {
                // Add initial state
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                
                // Animate on scroll
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                                entry.target.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                            }, index * 100);
                        }
                    });
                }, { threshold: 0.1 });
                
                observer.observe(card);
            });

            // Add hover sound effect (optional)
            packageCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    // Add subtle glow effect
                    this.style.filter = 'brightness(1.05)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.filter = 'brightness(1)';
                });
            });
        });
    </script>
</body>
</html>