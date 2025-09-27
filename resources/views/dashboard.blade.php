@extends('layouts.user')

@section('title', 'لوحة التحكم - هدية')
@section('page-title', 'لوحة التحكم')
@section('page-description', 'مرحباً بك في لوحة تحكم هدية - تطبيق العمرة الإلكتروني')

@push('styles')
<link href="{{ asset('css/animations.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="stat-card bg-gradient text-white animate-on-scroll" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 gradient-text">مرحباً بك، {{ $user->name }}! 👋</h2>
                    <p class="mb-0 opacity-75">إليك نظرة عامة على نشاطك في منصة هدية</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <i class="fas fa-chart-line fa-3x opacity-50 icon-animated"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-primary me-3">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $userStats['total_orders'] }}</h3>
                    <p class="text-muted mb-0">إجمالي الطلبات</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-warning me-3">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $userStats['pending_orders'] }}</h3>
                    <p class="text-muted mb-0">طلبات في الانتظار</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-success me-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $userStats['completed_orders'] }}</h3>
                    <p class="text-muted mb-0">طلبات مكتملة</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-info me-3">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $userStats['unread_messages'] }}</h3>
                    <p class="text-muted mb-0">رسائل غير مقروءة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Monthly Orders Chart -->
    <div class="col-lg-8 mb-3">
        <div class="chart-container">
            <h5 class="mb-3">
                <i class="fas fa-chart-bar me-2 text-primary"></i>
                إحصائيات الطلبات الشهرية
            </h5>
            <canvas id="monthlyOrdersChart" height="100"></canvas>
        </div>
    </div>
    
    <!-- Order Status Pie Chart -->
    <div class="col-lg-4 mb-3">
        <div class="chart-container">
            <h5 class="mb-3">
                <i class="fas fa-chart-pie me-2 text-success"></i>
                توزيع حالة الطلبات
            </h5>
            <canvas id="orderStatusChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8 mb-4">
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>
                    الطلبات الأخيرة
                </h5>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm">
                    عرض الكل <i class="fas fa-arrow-left ms-1"></i>
                </a>
            </div>
            
            @if($recentOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>حزمة العمرة</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->umrahPackage->name ?? 'غير محدد' }}</strong>
                                            @if($order->umrahPackage)
                                                <br><small class="text-muted">{{ $order->umrahPackage->duration }} أيام</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'processing' => 'info'
                                            ];
                                            $statusText = [
                                                'pending' => 'في الانتظار',
                                                'completed' => 'مكتمل',
                                                'cancelled' => 'ملغي',
                                                'processing' => 'قيد المعالجة'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            {{ $statusText[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $order->created_at->format('Y-m-d') }}</small>
                                        <br><small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">لا توجد طلبات بعد</h6>
                    <p class="text-muted">ابدأ رحلتك بطلب حزمة عمرة جديدة</p>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>طلب جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar Content -->
    <div class="col-lg-4">
        <!-- Recent Messages -->
        <div class="chart-container mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-envelope me-2 text-info"></i>
                    الرسائل الأخيرة
                </h5>
                <a href="{{ route('messages.index') }}" class="btn btn-outline-info btn-sm">
                    عرض الكل <i class="fas fa-arrow-left ms-1"></i>
                </a>
            </div>
            
            @if($recentMessages->count() > 0)
                @foreach($recentMessages as $message)
                    <div class="recent-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-user-circle fa-2x text-muted"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $message->sender->name ?? 'مجهول' }}</h6>
                                <p class="mb-1 text-muted small">{{ Str::limit($message->message, 50) }}</p>
                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-3">
                    <i class="fas fa-envelope fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">لا توجد رسائل</p>
                </div>
            @endif
        </div>
        
        <!-- Available Packages -->
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2 text-success"></i>
                    حزم العمرة المتاحة
                </h5>
            </div>
            
            @if($availablePackages->count() > 0)
                @foreach($availablePackages as $package)
                    <div class="recent-item">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($package->image && !empty($package->image) && file_exists(public_path($package->image)))
                                    <img src="{{ asset($package->image) }}" alt="{{ $package->name }}" 
                                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-box text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $package->name }}</h6>
                                <p class="mb-1 text-success fw-bold">{{ number_format($package->price) }} ريال</p>
                                <small class="text-muted">{{ $package->duration }} أيام</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-3">
                    <i class="fas fa-box fa-2x text-muted mb-2"></i>
                    <p class="text-muted small mb-0">لا توجد حزم متاحة</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="chart-container">
            <h5 class="mb-3">
                <i class="fas fa-bolt me-2 text-warning"></i>
                إجراءات سريعة
            </h5>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>طلب جديد
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('messages.index') }}" class="btn btn-info w-100">
                        <i class="fas fa-envelope me-2"></i>الرسائل
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('profile') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-user-edit me-2"></i>الملف الشخصي
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Monthly Orders Chart
    const monthlyCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            datasets: [{
                label: 'عدد الطلبات',
                data: @json($monthlyData),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2.5,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });

    // Order Status Pie Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['في الانتظار', 'مكتمل', 'ملغي'],
            datasets: [{
                data: [{{ $statusData['pending'] }}, {{ $statusData['completed'] }}, {{ $statusData['cancelled'] }}],
                backgroundColor: ['#ffc107', '#28a745', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });
</script>
@endsection