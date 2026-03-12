<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'هدية - تطبيق العمرة الإلكتروني')</title>
    <meta name="description" content="منصة هدية للعمرة - احجز رحلتك الروحية بكل سهولة">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(255,255,255,.96) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 2px 24px rgba(0,0,0,.08);
            padding: 0.6rem 0;
            transition: all .3s ease;
            border-bottom: 1px solid rgba(0,0,0,.04);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 800;
            font-size: 1.25rem;
            color: #1e293b !important;
            text-decoration: none;
        }
        .navbar-brand img {
            height: 38px;
            width: auto;
            border-radius: 10px;
        }
        .navbar-brand .brand-text {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-link {
            font-weight: 600;
            font-size: 0.9rem;
            color: #475569 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all .2s ease;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .nav-link:hover { color: #667eea !important; background: rgba(102,126,234,.07); }
        .nav-link.active { color: #667eea !important; background: rgba(102,126,234,.1); }
        .navbar-toggler {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.4rem 0.65rem;
            transition: all .2s;
        }
        .navbar-toggler:focus { box-shadow: 0 0 0 3px rgba(102,126,234,.2); }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23667eea' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }
        .navbar .dropdown-toggle::after { margin-right: 0.35rem; }

        /* Auth buttons */
        .btn-nav-login {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
            border-radius: 10px;
            padding: 0.4rem 1.1rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }
        .btn-nav-login:hover { background: rgba(102,126,234,.08); color: #667eea; }
        .btn-nav-register {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.4rem 1.1rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            box-shadow: 0 3px 12px rgba(102,126,234,.35);
        }
        .btn-nav-register:hover { filter: brightness(1.1); transform: translateY(-1px); color: #fff; }

        /* User dropdown trigger */
        .user-avatar-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.35rem 0.75rem;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            color: inherit;
            font-size: 0.875rem;
        }
        .user-avatar-btn:hover { border-color: #667eea; background: #f0f4ff; color: inherit; }
        .user-avatar-circle {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .user-name { font-weight: 600; color: #1e293b; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* ===== FOOTER ===== */
        .site-footer {
            background: #0f172a;
            color: rgba(255,255,255,.75);
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }
        .footer-brand { font-size: 1.3rem; font-weight: 800; color: #fff; margin-bottom: .5rem; }
        .footer-desc { font-size: 0.875rem; color: rgba(255,255,255,.5); line-height: 1.7; }
        .footer-title { font-weight: 700; color: #fff; margin-bottom: .75rem; font-size: 0.95rem; }
        .footer-link { color: rgba(255,255,255,.55); text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: .35rem; transition: color .2s; padding: 0.15rem 0; }
        .footer-link:hover { color: #a78bfa; }
        .footer-divider { border-color: rgba(255,255,255,.08); margin: 1.5rem 0; }
        .footer-copy { font-size: 0.82rem; color: rgba(255,255,255,.35); }
        .footer-social a {
            width: 36px; height: 36px;
            background: rgba(255,255,255,.07);
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            transition: all .2s;
            font-size: 0.9rem;
        }
        .footer-social a:hover { background: #667eea; color: #fff; transform: translateY(-2px); }

        /* ===== MAIN ===== */
        main { min-height: calc(100vh - 200px); }

        /* Responsive */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(0,0,0,.12);
                padding: 1rem;
                margin-top: 0.5rem;
                border: 1px solid #f1f5f9;
            }
            .navbar-nav { gap: 0.25rem; }
            .d-flex.align-items-center { margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #f1f5f9; flex-direction: column; align-items: stretch !important; gap: 0.5rem !important; }
            .btn-nav-login, .btn-nav-register { justify-content: center; }
            .user-avatar-btn { justify-content: center; }
            .dropdown-menu { position: static !important; transform: none !important; box-shadow: none; border: 1px solid #f1f5f9; }
        }
        @media (max-width: 576px) {
            .site-footer { padding: 2rem 0 1rem; }
            .site-footer .row > div + div { margin-top: 1.5rem; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="هدية" onerror="this.style.display='none'">
                <span class="brand-text">هدية</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="القائمة">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nav Links -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="fas fa-home"></i> الرئيسية
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('admin*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-shield-alt"></i> الإدارة
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-chart-line text-primary"></i> لوحة التحكم
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.packages.index') }}">
                                        <i class="fas fa-box-open text-info"></i> الحزم
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                        <i class="fas fa-shopping-cart text-success"></i> الطلبات
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-users text-warning"></i> المستخدمون
                                    </a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <i class="fas fa-tachometer-alt"></i> لوحتي
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-cart"></i> طلباتي
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                                    <i class="fas fa-envelope"></i> الرسائل
                                    @auth
                                        @php $unread = auth()->user()->receivedMessages()->where('is_read',false)->count(); @endphp
                                        @if($unread > 0)
                                            <span class="badge bg-danger" style="font-size:.65rem;padding:.2em .5em;">{{ $unread }}</span>
                                        @endif
                                    @endauth
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Right side -->
                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn-nav-login">
                            <i class="fas fa-sign-in-alt"></i> دخول
                        </a>
                        <a href="{{ route('register') }}" class="btn-nav-register">
                            <i class="fas fa-user-plus"></i> حساب جديد
                        </a>
                    @else
                        <div class="dropdown">
                            <a class="user-avatar-btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration:none;">
                                <div class="user-avatar-circle">
                                    <i class="fas fa-user" style="font-size:.8rem;"></i>
                                </div>
                                <span class="user-name d-none d-sm-block">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->role === 'admin')
                                    <i class="fas fa-crown text-warning" style="font-size:.75rem;" title="مدير"></i>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-1">
                                <li class="px-3 py-2">
                                    <div class="fw-bold" style="font-size:.9rem;color:#1e293b;">{{ auth()->user()->name }}</div>
                                    <div style="font-size:.78rem;color:#94a3b8;">{{ auth()->user()->email }}</div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-chart-line text-primary"></i> لوحة الإدارة
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                                        <i class="fas fa-user-edit"></i> الملف الشخصي
                                    </a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="fas fa-tachometer-alt text-primary"></i> لوحتي
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-shopping-cart text-success"></i> طلباتي
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('messages.index') }}">
                                        <i class="fas fa-envelope text-info"></i> الرسائل
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user-edit"></i> الملف الشخصي
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger w-100 border-0 bg-transparent text-start">
                                            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
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

    <!-- ===== MAIN CONTENT ===== -->
    <main style="padding-top: 0.5rem;">
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="footer-brand">
                        <img src="{{ asset('images/logo.jpg') }}" alt="هدية" style="height:32px;border-radius:8px;vertical-align:middle;margin-left:8px;" onerror="this.style.display='none'">
                        هدية
                    </div>
                    <p class="footer-desc">منصة متكاملة لخدمات العمرة الإلكترونية، نقدم لك تجربة روحانية استثنائية بأعلى معايير الجودة والراحة.</p>
                    <div class="footer-social d-flex gap-2 mt-3">
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6 mb-4 mb-lg-0">
                    <div class="footer-title">روابط سريعة</div>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> الرئيسية</a></li>
                        @auth
                            <li><a href="{{ route('home') }}" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> لوحتي</a></li>
                            <li><a href="{{ route('orders.index') }}" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> طلباتي</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> تسجيل الدخول</a></li>
                            <li><a href="{{ route('register') }}" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> إنشاء حساب</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-6 mb-4 mb-lg-0">
                    <div class="footer-title">خدماتنا</div>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> حزم العمرة</a></li>
                        <li><a href="#" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> الحجوزات الفندقية</a></li>
                        <li><a href="#" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> النقل</a></li>
                        <li><a href="#" class="footer-link"><i class="fas fa-chevron-left fa-xs"></i> التأشيرات</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-title">تواصل معنا</div>
                    <ul class="list-unstyled" style="font-size:.875rem;">
                        <li class="mb-2 d-flex align-items-center gap-2" style="color:rgba(255,255,255,.55);">
                            <i class="fas fa-phone text-purple" style="color:#a78bfa;"></i>
                            <span dir="ltr">+966 50 123 4567</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center gap-2" style="color:rgba(255,255,255,.55);">
                            <i class="fas fa-envelope" style="color:#a78bfa;"></i>
                            <span>info@hadiah.com</span>
                        </li>
                        <li class="d-flex align-items-center gap-2" style="color:rgba(255,255,255,.55);">
                            <i class="fas fa-map-marker-alt" style="color:#a78bfa;"></i>
                            <span>المملكة العربية السعودية</span>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <p class="footer-copy mb-0">&copy; {{ date('Y') }} هدية. جميع الحقوق محفوظة.</p>
                <p class="footer-copy mb-0">تطبيق العمرة الإلكتروني</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp -->
    <a href="#" id="whatsapp-float" class="whatsapp-float"
       data-phone="966501234567"
       data-message="مرحباً، أريد الاستفسار عن خدماتكم في تطبيق هدية للعمرة">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-tooltip">تواصل معنا عبر واتساب</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
