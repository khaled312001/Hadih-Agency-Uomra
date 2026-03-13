@extends('layouts.admin')

@section('title', 'تفاصيل الطلب')
@section('page-title', 'تفاصيل الطلب')
@section('page-description', 'رقم الطلب: {{ $order->order_number }}')

@section('page-actions')
    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning hover-lift">
        <i class="fas fa-edit me-2"></i>تعديل الطلب
    </a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary hover-lift">
        <i class="fas fa-arrow-right me-2"></i>العودة للطلبات
    </a>
@endsection

@section('content')
    <div class="row">
        <!-- Order Details -->
        <div class="col-md-8 mb-3">
            <div class="content-card">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-info-circle me-2 text-primary"></i>معلومات الطلب
                    </h5>
                    <div class="info-table">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>رقم الطلب:</th>
                                <td><strong>{{ $order->order_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>المشتري:</th>
                                <td>
                                    @if($order->user)
                                        <span class="badge bg-primary">مستخدم مسجل</span> {{ $order->user->name }}
                                    @else
                                        <span class="badge bg-secondary">زائر</span> {{ $order->customer_name }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>الحزمة:</th>
                                <td>{{ $order->umrahPackage ? $order->umrahPackage->name_ar : 'حزمة غير متوفرة' }}</td>
                            </tr>
                            <tr>
                                <th>المستفيد:</th>
                                <td>{{ $order->beneficiary_name }}</td>
                            </tr>
                            <tr>
                                <th>هاتف المستفيد:</th>
                                <td>{{ $order->beneficiary_phone }}</td>
                            </tr>
                            <tr>
                                <th>نوع المستفيد:</th>
                                <td>
                                    @switch($order->beneficiary_type)
                                        @case('deceased') <span class="badge bg-dark">متوفى</span> @break
                                        @case('sick') <span class="badge bg-danger">مريض</span> @break
                                        @case('elderly') <span class="badge bg-warning">مسن</span> @break
                                        @case('disabled') <span class="badge bg-info">معاق</span> @break
                                        @default <span class="badge bg-secondary">غير محدد</span>
                                    @endswitch
                                </td>
                            </tr>
                            @if($order->beneficiary_details)
                            <tr>
                                <th>تفاصيل المستفيد:</th>
                                <td>{{ $order->beneficiary_details }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>المبلغ:</th>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($order->total_amount, 2) }}</span>
                                    <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($order->currency) }}" alt="{{ $order->currency }}" style="width:20px;height:20px;" class="me-1">
                                    {{ $order->currency }}
                                </td>
                            </tr>
                            <tr>
                                <th>الحالة:</th>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'cancelled' ? 'danger' : 'info')) }} px-3 py-2">
                                        @switch($order->status)
                                            @case('pending') في الانتظار @break
                                            @case('assigned') تم التخصيص @break
                                            @case('in_progress') قيد التنفيذ @break
                                            @case('completed') مكتمل @break
                                            @case('cancelled') ملغي @break
                                            @default {{ $order->status }}
                                        @endswitch
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء:</th>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @if($order->updated_at != $order->created_at)
                            <tr>
                                <th>آخر تحديث:</th>
                                <td>{{ $order->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    @if($order->notes)
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">ملاحظات:</h6>
                        <p class="text-muted">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions & Additional Info -->
        <div class="col-md-4 mb-3">
            <div class="content-card">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-cogs me-2 text-primary"></i>الإجراءات
                    </h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>تعديل الطلب
                        </a>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>حذف الطلب
                            </button>
                        </form>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>العودة للطلبات
                        </a>
                    </div>
                </div>
            </div>

            <div class="content-card mt-3">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-user me-2 text-primary"></i>معلومات المستخدم
                    </h5>
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-{{ $order->user ? 'user-circle' : 'user-secret' }} fa-3x text-muted"></i>
                        </div>
                        @if($order->user)
                            <h6>{{ $order->user->name }}</h6>
                            <p class="text-muted mb-2">{{ $order->user->email }}</p>
                            <p class="text-muted mb-3">{{ $order->user->phone }}</p>
                            <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>عرض الملف الشخصي
                            </a>
                        @else
                            <h6>{{ $order->customer_name }}</h6>
                            <p class="text-muted mb-2">{{ $order->customer_email }}</p>
                            <p class="text-muted mb-3">{{ $order->customer_phone }}</p>
                            <span class="badge bg-light text-dark border">طلب كزائر</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="content-card mt-3">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-box me-2 text-primary"></i>معلومات الحزمة
                    </h5>
                    <div class="text-center">
                        @if($order->umrahPackage)
                            <h6>{{ $order->umrahPackage->name_ar }}</h6>
                            <p class="text-muted mb-2">{{ $order->umrahPackage->duration ?? 'غير محدد' }}</p>
                            <p class="text-success fw-bold mb-3">
                                {{ number_format($order->umrahPackage->price, 2) }} {{ $order->umrahPackage->currency }}
                            </p>
                            <a href="{{ route('admin.packages.show', $order->umrahPackage) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>عرض الحزمة
                            </a>
                        @else
                            <h6 class="text-muted">الحزمة غير متوفرة</h6>
                            <p class="small text-danger">ربما تم حذف هذه الحزمة</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
