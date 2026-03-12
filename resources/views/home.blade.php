@extends('layouts.user')

@section('title', 'الصفحة الرئيسية - هدية')
@section('page-title', 'الصفحة الرئيسية')
@section('page-description', 'مرحباً بك في هدية - تطبيق العمرة الإلكتروني')

@section('content')

<!-- Welcome Banner -->
<div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 55%, #0f3460 100%); border-radius: 20px; padding: 2rem 2.5rem; margin-bottom: 1.5rem; position: relative; overflow: hidden;">
    <div style="position:absolute;top:-30px;left:-30px;width:160px;height:160px;background:rgba(102,126,234,.12);border-radius:50%;"></div>
    <div style="position:absolute;bottom:-40px;right:60px;width:120px;height:120px;background:rgba(118,75,162,.1);border-radius:50%;"></div>
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3" style="position:relative;z-index:1;">
        <div>
            <h3 class="mb-1" style="color:#fff;font-weight:800;">مرحباً، {{ auth()->user()->name }} 👋</h3>
            <p class="mb-0" style="color:rgba(255,255,255,.6);font-size:.9rem;">هدية - منصتك الموثوقة لخدمات العمرة الإلكترونية</p>
        </div>
        <a href="{{ route('orders.create') }}" style="background:linear-gradient(135deg,#667eea,#764ba2);border:none;border-radius:12px;padding:.65rem 1.4rem;color:#fff;font-weight:700;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:.45rem;box-shadow:0 4px 18px rgba(102,126,234,.45);white-space:nowrap;flex-shrink:0;">
            <i class="fas fa-plus"></i> طلب عمرة جديد
        </a>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card blue">
            <div class="stat-icon blue"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-number">{{ $orders->count() }}</div>
            <div class="stat-label">إجمالي الطلبات</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card orange">
            <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
            <div class="stat-number">{{ $orders->whereIn('status',['pending','assigned','in_progress'])->count() }}</div>
            <div class="stat-label">قيد المعالجة</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card green">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-number">{{ $orders->where('status','completed')->count() }}</div>
            <div class="stat-label">طلبات مكتملة</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card cyan">
            <div class="stat-icon cyan"><i class="fas fa-envelope"></i></div>
            <div class="stat-number">
                @php $unread = auth()->user()->receivedMessages()->where('is_read',false)->count(); @endphp
                {{ $unread }}
            </div>
            <div class="stat-label">رسائل غير مقروءة</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Orders -->
    <div class="col-12 col-lg-8">
        <div class="content-card">
            <div class="content-card-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <h6 style="margin:0;font-weight:700;color:#1e293b;">طلباتك الأخيرة</h6>
                        <div style="font-size:.75rem;color:#94a3b8;">آخر {{ $orders->take(5)->count() }} طلبات</div>
                    </div>
                </div>
                <a href="{{ route('orders.index') }}" style="font-size:.82rem;color:#667eea;font-weight:600;text-decoration:none;">عرض الكل <i class="fas fa-arrow-left fa-xs"></i></a>
            </div>

            @if($orders->count() > 0)
                <!-- Desktop Table -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>حزمة العمرة</th>
                                    <th>الحالة</th>
                                    <th>المبلغ</th>
                                    <th>التاريخ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->take(5) as $order)
                                <tr>
                                    <td><strong style="color:#667eea;">{{ $order->order_number ?? '#'.$order->id }}</strong></td>
                                    <td>{{ $order->umrahPackage->name_ar ?? $order->umrahPackage->name ?? 'غير محدد' }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $order->status }}">
                                            @switch($order->status)
                                                @case('pending') <i class="fas fa-clock"></i> في الانتظار @break
                                                @case('confirmed') <i class="fas fa-check"></i> مؤكد @break
                                                @case('assigned') <i class="fas fa-user-check"></i> مُكلَّف @break
                                                @case('in_progress') <i class="fas fa-spinner"></i> قيد التنفيذ @break
                                                @case('completed') <i class="fas fa-check-circle"></i> مكتمل @break
                                                @case('cancelled') <i class="fas fa-times-circle"></i> ملغي @break
                                                @default {{ $order->status }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td><strong style="color:#059669;">{{ number_format($order->total_amount) }} {{ $order->currency ?? 'SAR' }}</strong></td>
                                    <td style="color:#94a3b8;font-size:.82rem;">{{ $order->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" style="font-size:.8rem;color:#667eea;font-weight:600;text-decoration:none;">
                                            <i class="fas fa-eye fa-sm"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Cards -->
                <div class="d-md-none p-3">
                    @foreach($orders->take(3) as $order)
                    <div style="background:#f8fafc;border-radius:12px;padding:1rem;margin-bottom:.75rem;border:1px solid #f1f5f9;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <strong style="color:#667eea;font-size:.9rem;">{{ $order->order_number ?? '#'.$order->id }}</strong>
                            <span class="status-badge status-{{ $order->status }}" style="font-size:.7rem;">
                                @switch($order->status)
                                    @case('pending') في الانتظار @break
                                    @case('in_progress') قيد التنفيذ @break
                                    @case('completed') مكتمل @break
                                    @case('cancelled') ملغي @break
                                    @default {{ $order->status }}
                                @endswitch
                            </span>
                        </div>
                        <div style="font-size:.85rem;color:#374151;margin-bottom:.4rem;">
                            <i class="fas fa-box me-1" style="color:#94a3b8;"></i>
                            {{ $order->umrahPackage->name_ar ?? 'غير محدد' }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size:.82rem;color:#059669;font-weight:700;">{{ number_format($order->total_amount) }} {{ $order->currency ?? 'SAR' }}</span>
                            <a href="{{ route('orders.show', $order) }}" style="font-size:.8rem;color:#667eea;font-weight:600;text-decoration:none;">
                                التفاصيل <i class="fas fa-arrow-left fa-xs"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state" style="padding:3rem 1.5rem;">
                    <div class="empty-state-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5>لا توجد طلبات حالياً</h5>
                    <p>ابدأ رحلتك الروحية بتقديم طلب عمرة جديد</p>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> طلب عمرة جديد
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="col-12 col-lg-4">

        <!-- Quick Actions -->
        <div class="content-card mb-3">
            <div class="content-card-header">
                <h6><i class="fas fa-bolt me-2" style="color:#f59e0b;"></i>إجراءات سريعة</h6>
            </div>
            <div class="content-card-body d-grid gap-2">
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> طلب عمرة جديد
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-list"></i> عرض جميع الطلبات
                </a>
                <a href="{{ route('messages.create') }}" style="background:#f0fdf4;border:2px solid #dcfce7;border-radius:12px;padding:.55rem 1.1rem;color:#166534;font-weight:600;font-size:.875rem;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.4rem;transition:all .2s;">
                    <i class="fas fa-envelope" style="color:#22c55e;"></i> إرسال رسالة
                </a>
                <a href="{{ route('messages.index') }}" style="background:#eff6ff;border:2px solid #dbeafe;border-radius:12px;padding:.55rem 1.1rem;color:#1e40af;font-weight:600;font-size:.875rem;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.4rem;transition:all .2s;">
                    <i class="fas fa-inbox" style="color:#3b82f6;"></i> صندوق الرسائل
                    @if($unread > 0)
                        <span class="badge bg-danger" style="font-size:.65rem;">{{ $unread }}</span>
                    @endif
                </a>
                <a href="{{ route('profile') }}" style="background:#faf5ff;border:2px solid #ede9fe;border-radius:12px;padding:.55rem 1.1rem;color:#5b21b6;font-weight:600;font-size:.875rem;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.4rem;transition:all .2s;">
                    <i class="fas fa-user-edit" style="color:#8b5cf6;"></i> الملف الشخصي
                </a>
            </div>
        </div>

        <!-- Status Summary -->
        @if($orders->count() > 0)
        <div class="content-card">
            <div class="content-card-header">
                <h6><i class="fas fa-chart-pie me-2" style="color:#667eea;"></i>ملخص الطلبات</h6>
            </div>
            <div class="content-card-body">
                @php
                    $statuses = [
                        ['label'=>'في الانتظار',   'key'=>'pending',     'color'=>'#f59e0b', 'bg'=>'#fffbeb'],
                        ['label'=>'قيد التنفيذ',   'key'=>'in_progress', 'color'=>'#8b5cf6', 'bg'=>'#f5f3ff'],
                        ['label'=>'مكتملة',        'key'=>'completed',   'color'=>'#22c55e', 'bg'=>'#f0fdf4'],
                        ['label'=>'ملغية',         'key'=>'cancelled',   'color'=>'#ef4444', 'bg'=>'#fef2f2'],
                    ];
                    $total = $orders->count();
                @endphp
                @foreach($statuses as $s)
                    @php $count = $orders->where('status', $s['key'])->count(); @endphp
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:10px;height:10px;border-radius:50%;background:{{ $s['color'] }};flex-shrink:0;"></div>
                            <span style="font-size:.85rem;font-weight:600;color:#374151;">{{ $s['label'] }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:80px;height:6px;background:#f1f5f9;border-radius:6px;overflow:hidden;">
                                <div style="width:{{ $total > 0 ? round(($count/$total)*100) : 0 }}%;height:100%;background:{{ $s['color'] }};border-radius:6px;transition:width .5s;"></div>
                            </div>
                            <span style="font-size:.82rem;font-weight:700;color:{{ $s['color'] }};min-width:20px;text-align:center;">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
