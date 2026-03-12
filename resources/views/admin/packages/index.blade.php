@extends('layouts.admin')

@section('title', 'إدارة حزم العمرة')
@section('page-title', 'إدارة حزم العمرة')
@section('page-description', 'إدارة حزم العمرة المتاحة في النظام')

@section('page-actions')
    <a href="{{ route('admin.packages.create') }}" class="hd-btn hd-btn--primary">
        <i class="fas fa-plus"></i> إضافة حزمة
    </a>
@endsection

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:var(--hd-grad-primary);">
                <i class="fas fa-box"></i>
            </div>
            <div class="hd-stat__value">{{ $packages->total() }}</div>
            <div class="hd-stat__label">إجمالي الحزم</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="hd-stat__value" style="color:#22c55e;">{{ $packages->where('is_active',true)->count() }}</div>
            <div class="hd-stat__label">نشطة</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#94a3b8,#64748b);">
                <i class="fas fa-ban"></i>
            </div>
            <div class="hd-stat__value" style="color:#94a3b8;">{{ $packages->where('is_active',false)->count() }}</div>
            <div class="hd-stat__label">غير نشطة</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                <i class="fas fa-star"></i>
            </div>
            <div class="hd-stat__value" style="color:#f59e0b;">
                {{ $packages->isNotEmpty() ? number_format($packages->avg('price'), 0) : '0' }}
            </div>
            <div class="hd-stat__label">متوسط السعر</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="hd-card">
    <div class="hd-card-header">
        <div class="hd-card-header__left">
            <div class="hd-card-header__icon" style="background:var(--hd-grad-primary);">
                <i class="fas fa-kaaba"></i>
            </div>
            <span class="hd-card-header__title">قائمة حزم العمرة</span>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="hd-btn hd-btn--primary hd-btn--sm">
            <i class="fas fa-plus"></i> إضافة
        </a>
    </div>
    <div class="hd-card-body--sm p-0">
        <div class="table-responsive">
            <table class="hd-table">
                <thead>
                    <tr>
                        <th>الحزمة</th>
                        <th>السعر</th>
                        <th>المدة</th>
                        <th>الترتيب</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                    <tr>
                        <td>
                            <div class="hd-user-cell">
                                <div class="hd-avatar hd-avatar--sm" style="background:var(--hd-grad-primary);">
                                    <i class="fas fa-kaaba" style="font-size:.85rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;font-size:.875rem;">{{ $package->name_ar }}</div>
                                    @if($package->name_en)
                                        <div style="font-size:.72rem;color:#94a3b8;" dir="ltr">{{ $package->name_en }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:800;font-size:1rem;color:#22c55e;">
                                {{ number_format($package->price) }}
                                <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($package->currency) }}"
                                     alt="{{ $package->currency }}"
                                     style="width:16px;height:16px;border-radius:50%;vertical-align:middle;margin: 0 .25rem;">
                                <span style="font-size:.8rem;">{{ $package->currency }}</span>
                            </div>
                        </td>
                        <td>
                            @if($package->duration)
                                <span class="hd-badge" style="background:#eff6ff;color:#3b82f6;">
                                    <i class="fas fa-clock"></i> {{ $package->duration }}
                                </span>
                            @else
                                <span style="color:#94a3b8;font-size:.82rem;">غير محدد</span>
                            @endif
                        </td>
                        <td>
                            <span class="hd-badge" style="background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;">
                                {{ $package->sort_order }}
                            </span>
                        </td>
                        <td>
                            <span class="hd-badge {{ $package->is_active ? 'hd-badge--active' : 'hd-badge--inactive' }}">
                                <i class="fas fa-circle" style="font-size:.45rem;"></i>
                                {{ $package->is_active ? 'نشطة' : 'غير نشطة' }}
                            </span>
                        </td>
                        <td>
                            <div class="hd-actions">
                                <a href="{{ route('admin.packages.show', $package) }}" class="hd-action-btn hd-action-btn--view" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.packages.edit', $package) }}" class="hd-action-btn hd-action-btn--edit" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" class="d-inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الحزمة؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="hd-action-btn hd-action-btn--delete" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="hd-empty">
                                <div class="hd-empty__icon"><i class="fas fa-box-open"></i></div>
                                <div class="hd-empty__title">لا توجد حزم</div>
                                <div class="hd-empty__sub">لم يتم إضافة أي حزم عمرة بعد</div>
                                <a href="{{ route('admin.packages.create') }}" class="hd-btn hd-btn--primary hd-btn--sm mt-2">
                                    <i class="fas fa-plus"></i> إضافة حزمة
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($packages->hasPages())
        <div class="p-3 d-flex justify-content-center">
            {{ $packages->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
