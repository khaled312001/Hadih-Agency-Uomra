<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'هدية - تطبيق العمرة الإلكتروني')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        body { background-color: #f8f9fa; }
        .navbar { background: rgba(255, 255, 255, 0.95) !important; backdrop-filter: blur(10px); box-shadow: 0 2px 20px rgba(0,0,0,0.1); }
        .card { border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
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
                        <a class="nav-link" href="/">الرئيسية</a>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-1"></i>الإدارة
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.packages.index') }}">
                                        <i class="fas fa-box me-2"></i>إدارة الحزم
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>إدارة الطلبات
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-users me-2"></i>إدارة المستخدمين
                                    </a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i>طلباتي
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('messages.index') }}">
                                    <i class="fas fa-envelope me-1"></i>الرسائل
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <div class="d-flex align-items-center">
                    
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-sign-in-alt me-1"></i>تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i>إنشاء حساب
                        </a>
                    @else
                        <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>
                                <span>{{ auth()->user()->name }}</span>
                                @if(auth()->user()->role === 'admin')
                                    <i class="fas fa-crown ms-2 text-warning" title="مدير"></i>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-header">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle me-2 text-primary"></i>
                                        <div>
                                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                                            <small class="text-muted">{{ auth()->user()->email }}</small>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                
                                @if(auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-crown me-2 text-warning"></i>لوحة الإدارة
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.packages.index') }}">
                                        <i class="fas fa-box me-2"></i>إدارة الحزم
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>إدارة الطلبات
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-users me-2"></i>إدارة المستخدمين
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="fas fa-home me-2"></i>الصفحة الرئيسية
                                    </a></li>
                                  
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>طلباتي
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('messages.index') }}">
                                        <i class="fas fa-envelope me-2"></i>الرسائل
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user-edit me-2"></i>الملف الشخصي
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger w-100 text-start">
                                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>
                        <img src="/images/logo.jpg" alt="هدية" style="height: 30px; width: auto;" class="me-2" onerror="this.style.display='none'">
                        هدية
                    </h5>
                    <p class="mb-0">تطبيق العمرة الإلكتروني</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} هدية. جميع الحقوق محفوظة.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="#" id="whatsapp-float" class="whatsapp-float" 
       data-phone="966501234567" 
       data-message="مرحباً، أريد الاستفسار عن خدماتكم في تطبيق هدية للعمرة">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-tooltip">تواصل معنا عبر واتساب</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>