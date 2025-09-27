@extends('layouts.user')

@section('title', 'تفاصيل الطلب - هدية')
@section('page-title', 'تفاصيل الطلب')
@section('page-description', 'عرض تفاصيل طلب العمرة')

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-1 text-primary">
                        <i class="fas fa-shopping-cart me-2"></i>تفاصيل الطلب
                    </h2>
                    <p class="text-muted mb-0">رقم الطلب: {{ $order->order_number }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>تعديل الطلب
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للطلبات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        معلومات الطلب
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th class="text-muted" style="width: 30%;">رقم الطلب:</th>
                                    <td><strong class="text-primary">{{ $order->order_number }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="text-muted">الحزمة:</th>
                                    <td>{{ $order->umrahPackage->name_ar }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">المستفيد:</th>
                                    <td>{{ $order->beneficiary_name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">هاتف المستفيد:</th>
                                    <td>{{ $order->beneficiary_phone }}</td>
                                </tr>
                                @if($order->whatsapp_phone)
                                <tr>
                                    <th class="text-muted">واتساب:</th>
                                    <td>{{ $order->whatsapp_country_code }}{{ $order->whatsapp_phone }}</td>
                                </tr>
                                @endif
                                @if($order->beneficiary_address)
                                <tr>
                                    <th class="text-muted">عنوان المستفيد:</th>
                                    <td>{{ $order->beneficiary_address }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th class="text-muted">نوع المستفيد:</th>
                                    <td>{{ $order->beneficiary_type }}</td>
                                </tr>
                                @if($order->beneficiary_details)
                                <tr>
                                    <th class="text-muted">تفاصيل المستفيد:</th>
                                    <td>{{ $order->beneficiary_details }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th class="text-muted">المبلغ:</th>
                                    <td>
                                        <span class="fw-bold text-success fs-5">{{ number_format($order->total_amount, 2) }}</span>
                                        <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($order->currency) }}" alt="{{ $order->currency }}" class="currency-icon me-1">
                                        {{ $order->currency }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">الحالة:</th>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'cancelled' ? 'danger' : 'info')) }} px-3 py-2 fs-6">
                                            @switch($order->status)
                                                @case('pending')
                                                    في الانتظار
                                                    @break
                                                @case('assigned')
                                                    تم التخصيص
                                                    @break
                                                @case('in_progress')
                                                    قيد التنفيذ
                                                    @break
                                                @case('completed')
                                                    مكتمل
                                                    @break
                                                @case('cancelled')
                                                    ملغي
                                                    @break
                                                @default
                                                    {{ $order->status }}
                                            @endswitch
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">تاريخ الإنشاء:</th>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                @if($order->updated_at != $order->created_at)
                                <tr>
                                    <th class="text-muted">آخر تحديث:</th>
                                    <td>{{ $order->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                @endif
                                @if($order->assigned_at)
                                <tr>
                                    <th class="text-muted">تاريخ التخصيص:</th>
                                    <td>{{ $order->assigned_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                @endif
                                @if($order->completed_at)
                                <tr>
                                    <th class="text-muted">تاريخ الإكمال:</th>
                                    <td>{{ $order->completed_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    @if($order->notes)
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">ملاحظات:</h6>
                        <div class="alert alert-light border">
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Package Info & Actions -->
        <div class="col-md-4">
            <!-- Package Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-box me-2 text-primary"></i>
                        معلومات الحزمة
                    </h5>
                    
                    <div class="text-center">
                        @if($order->umrahPackage->image)
                        <img src="{{ asset('storage/' . $order->umrahPackage->image) }}" alt="{{ $order->umrahPackage->name_ar }}" class="img-fluid rounded mb-3" style="max-height: 150px;">
                        @else
                        <div class="bg-light rounded p-4 mb-3">
                            <i class="fas fa-box fa-3x text-muted"></i>
                        </div>
                        @endif
                        
                        <h6 class="fw-bold">{{ $order->umrahPackage->name_ar }}</h6>
                        @if($order->umrahPackage->description_ar)
                        <p class="text-muted small mb-2">{{ Str::limit($order->umrahPackage->description_ar, 100) }}</p>
                        @endif
                        @if($order->umrahPackage->duration)
                        <p class="text-muted mb-2">
                            <i class="fas fa-clock me-1"></i>{{ $order->umrahPackage->duration }}
                        </p>
                        @endif
                        <p class="text-success fw-bold mb-3 fs-5">
                            {{ number_format($order->umrahPackage->price, 2) }} {{ $order->umrahPackage->currency }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-cogs me-2 text-primary"></i>
                        الإجراءات
                    </h5>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>تعديل الطلب
                        </a>
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>العودة للطلبات
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>الصفحة الرئيسية
                        </a>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            @if($order->payments->count() > 0)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-credit-card me-2 text-primary"></i>
                        معلومات الدفع
                    </h5>
                    
                    @foreach($order->payments as $payment)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">{{ $payment->payment_id }}</span>
                            <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                @switch($payment->status)
                                    @case('pending')
                                        في الانتظار
                                        @break
                                    @case('completed')
                                        مكتمل
                                        @break
                                    @case('failed')
                                        فشل
                                        @break
                                    @default
                                        {{ $payment->status }}
                                @endswitch
                            </span>
                        </div>
                        <div class="mt-2">
                            <span class="text-success fw-bold">{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</span>
                        </div>
                        <small class="text-muted">{{ $payment->created_at->format('Y-m-d H:i') }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection