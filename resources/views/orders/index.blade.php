@extends('layouts.user')

@section('title', 'طلباتي - هدية')
@section('page-title', 'طلباتي')
@section('page-description', 'إدارة ومتابعة طلبات العمرة الخاصة بك')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 text-primary">
                    <i class="fas fa-shopping-cart me-2"></i>طلباتي
                </h3>
                <p class="text-muted mb-0">إدارة ومتابعة طلبات العمرة الخاصة بك</p>
            </div>
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>طلب عمرة جديد
            </a>
        </div>
    </div>
</div>

    @if($orders->count() > 0)
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h4 class="mb-1">{{ $orders->where('status', 'pending')->count() }}</h4>
                        <small>في الانتظار</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check fa-2x mb-2"></i>
                        <h4 class="mb-1">{{ $orders->where('status', 'assigned')->count() }}</h4>
                        <small>تم التكليف</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-spinner fa-2x mb-2"></i>
                        <h4 class="mb-1">{{ $orders->where('status', 'in_progress')->count() }}</h4>
                        <small>قيد التنفيذ</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h4 class="mb-1">{{ $orders->where('status', 'completed')->count() }}</h4>
                        <small>مكتملة</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="row">
            @foreach($orders as $order)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 order-card">
                        <div class="card-header bg-white border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-primary fw-bold">{{ $order->order_number }}</h6>
                                    <small class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</small>
                                </div>
                                <span class="badge status-badge status-{{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending')
                                            <i class="fas fa-clock me-1"></i>في الانتظار
                                            @break
                                        @case('assigned')
                                            <i class="fas fa-user-check me-1"></i>تم التكليف
                                            @break
                                        @case('in_progress')
                                            <i class="fas fa-spinner me-1"></i>قيد التنفيذ
                                            @break
                                        @case('completed')
                                            <i class="fas fa-check-circle me-1"></i>مكتملة
                                            @break
                                        @case('cancelled')
                                            <i class="fas fa-times-circle me-1"></i>ملغية
                                            @break
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-user me-2 text-primary"></i>المستفيد
                                </h6>
                                <p class="mb-1 fw-bold">{{ $order->beneficiary_name }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-phone me-1"></i>{{ $order->beneficiary_phone }}
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-box me-2 text-primary"></i>الحزمة
                                </h6>
                                <p class="mb-1 fw-bold">{{ $order->umrahPackage->name_ar }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-success fw-bold">
                                        {{ number_format($order->total_amount) }} {{ $order->currency }}
                                    </span>
                                    @if($order->umrahPackage->duration)
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>{{ $order->umrahPackage->duration }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            @if($order->notes)
                                <div class="mb-3">
                                    <h6 class="mb-2">
                                        <i class="fas fa-sticky-note me-2 text-primary"></i>ملاحظات
                                    </h6>
                                    <p class="text-muted small">{{ Str::limit($order->notes, 100) }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-footer bg-white border-0 pt-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="fas fa-eye me-1"></i>عرض التفاصيل
                                </a>
                                <a href="{{ route('messages.create') }}?order={{ $order->id }}" class="btn btn-outline-success btn-sm flex-fill">
                                    <i class="fas fa-comment me-1"></i>مراسلة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-3">لا توجد طلبات حالياً</h4>
                        <p class="text-muted mb-4">ابدأ رحلتك الروحية بطلب عمرة جديدة</p>
                        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>طلب عمرة جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

<style>
.order-card {
    transition: all 0.3s ease;
    border-radius: 15px;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}

.status-pending {
    background-color: #6c757d;
    color: white;
}

.status-assigned {
    background-color: #17a2b8;
    color: white;
}

.status-in_progress {
    background-color: #ffc107;
    color: #212529;
}

.status-completed {
    background-color: #28a745;
    color: white;
}

.status-cancelled {
    background-color: #dc3545;
    color: white;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.card-footer {
    border-radius: 0 0 15px 15px !important;
}

.btn {
    border-radius: 10px;
    font-weight: 500;
}

.btn-outline-primary:hover,
.btn-outline-success:hover {
    transform: translateY(-1px);
}
</style>
@endsection