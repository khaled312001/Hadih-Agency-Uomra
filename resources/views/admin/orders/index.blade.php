@extends('layouts.admin')

@section('title', 'إدارة الطلبات')
@section('page-title', 'إدارة الطلبات')
@section('page-description', 'إدارة جميع الطلبات في النظام')

@section('page-actions')
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary hover-lift">
        <i class="fas fa-plus me-2 icon-animated"></i>إضافة طلب جديد
    </a>
@endsection

@section('content')
                    
                    <!-- Orders Table -->
                    <div class="content-card">
                        <div class="content-card-header">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px;height:36px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div>
                                    <h6 style="margin:0;font-weight:700;color:#1e293b;">قائمة الطلبات</h6>
                                    <div style="font-size:.75rem;color:#94a3b8;">إجمالي: {{ $orders->total() }} طلب</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> طلب جديد
                            </a>
                        </div>
                        <div class="p-0">
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>المستخدم</th>
                                            <th>الحزمة</th>
                                            <th>المستفيد</th>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-{{ $order->user ? 'primary' : 'secondary' }} text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-{{ $order->user ? 'user' : 'user-secret' }}"></i>
                                                    </div>
                                                    <div>
                                                        @if($order->user)
                                                            <div class="fw-bold">{{ $order->user->name }}</div>
                                                            <small class="text-muted">{{ $order->user->email }}</small>
                                                        @else
                                                            <div class="fw-bold">{{ $order->customer_name ?? 'زائر' }}</div>
                                                            <small class="text-muted">{{ $order->customer_email ?? 'بدون بريد' }}</small>
                                                            <span class="badge bg-light text-dark border ms-1" style="font-size: .65rem;">طلب زائر</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $order->umrahPackage ? $order->umrahPackage->name_ar : 'حزمة غير متوفرة' }}</div>
                                                <small class="text-muted">{{ $order->umrahPackage->duration ?? '' }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $order->beneficiary_name }}</div>
                                                @if($order->beneficiary_phone)
                                                <small class="text-muted">{{ $order->beneficiary_phone }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">
                                                    {{ number_format($order->total_amount) }}
                                                    <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($order->currency) }}" alt="{{ $order->currency }}" class="currency-icon me-1" style="width: 16px; height: 16px;">
                                                    {{ $order->currency }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge status-{{ $order->status }}">
                                                    @switch($order->status)
                                                        @case('pending')     <i class="fas fa-clock"></i> في الانتظار   @break
                                                        @case('confirmed')   <i class="fas fa-check"></i> مؤكد          @break
                                                        @case('assigned')    <i class="fas fa-user-check"></i> مُكلَّف   @break
                                                        @case('in_progress') <i class="fas fa-spinner"></i> قيد التنفيذ  @break
                                                        @case('completed')   <i class="fas fa-check-circle"></i> مكتمل  @break
                                                        @case('cancelled')   <i class="fas fa-times-circle"></i> ملغي    @break
                                                        @default {{ $order->status }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>
                                                <div>{{ $order->created_at->format('Y-m-d') }}</div>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                                    <div>لا توجد طلبات حالياً</div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($orders->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $orders->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
@endsection
