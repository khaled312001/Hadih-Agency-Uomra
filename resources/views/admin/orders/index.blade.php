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
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">قائمة الطلبات</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted">إجمالي الطلبات: {{ $orders->total() }}</span>
                                    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>إضافة طلب جديد
                                    </a>
                                </div>
                            </div>
                            
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
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $order->user->name }}</div>
                                                        <small class="text-muted">{{ $order->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $order->umrahPackage->name_ar }}</div>
                                                <small class="text-muted">{{ $order->umrahPackage->duration }}</small>
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
                                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }} px-3 py-2">
                                                    {{ $order->status == 'completed' ? 'مكتمل' : ($order->status == 'pending' ? 'في الانتظار' : $order->status) }}
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
