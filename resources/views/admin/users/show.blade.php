@extends('layouts.admin')

@section('title', 'تفاصيل المستخدم')
@section('page-title', 'تفاصيل المستخدم')
@section('page-description', '{{ $user->name }}')

@section('page-actions')
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning hover-lift">
        <i class="fas fa-edit me-2"></i>تعديل المستخدم
    </a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary hover-lift">
        <i class="fas fa-arrow-right me-2"></i>العودة للمستخدمين
    </a>
@endsection

@section('content')
    <div class="row">
        <!-- User Details -->
        <div class="col-md-8 mb-3">
            <div class="content-card">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-user me-2 text-primary"></i>معلومات المستخدم
                    </h5>
                    <div class="info-table">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>الاسم:</th>
                                <td><strong>{{ $user->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>البريد الإلكتروني:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>الهاتف:</th>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th>الدور:</th>
                                <td>
                                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }} px-3 py-2">
                                        {{ $user->role == 'admin' ? 'مدير' : 'مستخدم' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>الحالة:</th>
                                <td>
                                    <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} px-3 py-2">
                                        {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>تاريخ التسجيل:</th>
                                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <th>آخر تحديث:</th>
                                <td>{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions & Stats -->
        <div class="col-md-4 mb-3">
            <div class="content-card">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-cogs me-2 text-primary"></i>الإجراءات
                    </h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>تعديل المستخدم
                        </a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>حذف المستخدم
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>العودة للمستخدمين
                        </a>
                    </div>
                </div>
            </div>

            <div class="content-card mt-3">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>إحصائيات المستخدم
                    </h5>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $user->orders()->count() }}</h4>
                                <small class="text-muted">إجمالي الطلبات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $user->orders()->where('status', 'completed')->count() }}</h4>
                            <small class="text-muted">طلبات مكتملة</small>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->orders()->count() > 0)
            <div class="content-card mt-3">
                <div class="p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-shopping-cart me-2 text-primary"></i>آخر الطلبات
                    </h5>
                    <div class="list-group list-group-flush">
                        @foreach($user->orders()->latest()->take(3)->get() as $order)
                        <div class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $order->umrahPackage->name_ar }}</h6>
                                    <small class="text-muted">{{ $order->created_at->format('Y-m-d') }}</small>
                                </div>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }}">
                                    @switch($order->status)
                                        @case('pending') في الانتظار @break
                                        @case('completed') مكتمل @break
                                        @default {{ $order->status }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($user->orders()->count() > 3)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.orders.index') }}?user={{ $user->id }}" class="btn btn-outline-primary btn-sm">
                            عرض جميع الطلبات
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
