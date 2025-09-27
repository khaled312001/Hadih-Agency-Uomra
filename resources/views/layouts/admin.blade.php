<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة تحكم الإدارة') - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            z-index: 1000;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            border-radius: 10px;
            margin: 5px 10px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(-5px);
        }
        
        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #fff;
            border-radius: 2px;
        }
        
        .main-content {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin-right: 250px;
            padding: 0;
        }
        
        .content-wrapper {
            padding: 30px;
        }
        
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        }
        
        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1rem;
        }
        
        .stats-icon.users { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stats-icon.orders { background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); }
        .stats-icon.revenue { background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); }
        .stats-icon.packages { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            color: #7f8c8d;
            font-size: 1rem;
            font-weight: 500;
        }
        
        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 2rem;
        }
        
        .chart-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .chart-title i {
            margin-left: 0.5rem;
            color: #667eea;
        }
        
        .table th {
            border: none;
            color: #2c3e50;
            font-weight: 600;
            padding: 1rem;
            background: #f8f9fa;
        }
        
        .table td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table tbody tr {
            border-bottom: 1px solid #f8f9fa;
        }
        
        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-in_progress { background: #d4edda; color: #155724; }
        .status-completed { background: #cce5ff; color: #004085; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        .metric-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }
        
        .metric-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        
        .metric-label {
            color: #7f8c8d;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .page-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        .sidebar-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            background: #667eea;
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: none;
        }
        
        .profile-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 15px;
            padding: 0.5rem 0;
            min-width: 200px;
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 1050;
            background-color: white;
            margin-top: 0.5rem;
        }
        
        .dropdown-menu.show {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
        
        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        
        .dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border-radius: 0;
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
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-right: 0;
            }
            
            .content-wrapper {
                padding: 15px;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .stats-card {
                margin-bottom: 1rem;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle d-md-none" type="button" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-4">
            <div class="text-center mb-4">
                <img src="/images/logo.jpg" alt="هدية" style="height: 40px; width: auto;" class="mb-3" onerror="this.style.display='none'">
                <h4 class="text-white mb-0">هدية</h4>
                <small class="text-white-50">لوحة تحكم الإدارة</small>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i>المستخدمين
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart me-2"></i>الطلبات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}">
                        <i class="fas fa-box me-2"></i>حزم العمرة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                        <i class="fas fa-comments me-2"></i>الرسائل
                        @if(auth()->user()->receivedMessages()->where('is_read', false)->count() > 0)
                            <span class="badge bg-danger ms-2">{{ auth()->user()->receivedMessages()->where('is_read', false)->count() }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog me-2"></i>الإعدادات
                    </a>
                </li>
            </ul>
            
            <hr class="text-white-50">
            
            <!-- Quick Actions -->
            <div class="px-3 mb-3">
                <h6 class="text-white-50 mb-3">إجراءات سريعة</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.orders.create') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-plus me-1"></i>طلب جديد
                    </a>
                    <a href="{{ route('admin.messages.create') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-envelope me-1"></i>رسالة جديدة
                    </a>
                </div>
            </div>
            
            <hr class="text-white-50">
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">
                        <i class="fas fa-home me-2"></i>الموقع الرئيسي
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Page Header -->
           
            <div class="page-header animate-on-scroll" style="min-height: 380px; padding-top: 2rem; padding-bottom: 2rem;">
                
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div>
                        <h2 class="mb-1 gradient-text">@yield('page-title', 'لوحة تحكم الإدارة')</h2>
                        <p class="text-muted mb-0">@yield('page-description', 'مرحباً بك في لوحة تحكم منصة هدية')</p>
                    <div style="position: relative; width: 330px; height: 110px; margin-top: 2rem;">
                    <br>        
                    <canvas id="animated-rect-canvas" width="1220" height="280" style="width:300%;height:200%;border-radius:18px;box-shadow:0 2px 16px rgba(102,126,234,0.12);background:linear-gradient(90deg,#e0eafc,#cfdef3);"></canvas>
                        <script>
                            (function() {
                                const canvas = document.getElementById('animated-rect-canvas');
                                if (!canvas) return;
                                const ctx = canvas.getContext('2d');
                                const w = canvas.width;
                                const h = canvas.height;

                                // Colors for gradient animation
                                const colors = [
                                    ['#667eea', '#764ba2'],
                                    ['#43cea2', '#185a9d'],
                                    ['#ffaf7b', '#d76d77'],
                                    ['#43e97b', '#38f9d7'],
                                    ['#fa709a', '#fee140']
                                ];
                                let colorIdx = 0;
                                let nextColorIdx = 1;
                                let colorT = 0;

                                // Rectangle properties
                                let rect = {
                                    x: 10,
                                    y: 20,
                                    w: 80,
                                    h: 40,
                                    vx: 2.2,
                                    vy: 1.5,
                                    radius: 18
                                };

                                function lerpColor(a, b, t) {
                                    // a, b: hex color strings
                                    // t: 0..1
                                    function hex2rgb(hex) {
                                        hex = hex.replace('#','');
                                        return [
                                            parseInt(hex.substring(0,2),16),
                                            parseInt(hex.substring(2,4),16),
                                            parseInt(hex.substring(4,6),16)
                                        ];
                                    }
                                    function rgb2hex(rgb) {
                                        return '#' + rgb.map(x => x.toString(16).padStart(2,'0')).join('');
                                    }
                                    const ar = hex2rgb(a), br = hex2rgb(b);
                                    const rr = ar.map((v,i) => Math.round(v + (br[i]-v)*t));
                                    return rgb2hex(rr);
                                }

                                function drawRoundedRect(ctx, x, y, w, h, r) {
                                    ctx.beginPath();
                                    ctx.moveTo(x+r, y);
                                    ctx.lineTo(x+w-r, y);
                                    ctx.quadraticCurveTo(x+w, y, x+w, y+r);
                                    ctx.lineTo(x+w, y+h-r);
                                    ctx.quadraticCurveTo(x+w, y+h, x+w-r, y+h);
                                    ctx.lineTo(x+r, y+h);
                                    ctx.quadraticCurveTo(x, y+h, x, y+h-r);
                                    ctx.lineTo(x, y+r);
                                    ctx.quadraticCurveTo(x, y, x+r, y);
                                    ctx.closePath();
                                }

                                function animate() {
                                    ctx.clearRect(0,0,w,h);

                                    // Animate gradient color
                                    colorT += 0.008;
                                    if (colorT > 1) {
                                        colorT = 0;
                                        colorIdx = nextColorIdx;
                                        nextColorIdx = (nextColorIdx+1)%colors.length;
                                    }
                                    const gradColor1 = lerpColor(colors[colorIdx][0], colors[nextColorIdx][0], colorT);
                                    const gradColor2 = lerpColor(colors[colorIdx][1], colors[nextColorIdx][1], colorT);

                                    // Draw animated background gradient
                                    let grad = ctx.createLinearGradient(0,0,w,h);
                                    grad.addColorStop(0, gradColor1);
                                    grad.addColorStop(1, gradColor2);
                                    ctx.fillStyle = grad;
                                    drawRoundedRect(ctx, 0, 0, w, h, 18);
                                    ctx.fill();

                                    // Draw moving rectangle with shadow and animated border
                                    ctx.save();
                                    ctx.shadowColor = 'rgba(102,126,234,0.18)';
                                    ctx.shadowBlur = 16;
                                    drawRoundedRect(ctx, rect.x, rect.y, rect.w, rect.h, rect.radius);
                                    ctx.fillStyle = 'rgba(255,255,255,0.85)';
                                    ctx.fill();
                                    ctx.restore();

                                    // Animated border
                                    ctx.save();
                                    ctx.lineWidth = 4;
                                    let borderGrad = ctx.createLinearGradient(rect.x, rect.y, rect.x+rect.w, rect.y+rect.h);
                                    borderGrad.addColorStop(0, gradColor2);
                                    borderGrad.addColorStop(1, gradColor1);
                                    ctx.strokeStyle = borderGrad;
                                    drawRoundedRect(ctx, rect.x, rect.y, rect.w, rect.h, rect.radius);
                                    ctx.stroke();
                                    ctx.restore();

                                    // Add some floating colored circles for extra effect
                                    for (let i=0; i<4; i++) {
                                        let t = Date.now()/900 + i*1.7;
                                        let cx = w/2 + Math.sin(t+i)*w/3.2;
                                        let cy = h/2 + Math.cos(t-i)*h/2.5;
                                        let r = 10 + 6*Math.sin(t*1.2+i);
                                        ctx.beginPath();
                                        ctx.arc(cx, cy, r, 0, 2*Math.PI);
                                        ctx.fillStyle = lerpColor(gradColor1, gradColor2, (Math.sin(t)+1)/2);
                                        ctx.globalAlpha = 0.18;
                                        ctx.fill();
                                        ctx.globalAlpha = 1;
                                    }

                                    // Move rectangle
                                    rect.x += rect.vx;
                                    rect.y += rect.vy;
                                    if (rect.x < 8 || rect.x+rect.w > w-8) rect.vx *= -1;
                                    if (rect.y < 8 || rect.y+rect.h > h-8) rect.vy *= -1;

                                    requestAnimationFrame(animate);
                                }
                                animate();
                            })();
                        </script>
                    </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center" style="margin-bottom: 7rem;">
                        @yield('page-actions')
                        <!-- Profile Dropdown -->
                        <div class="dropdown" style="position: relative;">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <div class="profile-avatar me-2">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="text-start">
                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                    <small class="text-muted">{{ auth()->user()->role == 'admin' ? 'مدير النظام' : 'مستخدم' }}</small>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                        <i class="fas fa-user-edit me-2"></i>الملف الشخصي
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                                        <i class="fas fa-cog me-2"></i>الإعدادات
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('welcome') }}" target="_blank">
                                        <i class="fas fa-home me-2"></i>الموقع الرئيسي
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show animate-on-scroll" role="alert">
                    <i class="fas fa-check-circle me-2 icon-animated"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate-on-scroll" role="alert">
                    <i class="fas fa-exclamation-circle me-2 icon-animated"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show animate-on-scroll" role="alert">
                    <i class="fas fa-exclamation-triangle me-2 icon-animated"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show animate-on-scroll" role="alert">
                    <i class="fas fa-info-circle me-2 icon-animated"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Content -->
            @yield('content')
        </div>
    </div>
    
    <!-- WhatsApp Floating Button -->
    <a href="#" id="whatsapp-float" class="whatsapp-float" 
       data-phone="966501234567" 
       data-message="مرحباً، أريد الاستفسار عن خدماتكم في تطبيق هدية للعمرة">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-tooltip">تواصل معنا عبر واتساب</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Initialize Bootstrap dropdowns manually
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for Bootstrap to load
            setTimeout(function() {
                // Initialize all dropdowns
                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });

                // Manual dropdown toggle for profile dropdown
                const profileDropdown = document.getElementById('profileDropdown');
                const profileDropdownMenu = profileDropdown ? profileDropdown.nextElementSibling : null;
                
                if (profileDropdown && profileDropdownMenu) {
                    // Remove any existing event listeners
                    profileDropdown.removeEventListener('click', handleDropdownClick);
                    
                    // Add click event listener
                    profileDropdown.addEventListener('click', handleDropdownClick);

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!profileDropdown.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                            closeDropdown();
                        }
                    });

                    // Handle escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closeDropdown();
                        }
                    });
                }

                function handleDropdownClick(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle dropdown
                    if (profileDropdownMenu.classList.contains('show')) {
                        closeDropdown();
                    } else {
                        openDropdown();
                    }
                }

                function openDropdown() {
                    profileDropdownMenu.classList.add('show');
                    profileDropdown.setAttribute('aria-expanded', 'true');
                    profileDropdown.classList.add('show');
                }

                function closeDropdown() {
                    profileDropdownMenu.classList.remove('show');
                    profileDropdown.setAttribute('aria-expanded', 'false');
                    profileDropdown.classList.remove('show');
                }
            }, 100);
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Add loading states to form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
        });

        // Add hover effects to table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(102, 126, 234, 0.05)';
                this.style.transform = 'scale(1.01)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = 'scale(1)';
            });
        });

        // Add click effects to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
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
                    background: rgba(255, 255, 255, 0.3);
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
    </script>
    
    @yield('scripts')
</body>
</html>