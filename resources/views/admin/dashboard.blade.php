@extends('layouts.admin')

@section('title', 'لوحة تحكم الإدارة')
@section('page-title', 'لوحة تحكم الإدارة')
@section('page-description', 'مرحباً بك في لوحة تحكم منصة هدية')



@section('styles')
<style>
    .progress-ring {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    
    .progress-ring circle {
        fill: transparent;
        stroke-width: 8;
        stroke-linecap: round;
    }
    
    .progress-ring .progress-ring-circle {
        stroke: #667eea;
        stroke-dasharray: 283;
        stroke-dashoffset: 283;
        transition: stroke-dashoffset 0.5s ease-in-out;
    }
    
    .progress-ring .progress-ring-bg {
        stroke: #e9ecef;
    }
    
    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
    }
</style>
@endsection

@section('content')
            
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card animate-on-scroll hover-lift">
                        <div class="stats-icon users icon-animated">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-number">{{ number_format($stats['total_users']) }}</div>
                        <div class="stats-label">إجمالي المستخدمين</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card animate-on-scroll hover-lift">
                        <div class="stats-icon orders icon-animated">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stats-number">{{ number_format($stats['total_orders']) }}</div>
                        <div class="stats-label">إجمالي الطلبات</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card animate-on-scroll hover-lift">
                        <div class="stats-icon revenue icon-animated">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stats-number">{{ number_format($stats['total_revenue'], 0) }}</div>
                        <div class="stats-label">إجمالي الإيرادات (ريال)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card animate-on-scroll hover-lift">
                        <div class="stats-icon packages icon-animated">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stats-number">{{ number_format($stats['active_packages']) }}</div>
                        <div class="stats-label">الحزم النشطة</div>
                    </div>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="row mb-4">
                <!-- Orders by Status Chart -->
                <div class="col-lg-6 mb-3">
                    <div class="chart-card animate-on-scroll">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-pie icon-animated"></i>
                            توزيع الطلبات حسب الحالة
                        </h3>
                        <canvas id="ordersStatusChart" height="300"></canvas>
                    </div>
                </div>
                
                <!-- Orders by Month Chart -->
                <div class="col-lg-6 mb-3">
                    <div class="chart-card animate-on-scroll">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-line icon-animated"></i>
                            الطلبات الشهرية (آخر 6 أشهر)
                        </h3>
                        <canvas id="ordersMonthChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Revenue and Daily Orders -->
            <div class="row mb-4">
                <!-- Revenue Chart -->
                <div class="col-lg-6 mb-3">
                    <div class="chart-card animate-on-scroll">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-bar icon-animated"></i>
                            الإيرادات الشهرية (آخر 6 أشهر)
                        </h3>
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
                
                <!-- Daily Orders Chart -->
                <div class="col-lg-6 mb-3">
                    <div class="chart-card animate-on-scroll">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-area icon-animated"></i>
                            الطلبات اليومية (آخر 7 أيام)
                        </h3>
                        <canvas id="dailyOrdersChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Additional Metrics -->
            <div class="row mb-4">
                <div class="col-lg-4 mb-3">
                    <div class="chart-card text-center animate-on-scroll hover-lift">
                        <h3 class="chart-title">
                            <i class="fas fa-percentage icon-animated"></i>
                            معدل إكمال الطلبات
                        </h3>
                        <div class="position-relative d-inline-block">
                            <svg class="progress-ring" viewBox="0 0 120 120">
                                <circle class="progress-ring-bg" cx="60" cy="60" r="50"></circle>
                                <circle class="progress-ring-circle" cx="60" cy="60" r="50" 
                                        style="stroke-dashoffset: {{ 283 - (283 * $completion_rate / 100) }};"></circle>
                            </svg>
                            <div class="progress-text">{{ number_format($completion_rate, 1) }}%</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-3">
                    <div class="chart-card animate-on-scroll">
                        <h3 class="chart-title">
                            <i class="fas fa-credit-card icon-animated"></i>
                            طرق الدفع
                        </h3>
                        <canvas id="paymentMethodsChart" height="200"></canvas>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-3">
                    <div class="chart-card text-center animate-on-scroll hover-lift">
                        <h3 class="chart-title">
                            <i class="fas fa-calculator icon-animated"></i>
                            متوسط قيمة الطلب
                        </h3>
                        <div class="stats-number text-primary">{{ number_format($average_order_value, 0) }}</div>
                        <div class="stats-label">ريال سعودي</div>
                    </div>
                </div>
            </div>
            
            <!-- Popular Packages and Recent Orders -->
            <div class="row">
                <!-- Popular Packages -->
                <div class="col-lg-6 mb-3">
                    <div class="table-card animate-on-scroll">
                        <h3 class="chart-title">
                            <i class="fas fa-star icon-animated"></i>
                            أكثر الحزم طلباً
                        </h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>الحزمة</th>
                                        <th>عدد الطلبات</th>
                                        <th>السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($popular_packages as $package)
                                    <tr class="animate-on-scroll">
                                        <td>
                                            <strong>{{ $package->name_ar }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary badge-pulse">{{ $package->orders_count }}</span>
                                        </td>
                                        <td>{{ number_format($package->price) }} ريال</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="col-lg-6 mb-3">
                    <div class="table-card animate-on-scroll">
                        <h3 class="chart-title">
                            <i class="fas fa-clock icon-animated"></i>
                            الطلبات الأخيرة
                        </h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المستخدم</th>
                                        <th>الحالة</th>
                                        <th>المبلغ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_orders as $order)
                                    <tr class="animate-on-scroll">
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($order->total_amount) }} ريال</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@section('scripts')
    <script>
        // Orders by Status Chart
        const ordersStatusCtx = document.getElementById('ordersStatusChart').getContext('2d');
        new Chart(ordersStatusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($orders_by_status)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($orders_by_status)) !!},
                    backgroundColor: [
                        '#ff6b6b',
                        '#4ecdc4',
                        '#45b7d1',
                        '#96ceb4',
                        '#feca57'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
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
        
        // Orders by Month Chart
        const ordersMonthCtx = document.getElementById('ordersMonthChart').getContext('2d');
        new Chart(ordersMonthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($orders_by_month)) !!},
                datasets: [{
                    label: 'عدد الطلبات',
                    data: {!! json_encode(array_values($orders_by_month)) !!},
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
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
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
        
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($revenue_by_month)) !!},
                datasets: [{
                    label: 'الإيرادات (ريال)',
                    data: {!! json_encode(array_values($revenue_by_month)) !!},
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: '#667eea',
                    borderWidth: 1,
                    borderRadius: 8
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
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
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
        
        // Daily Orders Chart
        const dailyOrdersCtx = document.getElementById('dailyOrdersChart').getContext('2d');
        new Chart(dailyOrdersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($daily_orders)) !!},
                datasets: [{
                    label: 'عدد الطلبات',
                    data: {!! json_encode(array_values($daily_orders)) !!},
                    backgroundColor: 'rgba(86, 171, 47, 0.8)',
                    borderColor: '#56ab2f',
                    borderWidth: 1,
                    borderRadius: 8
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
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
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
        
        // Payment Methods Chart
        const paymentMethodsCtx = document.getElementById('paymentMethodsChart').getContext('2d');
        new Chart(paymentMethodsCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($payments_by_method)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($payments_by_method)) !!},
                    backgroundColor: [
                        '#ff6b6b',
                        '#4ecdc4',
                        '#45b7d1'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true
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
    </script>
@endsection
