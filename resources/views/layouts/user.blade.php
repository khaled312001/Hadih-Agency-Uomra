<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; right: 0;
            width: 265px;
            height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 55%, #0f3460 100%);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: -4px 0 24px rgba(0,0,0,.18);
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }

        .sidebar-header {
            padding: 1.5rem 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
        }
        .sidebar-logo img { height: 38px; width: auto; border-radius: 9px; flex-shrink: 0; }
        .sidebar-logo-text h5 { margin: 0; font-size: 1rem; font-weight: 800; color: #fff; }
        .sidebar-logo-text small { font-size: .72rem; color: rgba(255,255,255,.45); }

        /* User card */
        .sidebar-user {
            margin: 1rem;
            padding: .85rem 1rem;
            background: rgba(255,255,255,.06);
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }
        .user-avatar-sm {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: .9rem; flex-shrink: 0;
        }
        .sidebar-user .uname { font-size: .85rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user .uemail { font-size: .72rem; color: rgba(255,255,255,.4); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        /* Nav */
        .sidebar-nav { flex: 1; overflow-y: auto; padding: .5rem 0; }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

        .sidebar-section { padding: .85rem 1.4rem .3rem; font-size: .68rem; font-weight: 700; color: rgba(255,255,255,.3); text-transform: uppercase; letter-spacing: 1.4px; }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .72rem 1.1rem;
            margin: 2px .75rem;
            border-radius: 10px;
            color: rgba(255,255,255,.62);
            font-size: .9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .22s ease;
            position: relative;
        }
        .sidebar .nav-link i { width: 20px; text-align: center; font-size: .95rem; flex-shrink: 0; opacity: .75; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.08); color: #fff; transform: translateX(-3px); }
        .sidebar .nav-link:hover i { opacity: 1; }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(102,126,234,.28) 0%, rgba(118,75,162,.2) 100%);
            color: #fff;
            border-right: 3px solid #667eea;
        }
        .sidebar .nav-link.active i { opacity: 1; color: #a78bfa; }
        .sidebar-divider { border: none; border-top: 1px solid rgba(255,255,255,.07); margin: .5rem 1rem; }

        /* Quick actions */
        .sidebar-quick {
            padding: .5rem 1rem;
            flex-shrink: 0;
        }
        .btn-quick {
            display: flex;
            align-items: center;
            gap: .5rem;
            width: 100%;
            padding: .6rem 1rem;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.05);
            color: rgba(255,255,255,.7);
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            font-family: 'Cairo', sans-serif;
            margin-bottom: .4rem;
            cursor: pointer;
        }
        .btn-quick:hover { background: rgba(255,255,255,.12); color: #fff; transform: translateX(-2px); }
        .btn-quick i { width: 18px; text-align: center; }

        /* Bottom logout */
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .btn-logout {
            width: 100%;
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.25);
            color: #fca5a5;
            border-radius: 10px;
            padding: .6rem 1rem;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            font-family: 'Cairo', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-logout:hover { background: rgba(239,68,68,.2); color: #fca5a5; }

        /* ===== OVERLAY ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 1039;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }
        .sidebar-overlay.show { display: block; }

        /* ===== TOGGLE BUTTON ===== */
        .sidebar-toggle {
            position: fixed;
            top: 1rem; right: 1rem;
            z-index: 1050;
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: white;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(102,126,234,.4);
            transition: all .2s;
        }
        .sidebar-toggle:hover { transform: scale(1.05); }
        .sidebar-toggle.active { background: #ef4444; }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-right: 265px;
            min-height: 100vh;
            background: #f0f2f5;
            transition: margin-right .3s cubic-bezier(.4,0,.2,1);
        }
        .content-wrapper { padding: 1.5rem; }

        /* ===== TOPBAR ===== */
        .user-topbar {
            background: #fff;
            border-radius: 16px;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(0,0,0,.04);
            flex-wrap: wrap;
            gap: .75rem;
        }
        .topbar-left h4 { font-size: 1.15rem; font-weight: 800; color: #1e293b; margin: 0; }
        .topbar-left p { font-size: .8rem; color: #94a3b8; margin: 0; }

        .profile-btn-top {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: .4rem .85rem;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            color: inherit;
            font-size: .875rem;
        }
        .profile-btn-top:hover { border-color: #667eea; background: #f0f4ff; color: inherit; }
        .pa-circle {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: .8rem; flex-shrink: 0;
        }

        /* ===== STATS CARDS ===== */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.4rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            border: 1px solid rgba(0,0,0,.04);
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 3px;
        }
        .stat-card.blue::before { background: linear-gradient(90deg,#667eea,#764ba2); }
        .stat-card.green::before { background: linear-gradient(90deg,#11998e,#38ef7d); }
        .stat-card.orange::before { background: linear-gradient(90deg,#f093fb,#f5576c); }
        .stat-card.cyan::before { background: linear-gradient(90deg,#4facfe,#00f2fe); }

        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.12); }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: white; margin-bottom: .9rem;
        }
        .stat-icon.blue { background: linear-gradient(135deg,#667eea,#764ba2); }
        .stat-icon.green { background: linear-gradient(135deg,#11998e,#38ef7d); }
        .stat-icon.orange { background: linear-gradient(135deg,#f093fb,#f5576c); }
        .stat-icon.cyan { background: linear-gradient(135deg,#4facfe,#00f2fe); }
        .stat-number { font-size: 1.85rem; font-weight: 800; color: #1e293b; line-height: 1; margin-bottom: .25rem; }
        .stat-label { font-size: .82rem; font-weight: 600; color: #94a3b8; }

        /* ===== ORDER CARD ===== */
        .order-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
            border: 1px solid rgba(0,0,0,.04);
            transition: all .3s ease;
            overflow: hidden;
        }
        .order-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.12); }
        .order-card .card-header { padding: 1rem 1.2rem; background: #fff; border-bottom: 1px solid #f1f5f9; }
        .order-card .card-body { padding: 1.1rem 1.2rem; }
        .order-card .card-footer { padding: .9rem 1.2rem; background: #fafbfc; border-top: 1px solid #f1f5f9; }

        /* ===== CONTENT CARD ===== */
        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            border: 1px solid rgba(0,0,0,.04);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .content-card-header {
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .content-card-header h5, .content-card-header h6 { margin: 0; font-weight: 700; color: #1e293b; }
        .content-card-body { padding: 1.4rem; }

        /* ===== FORM STYLES ===== */
        .form-section { background: #fff; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,.06); margin-bottom: 1.5rem; }
        .form-section-title { font-size: .9rem; font-weight: 700; color: #667eea; margin-bottom: 1.25rem; padding-bottom: .6rem; border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; gap: .5rem; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-right: 0; }
            .sidebar-toggle { display: flex; }
            .content-wrapper { padding: 1rem; }
            .user-topbar { padding: .9rem 1rem; }
        }
        @media (max-width: 576px) {
            .content-wrapper { padding: .75rem; }
            .stat-number { font-size: 1.5rem; }
            .topbar-left h4 { font-size: 1rem; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Mobile Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" aria-label="القائمة">
        <i class="fas fa-bars" id="toggleIcon"></i>
    </button>

    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">

        <!-- Header / Logo -->
        <div class="sidebar-header">
            <a href="{{ url('/') }}" class="sidebar-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="هدية" onerror="this.style.display='none'">
                <div class="sidebar-logo-text">
                    <h5>هدية</h5>
                    <small>لوحة تحكم المستخدم</small>
                </div>
            </a>
        </div>

        <!-- User Info -->
        <div class="sidebar-user d-flex align-items-center gap-2">
            <div class="user-avatar-sm"><i class="fas fa-user"></i></div>
            <div style="overflow:hidden;">
                <div class="uname">{{ auth()->user()->name }}</div>
                <div class="uemail">{{ auth()->user()->email }}</div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <div class="sidebar-section">القائمة الرئيسية</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home"></i><span>الصفحة الرئيسية</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="fas fa-shopping-cart"></i><span>طلباتي</span>
                        {{-- order count badge --}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                        <i class="fas fa-envelope"></i>
                        <span>الرسائل</span>
                        @php $unread = auth()->user()->receivedMessages()->where('is_read',false)->count(); @endphp
                        @if($unread > 0)
                            <span class="ms-auto badge bg-danger" style="font-size:.65rem;padding:.25em .55em;border-radius:50px;">{{ $unread }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <i class="fas fa-user-edit"></i><span>الملف الشخصي</span>
                    </a>
                </li>
            </ul>

            <hr class="sidebar-divider">
            <div class="sidebar-section">إجراءات سريعة</div>
        </nav>

        <!-- Quick Actions -->
        <div class="sidebar-quick">
            <a href="{{ route('orders.create') }}" class="btn-quick">
                <i class="fas fa-plus-circle" style="color:#a78bfa;"></i> طلب عمرة جديد
            </a>
            <a href="{{ route('messages.create') }}" class="btn-quick">
                <i class="fas fa-paper-plane" style="color:#34d399;"></i> إرسال رسالة
            </a>
            <a href="{{ url('/') }}" target="_blank" class="btn-quick">
                <i class="fas fa-globe" style="color:#60a5fa;"></i> الموقع الرئيسي
            </a>
        </div>

        <!-- Footer / Logout -->
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content" id="mainContent">
        <div class="content-wrapper">

            <!-- Topbar -->
            <div class="user-topbar">
                <div class="topbar-left">
                    <h4>@yield('page-title', 'لوحة التحكم')</h4>
                    <p>@yield('page-description', 'مرحباً بك في هدية')</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @yield('page-actions')
                    <div class="dropdown">
                        <a class="profile-btn-top dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="pa-circle"><i class="fas fa-user"></i></div>
                            <span class="d-none d-sm-block" style="font-weight:600;color:#1e293b;font-size:.875rem;">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="fas fa-user-edit text-primary"></i> الملف الشخصي
                            </a></li>
                            <li><a class="dropdown-item" href="{{ url('/') }}" target="_blank">
                                <i class="fas fa-home text-info"></i> الموقع الرئيسي
                            </a></li>
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
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div>
                        <i class="fas fa-exclamation-circle"></i> <strong>يرجى تصحيح الأخطاء التالية:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

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
    <script>
        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const overlay  = document.getElementById('sidebarOverlay');
            const icon     = document.getElementById('toggleIcon');
            const btn      = document.getElementById('sidebarToggle');
            const isOpen   = sidebar.classList.contains('show');

            if (isOpen) {
                closeSidebar();
            } else {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                btn.classList.add('active');
                icon.className = 'fas fa-times';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const icon    = document.getElementById('toggleIcon');
            const btn     = document.getElementById('sidebarToggle');
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            btn.classList.remove('active');
            icon.className = 'fas fa-bars';
            document.body.style.overflow = '';
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) closeSidebar();
        });

        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                document.querySelectorAll('.alert.fade').forEach(function (el) {
                    try { new bootstrap.Alert(el).close(); } catch(e) {}
                });
            }, 5000);
        });
    </script>
</body>
</html>
