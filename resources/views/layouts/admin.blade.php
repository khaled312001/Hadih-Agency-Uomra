<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة تحكم الإدارة') - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: #f4f7fe; /* Lighter, fresher background */
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: linear-gradient(180deg, #11101d 0%, #1d1b31 100%); /* Deeper rich dark */
            height: 100vh; /* Fixed height for scrolling */
            color: white;
            position: fixed;
            top: 0;
            right: 0;
            width: 270px;
            z-index: 1040;
            box-shadow: -4px 0 25px rgba(0,0,0,0.1);
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
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
            color: rgba(255,255,255,0.6);
            padding: 0.7rem 1.1rem; /* Reduced padding */
            border-radius: 10px; /* Slightly smaller radius */
            margin: 2px 0.75rem; /* Reduced margin */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.88rem; /* Slightly smaller font */
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            font-size: 1.05rem;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(-4px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
        }

        .sidebar .nav-link.active i {
            color: #fff;
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
            margin-right: 270px;
            min-height: 100vh;
            background: #f4f7fe;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            padding: 1.5rem 2rem;
            width: 100%;
            flex: 1;
        }

        /* ===== TOPBAR ===== */
        .admin-topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 1.2rem 1.8rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.8);
            position: relative; /* Changed from sticky to relative for better flow stability */
            top: 0;
            z-index: 1000;
            width: 100%;
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
            gap: 0.75rem;
            background: transparent;
            border: none;
            padding: 0.4rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .profile-btn:hover {
            background: rgba(79, 70, 229, 0.05);
        }

        .profile-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
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
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: none;
            overflow: hidden;
            margin-bottom: 1.5rem;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .content-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            transform: translateY(-2px);
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
            border-radius: 24px;
            padding: 1.8rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
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
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .stats-icon.users { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); box-shadow: 0 8px 16px rgba(99, 102, 241, 0.25); }
        .stats-icon.orders { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); }
        .stats-icon.revenue { background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); box-shadow: 0 8px 16px rgba(244, 63, 94, 0.25); }
        .stats-icon.packages { background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%); box-shadow: 0 8px 16px rgba(14, 165, 233, 0.25); }

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
            border-radius: 24px;
            padding: 1.8rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: none;
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
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none;
            color: white;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
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
        /* ===== RTL SUPPORT ===== */
        html[dir="rtl"] .sidebar {
            right: 0 !important;
            left: auto !important;
            transform: translateX(0) !important;
        }

        html[dir="rtl"] .main-content {
            margin-right: 270px !important;
            margin-left: 0 !important;
        }

        html[dir="rtl"] .sidebar-toggle {
            right: 1.5rem !important;
            left: auto !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            html[dir="rtl"] .sidebar { transform: translateX(100%) !important; width: 270px; right: 0; left: auto; }
            .sidebar { transform: translateX(-100%); width: 270px; left: 0; right: auto; }
            
            .sidebar.show { transform: translateX(0) !important; }
            
            html[dir="rtl"] .main-content, .main-content { 
                margin-right: 0 !important; 
                margin-left: 0 !important; 
                padding-top: 20px !important;
            }
            
            .sidebar-toggle { display: flex; z-index: 2000; }
            .content-wrapper { padding: 1rem; }
            
            .admin-topbar { 
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .topbar-actions { width: 100%; justify-content: space-between; }
        }

        @media (max-width: 576px) {
            .content-wrapper { padding: 0.75rem; }
            .stats-number { font-size: 1.5rem; }
            .topbar-title h4 { font-size: .95rem; }
            .stats-card { padding: 1.1rem; }
            .chart-card { padding: 1.1rem; }
            .content-card-header { padding: 1rem 1.1rem; flex-wrap: wrap; gap: .5rem; }
            .admin-topbar { flex-direction: column; align-items: flex-start; }
            .topbar-actions { width: 100%; justify-content: flex-start; margin-top: 0.5rem; }
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
