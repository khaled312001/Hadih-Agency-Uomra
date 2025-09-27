<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المستخدم - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
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
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
        }
        
        .info-table {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        
        .info-table tr {
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-table tr:last-child {
            border-bottom: none;
        }
        
        .info-table th {
            font-weight: 600;
            color: #495057;
            width: 30%;
            padding: 15px 0;
        }
        
        .info-table td {
            padding: 15px 0;
            color: #212529;
        }
        
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
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
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
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
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog me-2"></i>الإعدادات
                    </a>
                </li>
            </ul>
            
            <hr class="text-white-50">
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">
                        <i class="fas fa-home me-2"></i>الموقع الرئيسي
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white p-0 w-100 text-start">
                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">تفاصيل المستخدم</h2>
                    <p class="text-muted mb-0">{{ $user->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>تعديل المستخدم
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للمستخدمين
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- User Details -->
                <div class="col-md-8">
                    <div class="content-card">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-user me-2 text-primary"></i>
                                معلومات المستخدم
                            </h5>
                            
                            <div class="info-table">
                                <table class="table table-borderless mb-0">
                    <tr>
                        <th>الاسم:</th>
                                        <td><strong>{{ $user->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>البريد الإلكتروني:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>الهاتف:</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th>الدور:</th>
                        <td>
                                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }} px-3 py-2">
                                                {{ $user->role == 'admin' ? 'مدير' : 'مستخدم' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>الحالة:</th>
                        <td>
                                            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} px-3 py-2">
                                {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>تاريخ التسجيل:</th>
                        <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                                    <tr>
                                        <th>آخر تحديث:</th>
                                        <td>{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                </table>
            </div>
        </div>
    </div>
                </div>

                <!-- Actions & Stats -->
    <div class="col-md-4">
                    <div class="content-card">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-cogs me-2 text-primary"></i>
                                الإجراءات
                            </h5>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>تعديل المستخدم
                </a>
                                
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-trash me-2"></i>حذف المستخدم
                                    </button>
                                </form>
                                @endif
                                
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-right me-2"></i>العودة للمستخدمين
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Stats -->
                    <div class="content-card mt-3">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>
                                إحصائيات المستخدم
                            </h5>
                            
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h4 class="text-primary mb-1">{{ $user->orders()->count() }}</h4>
                                        <small class="text-muted">إجمالي الطلبات</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-1">{{ $user->orders()->where('status', 'completed')->count() }}</h4>
                                    <small class="text-muted">طلبات مكتملة</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    @if($user->orders()->count() > 0)
                    <div class="content-card mt-3">
                        <div class="p-4">
                            <h5 class="mb-4">
                                <i class="fas fa-shopping-cart me-2 text-primary"></i>
                                آخر الطلبات
                            </h5>
                            
                            <div class="list-group list-group-flush">
                                @foreach($user->orders()->latest()->take(3)->get() as $order)
                                <div class="list-group-item px-0 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $order->umrahPackage->name_ar }}</h6>
                                            <small class="text-muted">{{ $order->created_at->format('Y-m-d') }}</small>
                                        </div>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }}">
                                            @switch($order->status)
                                                @case('pending')
                                                    في الانتظار
                                                    @break
                                                @case('completed')
                                                    مكتمل
                                                    @break
                                                @default
                                                    {{ $order->status }}
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            @if($user->orders()->count() > 3)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.orders.index') }}?user={{ $user->id }}" class="btn btn-outline-primary btn-sm">
                                    عرض جميع الطلبات
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>