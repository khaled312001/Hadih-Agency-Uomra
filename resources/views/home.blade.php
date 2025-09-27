@extends('layouts.user')

@section('title', 'الصفحة الرئيسية - هدية')
@section('page-title', 'الصفحة الرئيسية')
@section('page-description', 'مرحباً بك في هدية - تطبيق العمرة الإلكتروني')

@section('content')
<div class="row" >
    <div class="col-12" >
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3" >
            <div>
                <h2 class="mb-1">مرحباً بك، {{ auth()->user()->name }}</h2>
                <p class="text-muted mb-0">مرحباً بك في هدية - تطبيق العمرة الإلكتروني</p>
            </div>
            
        </div>
    </div>
</div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">طلباتك الأخيرة</h5>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>حزمة العمرة</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->umrahPackage->name ?? 'غير محدد' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ $order->status === 'completed' ? 'مكتمل' : ($order->status === 'pending' ? 'في الانتظار' : $order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Mobile Card View -->
                        <div class="d-md-none">
                            @foreach($orders as $order)
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">طلب #{{ $order->id }}</h6>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ $order->status === 'completed' ? 'مكتمل' : ($order->status === 'pending' ? 'في الانتظار' : $order->status) }}
                                            </span>
                                        </div>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-box me-2"></i>
                                            {{ $order->umrahPackage->name ?? 'غير محدد' }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-calendar me-2"></i>
                                            {{ $order->created_at->format('Y-m-d') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">عرض جميع الطلبات</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="text-muted">لا توجد طلبات بعد</p>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">طلب جديد</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-4 mt-4 mt-lg-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">إجراءات سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>طلب جديد
                        </a>
                        <a href="{{ route('messages.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-envelope me-2"></i>الرسائل
                        </a>
                        <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user me-2"></i>الملف الشخصي
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Quick Stats -->
            <div class="card mt-3 d-lg-none">
                <div class="card-header">
                    <h6 class="mb-0">إحصائيات سريعة</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="metric-card">
                                <div class="metric-number">{{ $orders->count() }}</div>
                                <div class="metric-label">الطلبات</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="metric-card">
                                <div class="metric-number">{{ $orders->where('status', 'completed')->count() }}</div>
                                <div class="metric-label">مكتملة</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="metric-card">
                                <div class="metric-number">{{ $orders->where('status', 'pending')->count() }}</div>
                                <div class="metric-label">في الانتظار</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
