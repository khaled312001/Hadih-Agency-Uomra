@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين')
@section('page-description', 'إدارة المستخدمين المسجلين في النظام')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="hd-btn hd-btn--primary">
        <i class="fas fa-plus"></i> إضافة مستخدم
    </a>
@endsection

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:var(--hd-grad-primary);">
                <i class="fas fa-users"></i>
            </div>
            <div class="hd-stat__value">{{ $users->total() }}</div>
            <div class="hd-stat__label">إجمالي المستخدمين</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="hd-stat__value" style="color:#22c55e;">{{ $users->where('is_active',true)->count() }}</div>
            <div class="hd-stat__label">نشطون</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="hd-stat__value" style="color:#ef4444;">{{ $users->where('role','admin')->count() }}</div>
            <div class="hd-stat__label">المشرفون</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="hd-stat__value" style="color:#f59e0b;">{{ $users->where('is_active',false)->count() }}</div>
            <div class="hd-stat__label">غير نشطين</div>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="hd-card">
    <div class="hd-card-header">
        <div class="hd-card-header__left">
            <div class="hd-card-header__icon" style="background:var(--hd-grad-primary);">
                <i class="fas fa-users"></i>
            </div>
            <span class="hd-card-header__title">قائمة المستخدمين</span>
        </div>
        <a href="{{ route('admin.users.create') }}" class="hd-btn hd-btn--primary hd-btn--sm">
            <i class="fas fa-plus"></i> إضافة
        </a>
    </div>
    <div class="hd-card-body--sm p-0">
        <div class="table-responsive">
            <table class="hd-table">
                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الهاتف</th>
                        <th>الدور</th>
                        <th>الحالة</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="hd-user-cell">
                                <div class="hd-avatar hd-avatar--sm"
                                     style="background:{{ $user->role==='admin' ? 'linear-gradient(135deg,#ef4444,#dc2626)' : 'var(--hd-grad-primary)' }};">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}"
                                             style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                    @else
                                        {{ mb_substr($user->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight:700;font-size:.875rem;">{{ $user->name }}</div>
                                    <div style="font-size:.72rem;color:#94a3b8;">#{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:.875rem;">{{ $user->email }}</div>
                            @if($user->email_verified_at)
                                <div style="font-size:.72rem;color:#22c55e;"><i class="fas fa-check-circle me-1"></i>مؤكد</div>
                            @else
                                <div style="font-size:.72rem;color:#f59e0b;"><i class="fas fa-exclamation-circle me-1"></i>غير مؤكد</div>
                            @endif
                        </td>
                        <td>
                            @if($user->phone)
                                <span dir="ltr" style="font-size:.875rem;">{{ $user->country_code }} {{ $user->phone }}</span>
                            @else
                                <span style="color:#94a3b8;font-size:.82rem;">غير محدد</span>
                            @endif
                        </td>
                        <td>
                            <span class="hd-badge {{ $user->role==='admin' ? 'hd-badge--admin' : 'hd-badge--user' }}">
                                <i class="fas fa-{{ $user->role==='admin' ? 'shield-alt' : 'user' }}"></i>
                                {{ $user->role==='admin' ? 'مدير' : 'مستخدم' }}
                            </span>
                        </td>
                        <td>
                            <span class="hd-badge {{ $user->is_active ? 'hd-badge--active' : 'hd-badge--inactive' }}">
                                <i class="fas fa-circle" style="font-size:.45rem;"></i>
                                {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size:.82rem;">{{ $user->created_at->format('Y/m/d') }}</div>
                            <div style="font-size:.72rem;color:#94a3b8;">{{ $user->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            <div class="hd-actions">
                                <a href="{{ route('admin.users.show', $user) }}" class="hd-action-btn hd-action-btn--view" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="hd-action-btn hd-action-btn--edit" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="hd-action-btn hd-action-btn--delete" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="hd-empty">
                                <div class="hd-empty__icon"><i class="fas fa-users"></i></div>
                                <div class="hd-empty__title">لا يوجد مستخدمون</div>
                                <div class="hd-empty__sub">لم يتم تسجيل أي مستخدمين بعد</div>
                                <a href="{{ route('admin.users.create') }}" class="hd-btn hd-btn--primary hd-btn--sm mt-2">
                                    <i class="fas fa-plus"></i> إضافة مستخدم
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-3 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
