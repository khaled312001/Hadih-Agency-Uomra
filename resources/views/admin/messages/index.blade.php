@extends('layouts.admin')

@section('title', 'إدارة الرسائل - هدية')
@section('page-title', 'إدارة الرسائل')
@section('page-description', 'إدارة ومتابعة جميع الرسائل في النظام')

@section('page-actions')
    <a href="{{ route('admin.messages.create') }}" class="hd-btn hd-btn--primary">
        <i class="fas fa-plus"></i> رسالة جديدة
    </a>
@endsection

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:var(--hd-grad-primary);">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="hd-stat__value">{{ $messages->total() }}</div>
            <div class="hd-stat__label">إجمالي الرسائل</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                <i class="fas fa-envelope-open"></i>
            </div>
            <div class="hd-stat__value" style="color:#f59e0b;">{{ $messages->where('is_read', false)->count() }}</div>
            <div class="hd-stat__label">غير مقروءة</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="hd-stat__value" style="color:#22c55e;">{{ $messages->where('is_read', true)->count() }}</div>
            <div class="hd-stat__label">مقروءة</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <i class="fas fa-users"></i>
            </div>
            <div class="hd-stat__value" style="color:#3b82f6;">{{ $messages->pluck('sender_id')->unique()->count() }}</div>
            <div class="hd-stat__label">مستخدمون متفاعلون</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="hd-card">
    <div class="hd-card-header">
        <div class="hd-card-header__left">
            <div class="hd-card-header__icon" style="background:var(--hd-grad-primary);">
                <i class="fas fa-comments"></i>
            </div>
            <span class="hd-card-header__title">قائمة الرسائل</span>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <select class="hd-input hd-select" id="filterStatus" onchange="filterMessages()"
                    style="min-width:150px;font-size:.82rem;padding:.4rem .75rem;height:auto;">
                <option value="">جميع الرسائل</option>
                <option value="unread">غير مقروءة</option>
                <option value="read">مقروءة</option>
            </select>
            <button class="hd-btn hd-btn--ghost hd-btn--sm" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    @if($messages->count() > 0)
    <div class="hd-card-body--sm p-0">
        <div class="table-responsive">
            <table class="hd-table">
                <thead>
                    <tr>
                        <th>المرسل / المستقبل</th>
                        <th>الرسالة</th>
                        <th>الطلب</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                    <tr class="message-row {{ !$message->is_read && $message->receiver_id === auth()->id() ? 'unread-row' : '' }}">
                        <td>
                            <div class="hd-user-cell">
                                <div class="hd-avatar hd-avatar--sm"
                                     style="background:{{ $message->sender->role==='admin' ? 'linear-gradient(135deg,#f59e0b,#f97316)' : 'var(--hd-grad-primary)' }};">
                                    {{ mb_substr($message->sender->name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight:700;font-size:.82rem;">
                                        {{ $message->sender->name }}
                                        @if($message->sender->role === 'admin')
                                            <i class="fas fa-crown" style="color:#f59e0b;font-size:.7rem;margin-right:.2rem;"></i>
                                        @endif
                                    </div>
                                    <div style="font-size:.72rem;color:#94a3b8;">إلى: {{ $message->receiver->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($message->subject)
                                <div style="font-weight:700;font-size:.82rem;color:#1e293b;">{{ $message->subject }}</div>
                            @endif
                            <div style="font-size:.8rem;color:#64748b;">{{ Str::limit($message->message, 60) }}</div>
                            <div style="font-size:.72rem;color:#94a3b8;margin-top:.2rem;">
                                @php $ticons = ['text'=>'font','image'=>'image','video'=>'video','file'=>'file']; @endphp
                                <i class="fas fa-{{ $ticons[$message->type] ?? 'font' }} me-1"></i>
                                {{ ['text'=>'نص','image'=>'صورة','video'=>'فيديو','file'=>'ملف'][$message->type] ?? $message->type }}
                            </div>
                        </td>
                        <td>
                            @if($message->order)
                                <span class="hd-badge" style="background:#eff6ff;color:#3b82f6;">
                                    <i class="fas fa-shopping-cart"></i> {{ $message->order->order_number }}
                                </span>
                            @else
                                <span style="color:#94a3b8;font-size:.8rem;">عام</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:.82rem;">{{ $message->created_at->format('Y/m/d') }}</div>
                            <div style="font-size:.72rem;color:#94a3b8;">{{ $message->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            @if($message->receiver_id === auth()->id())
                                @if($message->is_read)
                                    <span class="hd-badge hd-badge--active" data-status="read">
                                        <i class="fas fa-check-double"></i> مقروءة
                                    </span>
                                @else
                                    <span class="hd-badge hd-badge--pending" data-status="unread">
                                        <i class="fas fa-envelope"></i> غير مقروءة
                                    </span>
                                @endif
                            @else
                                <span class="hd-badge" style="background:#eff0fe;color:#667eea;">
                                    <i class="fas fa-paper-plane"></i> مرسلة
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="hd-actions">
                                <a href="{{ route('admin.messages.show', $message) }}" class="hd-action-btn hd-action-btn--view" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($message->sender_id === auth()->id())
                                <a href="{{ route('admin.messages.edit', $message) }}" class="hd-action-btn hd-action-btn--edit" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="d-inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="hd-action-btn hd-action-btn--delete" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
        <div class="p-3 d-flex justify-content-center">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
    @else
    <div class="hd-card-body--sm">
        <div class="hd-empty">
            <div class="hd-empty__icon"><i class="fas fa-comments"></i></div>
            <div class="hd-empty__title">لا توجد رسائل</div>
            <div class="hd-empty__sub">ابدأ المحادثة مع المستخدمين</div>
            <a href="{{ route('admin.messages.create') }}" class="hd-btn hd-btn--primary hd-btn--sm mt-2">
                <i class="fas fa-plus"></i> رسالة جديدة
            </a>
        </div>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
function filterMessages() {
    const filter = document.getElementById('filterStatus').value;
    document.querySelectorAll('.message-row').forEach(row => {
        if (!filter) { row.style.display = ''; return; }
        const badge = row.querySelector('[data-status]');
        const status = badge ? badge.getAttribute('data-status') : '';
        row.style.display = (filter === status) ? '' : 'none';
    });
}
</script>
<style>
.unread-row { background: #fffbeb; }
.unread-row:hover { background: #fef9c3 !important; }
</style>
@endsection
