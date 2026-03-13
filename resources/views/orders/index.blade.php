@extends('layouts.user')

@section('title', 'طلباتي - هدية')
@section('page-title', 'طلباتي')
@section('page-description', 'إدارة ومتابعة طلبات العمرة الخاصة بك')

@section('page-actions')
<a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus"></i>
    <span class="d-none d-sm-inline">طلب جديد</span>
</a>
@endsection

@section('content')

@if($orders->count() > 0)
    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-3">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="fas fa-clock"></i></div>
                <div class="stat-number">{{ $orders->where('status','pending')->count() }}</div>
                <div class="stat-label">في الانتظار</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="stat-card cyan">
                <div class="stat-icon cyan"><i class="fas fa-user-check"></i></div>
                <div class="stat-number">{{ $orders->where('status','assigned')->count() + $orders->where('status','in_progress')->count() }}</div>
                <div class="stat-label">قيد التنفيذ</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="stat-card green">
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number">{{ $orders->where('status','completed')->count() }}</div>
                <div class="stat-label">مكتملة</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="stat-card orange">
                <div class="stat-icon orange"><i class="fas fa-times-circle"></i></div>
                <div class="stat-number">{{ $orders->where('status','cancelled')->count() }}</div>
                <div class="stat-label">ملغية</div>
            </div>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="row g-3">
        @foreach($orders as $order)
        <div class="col-12 col-md-6 col-xl-4">
            <div class="order-card h-100">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div>
                        <div style="font-weight:800;color:#667eea;font-size:.95rem;">{{ $order->order_number }}</div>
                        <div style="font-size:.75rem;color:#94a3b8;margin-top:.15rem;">
                            <i class="fas fa-calendar-alt me-1"></i>{{ $order->created_at->format('Y/m/d - H:i') }}
                        </div>
                    </div>
                    <span class="status-badge status-{{ $order->status }}">
                        @switch($order->status)
                            @case('pending')     <i class="fas fa-clock"></i> في الانتظار   @break
                            @case('confirmed')   <i class="fas fa-check"></i> مؤكد          @break
                            @case('assigned')    <i class="fas fa-user-check"></i> مُكلَّف   @break
                            @case('in_progress') <i class="fas fa-spinner fa-spin"></i> جاري  @break
                            @case('completed')   <i class="fas fa-check-circle"></i> مكتمل   @break
                            @case('cancelled')   <i class="fas fa-times-circle"></i> ملغي     @break
                            @default {{ $order->status }}
                        @endswitch
                    </span>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Beneficiary -->
                    <div style="display:flex;align-items:flex-start;gap:.6rem;margin-bottom:.85rem;padding:.75rem;background:#f8fafc;border-radius:10px;">
                        <div style="width:34px;height:34px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.85rem;flex-shrink:0;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div style="font-size:.75rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.4px;">المستفيد</div>
                            <div style="font-weight:700;color:#1e293b;font-size:.9rem;">{{ $order->beneficiary_name }}</div>
                            <div style="font-size:.78rem;color:#64748b;" dir="ltr">{{ $order->beneficiary_phone }}</div>
                        </div>
                    </div>

                    <!-- Package -->
                    <div style="display:flex;align-items:flex-start;gap:.6rem;margin-bottom:.85rem;padding:.75rem;background:#f0fdf4;border-radius:10px;border:1px solid #dcfce7;">
                        <div style="width:34px;height:34px;background:linear-gradient(135deg,#11998e,#38ef7d);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.85rem;flex-shrink:0;">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:.75rem;color:#166534;font-weight:600;text-transform:uppercase;letter-spacing:.4px;">الحزمة</div>
                            <div style="font-weight:700;color:#1e293b;font-size:.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $order->umrahPackage ? $order->umrahPackage->name_ar : 'غير محدد' }}</div>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <span style="font-weight:800;color:#059669;font-size:.95rem;">{{ number_format($order->total_amount) }} <small style="font-size:.7rem;font-weight:600;">{{ $order->currency ?? 'SAR' }}</small></span>
                                @if($order->umrahPackage && $order->umrahPackage->duration)
                                    <span style="font-size:.75rem;color:#94a3b8;"><i class="fas fa-clock me-1"></i>{{ $order->umrahPackage->duration }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($order->notes)
                    <div style="background:#fffbeb;border-radius:10px;padding:.65rem .8rem;border-right:3px solid #f59e0b;">
                        <div style="font-size:.75rem;color:#92400e;font-weight:700;margin-bottom:.2rem;"><i class="fas fa-sticky-note me-1"></i>ملاحظات</div>
                        <div style="font-size:.82rem;color:#78350f;">{{ Str::limit($order->notes, 80) }}</div>
                    </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="card-footer">
                    <div class="d-flex gap-2">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm flex-fill" style="border-radius:10px;">
                            <i class="fas fa-eye"></i> التفاصيل
                        </a>
                        <a href="{{ route('messages.create') }}?order={{ $order->id }}" style="flex:1;background:#f0fdf4;border:2px solid #dcfce7;border-radius:10px;padding:.35rem .75rem;font-size:.8rem;font-weight:600;color:#166534;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.35rem;transition:all .2s;">
                            <i class="fas fa-comment-dots"></i> مراسلة
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="content-card">
                <div class="content-card-body empty-state">
                    <div class="empty-state-icon" style="width:90px;height:90px;background:linear-gradient(135deg,rgba(102,126,234,.1),rgba(118,75,162,.1));margin:0 auto 1.5rem;">
                        <i class="fas fa-shopping-cart" style="font-size:2.2rem;color:#667eea;"></i>
                    </div>
                    <h4 style="font-weight:800;color:#1e293b;margin-bottom:.5rem;">لا توجد طلبات حالياً</h4>
                    <p style="color:#94a3b8;font-size:.9rem;margin-bottom:1.75rem;line-height:1.7;">ابدأ رحلتك الروحانية بتقديم أول طلب عمرة ونحن نتولى الباقي</p>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle"></i> طلب عمرة جديد
                    </a>
                    <div class="mt-3">
                        <a href="{{ url('/') }}" style="font-size:.85rem;color:#94a3b8;text-decoration:none;">
                            <i class="fas fa-arrow-right me-1"></i> العودة للرئيسية
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
