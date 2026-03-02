<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة تحكم الإدارة') - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: #f0f2f5;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            right: 0;
            width: 260px;
            z-index: 1040;
            box-shadow: -4px 0 20px rgba(0,0,0,0.15);
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.03);
        }

        .sidebar-brand img {
            height: 42px;
            width: auto;
            border-radius: 8px;
        }

        .sidebar-brand h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .sidebar-brand small {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
        }

        .sidebar-section-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 1rem 1.25rem 0.4rem;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.65);
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            margin: 2px 0.75rem;
            transition: all 0.25s ease;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 0.95rem;
            opacity: 0.8;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            transform: translateX(-4px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(102,126,234,0.25) 0%, rgba(118,75,162,0.2) 100%);
            color: #fff;
            border-left: 3px solid #667eea;
        }

        .sidebar .nav-link.active i {
            opacity: 1;
            color: #a78bfa;
        }

        .sidebar-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 0.5rem 1rem;
        }

        .sidebar-bottom {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.1);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-right: 260px;
            min-height: 100vh;
            background: #f0f2f5;
            transition: margin-right 0.3s ease;
        }

        .content-wrapper {
            padding: 1.5rem;
        }

        /* ===== TOPBAR ===== */
        .admin-topbar {
            background: #fff;
            border-radius: 16px;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(0,0,0,0.04);
        }

        .topbar-title h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .topbar-title p {
            font-size: 0.8rem;
            color: #94a3b8;
            margin: 0;
        }

        .topbar-breadcrumb {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 0.2rem;
        }

        .topbar-breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        /* ===== PROFILE AVATAR ===== */
        .profile-btn {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.5rem 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .profile-btn:hover {
            background: #f1f5f9;
            border-color: #667eea;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .profile-info .name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.2;
        }

        .profile-info .role {
            font-size: 0.72rem;
            color: #94a3b8;
            line-height: 1.2;
        }

        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            border-radius: 14px;
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #374151;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea15, #764ba210);
            color: #667eea;
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
            opacity: 0.7;
        }

        .dropdown-divider {
            margin: 0.4rem 0;
            border-color: #f1f5f9;
        }

        /* ===== PAGE HEADER ACTIONS ===== */
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        /* ===== CARDS ===== */
        .content-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            overflow: hidden;
            margin-bottom: 1.5rem;
            transition: box-shadow 0.3s ease;
        }

        .content-card:hover {
            box-shadow: 0 4px 25px rgba(0,0,0,0.1);
        }

        .content-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content-card-header h5, .content-card-header h6 {
            margin: 0;
            font-weight: 600;
            color: #1e293b;
        }

        /* ===== STATS CARDS ===== */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .stats-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stats-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stats-icon.users { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stats-icon.orders { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stats-icon.revenue { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stats-icon.packages { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .stats-number {
            font-size: 2rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .stats-label {
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ===== CHART CARDS ===== */
        .chart-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            margin-bottom: 1.5rem;
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-title i {
            color: #667eea;
            font-size: 1.1rem;
        }

        /* ===== TABLE CARD ===== */
        .table-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            margin-bottom: 1.5rem;
        }

        /* ===== TABLES ===== */
        .table th {
            border: none;
            color: #64748b;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.9rem 1rem;
            background: #f8fafc;
            white-space: nowrap;
        }

        .table td {
            border: none;
            border-bottom: 1px solid #f1f5f9;
            padding: 0.9rem 1rem;
            vertical-align: middle;
            font-size: 0.875rem;
            color: #374151;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #fafbfc;
        }

        /* ===== STATUS BADGES ===== */
        .status-badge {
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-assigned { background: #dbeafe; color: #1e40af; }
        .status-in_progress { background: #ede9fe; color: #5b21b6; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        /* ===== METRIC CARDS ===== */
        .metric-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.25rem;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .metric-number {
            font-size: 1.75rem;
            font-weight: 800;
            color: #667eea;
            margin-bottom: 0.3rem;
            line-height: 1;
        }

        .metric-label {
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* ===== GRADIENT TEXT ===== */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        /* ===== FORMS ===== */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 12px rgba(102,126,234,0.35);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4196 100%);
            box-shadow: 0 6px 18px rgba(102,126,234,0.45);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
        }

        /* ===== INFO TABLES ===== */
        .info-table {
            background: #f8fafc;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .info-table tr {
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table th {
            font-weight: 600;
            color: #64748b;
            width: 35%;
            padding: 0.85rem 1.25rem;
            font-size: 0.85rem;
            background: transparent;
            text-transform: none;
            letter-spacing: 0;
        }

        .info-table td {
            padding: 0.85rem 1.25rem;
            color: #1e293b;
            font-size: 0.875rem;
            border: none;
            background: transparent;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        /* ===== SIDEBAR TOGGLE ===== */
        .sidebar-toggle {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1050;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(102,126,234,0.4);
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sidebar-toggle:hover {
            transform: scale(1.05);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1039;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }

        /* ===== PAGE HEADER GRADIENT BAR ===== */
        .page-gradient-bar {
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            border-radius: 3px;
            margin-bottom: 1.5rem;
        }

        /* ===== BADGE ===== */
        .badge {
            font-weight: 600;
        }

        /* ===== NOTIFICATION BADGE ===== */
        .nav-badge {
            background: #ef4444;
            color: white;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.1rem 0.4rem;
            margin-right: auto;
        }

        /* ===== IMAGE UPLOAD ===== */
        .image-upload-container {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8fafc;
            cursor: pointer;
        }

        .image-upload-container:hover, .image-upload-container.drag-over {
            border-color: #667eea;
            background: #f0f0ff;
        }

        .upload-icon { font-size: 2.5rem; color: #667eea; margin-bottom: 0.75rem; }
        .upload-text { font-size: 1rem; color: #374151; font-weight: 600; margin-bottom: 0.25rem; }
        .upload-hint { font-size: 0.8rem; color: #94a3b8; }
        .preview-image { max-width: 280px; max-height: 180px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .current-image { max-width: 280px; max-height: 180px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        /* ===== PACKAGE IMAGE ===== */
        .package-image-container { border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); position: relative; }
        .package-image { width: 100%; height: 280px; object-fit: cover; transition: transform 0.3s ease; }
        .package-image-container:hover .package-image { transform: scale(1.03); }
        .image-placeholder { width: 100%; height: 280px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; text-align: center; }
        .image-placeholder i { font-size: 3rem; margin-bottom: 0.75rem; opacity: 0.7; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
            }

            .sidebar-toggle {
                display: flex;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .admin-topbar {
                padding: 0.85rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 0.75rem;
            }

            .stats-number {
                font-size: 1.5rem;
            }

            .topbar-title h4 {
                font-size: 1rem;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Sidebar Toggle (Mobile) -->
    <button class="sidebar-toggle" type="button" id="sidebarToggle" onclick="toggleSidebar()" aria-label="القائمة">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand d-flex align-items-center gap-3">
            <img src="/images/logo.jpg" alt="هدية" onerror="this.style.display='none'">
            <div>
                <h5>هدية</h5>
                <small>لوحة تحكم الإدارة</small>
            </div>
        </div>

        <!-- Navigation -->
        <div class="pt-2 pb-2">
            <div class="sidebar-section-label">القائمة الرئيسية</div>
            <ul class="nav flex-column px-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>لوحة التحكم</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>المستخدمون</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>الطلبات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}">
                        <i class="fas fa-box-open"></i>
                        <span>حزم العمرة</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                        <i class="fas fa-comments"></i>
                        <span>الرسائل</span>
                        @php $unread = auth()->user()->receivedMessages()->where('is_read', false)->count(); @endphp
                        @if($unread > 0)
                            <span class="nav-badge">{{ $unread }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog"></i>
                        <span>الإعدادات</span>
                    </a>
                </li>
            </ul>

            <hr class="sidebar-divider">

            <div class="sidebar-section-label">إجراءات سريعة</div>
            <ul class="nav flex-column px-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.create') }}">
                        <i class="fas fa-plus-circle"></i>
                        <span>طلب جديد</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.messages.create') }}">
                        <i class="fas fa-paper-plane"></i>
                        <span>رسالة جديدة</span>
                    </a>
                </li>
            </ul>

            <hr class="sidebar-divider">

            <ul class="nav flex-column px-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}" target="_blank">
                        <i class="fas fa-globe"></i>
                        <span>الموقع الرئيسي</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Bottom Profile -->
        <div class="sidebar-bottom">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="profile-avatar" style="width:38px;height:38px;border-radius:10px;">
                    <i class="fas fa-user-shield" style="font-size:0.9rem;"></i>
                </div>
                <div style="overflow:hidden;">
                    <div style="font-size:0.85rem;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
                    <div style="font-size:0.72rem;color:rgba(255,255,255,0.5);">مدير النظام</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm w-100" style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.12);font-size:0.8rem;">
                    <i class="fas fa-sign-out-alt me-1"></i>تسجيل الخروج
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="content-wrapper">

            <!-- Topbar -->
            <div class="admin-topbar">
                <div class="topbar-title">
                    <h4>@yield('page-title', 'لوحة تحكم الإدارة')</h4>
                    <p>@yield('page-description', 'مرحباً بك في لوحة تحكم منصة هدية')</p>
                </div>
                <div class="topbar-actions">
                    @yield('page-actions')
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <button class="profile-btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-avatar">
                                <i class="fas fa-user" style="font-size:0.85rem;"></i>
                            </div>
                            <div class="profile-info d-none d-sm-block">
                                <div class="name">{{ auth()->user()->name }}</div>
                                <div class="role">{{ auth()->user()->role == 'admin' ? 'مدير النظام' : 'مستخدم' }}</div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user-circle me-2 text-primary"></i>الملف الشخصي
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                                    <i class="fas fa-cog me-2 text-secondary"></i>الإعدادات
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('welcome') }}" target="_blank">
                                    <i class="fas fa-external-link-alt me-2 text-info"></i>الموقع الرئيسي
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
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

            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Close sidebar on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) closeSidebar();
        });

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Animate on scroll
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animate-on-scroll').forEach(function(el) {
                observer.observe(el);
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
