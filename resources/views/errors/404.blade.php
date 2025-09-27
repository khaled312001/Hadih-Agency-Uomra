<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة غير موجودة - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem;
        }
        
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatAround 20s infinite linear;
        }
        
        .floating-element:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            width: 80px;
            height: 80px;
            top: 20%;
            right: 15%;
            animation-delay: -5s;
        }
        
        .floating-element:nth-child(3) {
            width: 120px;
            height: 120px;
            bottom: 20%;
            left: 20%;
            animation-delay: -10s;
        }
        
        .floating-element:nth-child(4) {
            width: 60px;
            height: 60px;
            bottom: 30%;
            right: 25%;
            animation-delay: -15s;
        }
        
        @keyframes floatAround {
            0% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-30px) rotate(90deg); }
            50% { transform: translateY(15px) rotate(180deg); }
            75% { transform: translateY(-20px) rotate(270deg); }
            100% { transform: translateY(0px) rotate(360deg); }
        }
        
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
            position: relative;
            z-index: 2;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-icon {
            font-size: 8rem;
            color: #667eea;
            margin-bottom: 2rem;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
        
        .error-title {
            font-size: 3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease-out 0.3s both;
        }
        
        .error-subtitle {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.5s both;
        }
        
        .error-description {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 3rem;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.7s both;
        }
        
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
        
        .btn-home {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 1rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 1s ease-out 0.9s both;
        }
        
        .btn-home::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-home:hover::before {
            left: 100%;
        }
        
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .btn-home:active {
            transform: translateY(-1px);
        }
        
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.1s both;
        }
        
        .search-suggestions {
            margin-top: 2rem;
            animation: fadeInUp 1s ease-out 1.1s both;
        }
        
        .suggestion-item {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 0.75rem 1.5rem;
            margin: 0.5rem;
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .suggestion-item:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
            color: #667eea;
            text-decoration: none;
        }
        
        .pulse {
            animation: pulse 2s infinite;
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
        
        @media (max-width: 768px) {
            .error-card {
                padding: 2rem;
                margin: 1rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
            
            .error-subtitle {
                font-size: 1.2rem;
            }
            
            .error-icon {
                font-size: 6rem;
            }
            
            .btn-home {
                padding: 0.875rem 2rem;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="error-container">
        <div class="error-card">
            <img src="{{ asset('images/logo.jpg') }}" alt="هدية" class="logo" onerror="this.style.display='none'">
            
            <div class="error-icon pulse">
                <i class="fas fa-search"></i>
            </div>
            
            <h1 class="error-title">404</h1>
            <h2 class="error-subtitle">الصفحة غير موجودة</h2>
            
            <p class="error-description">
                عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.<br>
                يرجى التحقق من الرابط أو العودة إلى الصفحة الرئيسية.
            </p>
            
            <a href="{{ route('welcome') }}" class="btn-home">
                <i class="fas fa-home"></i>
                الذهاب للصفحة الرئيسية
            </a>
            
            <div class="search-suggestions">
                <p class="text-muted mb-3">ربما تبحث عن:</p>
                <a href="{{ route('welcome') }}" class="suggestion-item">
                    <i class="fas fa-home me-2"></i>الصفحة الرئيسية
                </a>
                <a href="{{ route('orders.index') }}" class="suggestion-item">
                    <i class="fas fa-shopping-cart me-2"></i>طلباتي
                </a>
                <a href="{{ route('orders.create') }}" class="suggestion-item">
                    <i class="fas fa-plus me-2"></i>طلب جديد
                </a>
                <a href="{{ route('profile') }}" class="suggestion-item">
                    <i class="fas fa-user me-2"></i>الملف الشخصي
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to floating elements
            const floatingElements = document.querySelectorAll('.floating-element');
            floatingElements.forEach(element => {
                element.addEventListener('click', function() {
                    this.style.animation = 'none';
                    this.offsetHeight; // Trigger reflow
                    this.style.animation = 'floatAround 20s infinite linear';
                });
            });
            
            // Add hover effect to error card
            const errorCard = document.querySelector('.error-card');
            errorCard.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            errorCard.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
            
            // Add typing effect to error title
            const errorTitle = document.querySelector('.error-title');
            const originalText = errorTitle.textContent;
            errorTitle.textContent = '';
            
            let i = 0;
            const typeWriter = () => {
                if (i < originalText.length) {
                    errorTitle.textContent += originalText.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                }
            };
            
            setTimeout(typeWriter, 1000);
        });
    </script>
</body>
</html>
