@extends('layouts.user')

@section('title', 'الرسائل - هدية')
@section('page-title', 'الرسائل')
@section('page-description', 'تواصل مع فريق العمل ومتابعة المحادثات')

@section('page-actions')
<a href="{{ route('messages.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus"></i>
    <span class="d-none d-sm-inline">رسالة جديدة</span>
</a>
@endsection

@section('content')

@if($messages->count() > 0)
    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-4">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="fas fa-envelope"></i></div>
                <div class="stat-number">{{ $messages->count() }}</div>
                <div class="stat-label">إجمالي الرسائل</div>
            </div>
        </div>
        <div class="col-6 col-sm-4">
            <div class="stat-card orange">
                <div class="stat-icon orange"><i class="fas fa-envelope-open-text"></i></div>
                <div class="stat-number">{{ $messages->where('is_read', false)->count() }}</div>
                <div class="stat-label">غير مقروءة</div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="stat-card green">
                <div class="stat-icon green"><i class="fas fa-paper-plane"></i></div>
                <div class="stat-number">{{ $messages->where('sender_id', auth()->id())->count() }}</div>
                <div class="stat-label">رسائل مرسلة</div>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex align-items-center gap-2">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;">
                    <i class="fas fa-inbox"></i>
                </div>
                <h6>صندوق الرسائل</h6>
            </div>
            <div class="d-flex align-items-center gap-2">
                <select class="form-select form-select-sm" id="filterStatus" onchange="filterMessages()" style="width:auto;border-radius:8px;font-size:.82rem;">
                    <option value="">جميع الرسائل</option>
                    <option value="unread">غير مقروءة</option>
                    <option value="read">مقروءة</option>
                    <option value="sent">مرسلة</option>
                </select>
                <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="d-none d-md-block">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>المحادثة</th>
                            <th>الموضوع</th>
                            <th>الطلب</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr class="message-row" style="{{ !$message->is_read && $message->receiver_id === auth()->id() ? 'background:rgba(245,158,11,.04);' : '' }}">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($message->sender_id === auth()->id())
                                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#11998e,#38ef7d);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.85rem;flex-shrink:0;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight:700;font-size:.88rem;color:#166534;">أنت</div>
                                            <div style="font-size:.75rem;color:#94a3b8;">إلى: {{ $message->receiver->name }}</div>
                                        </div>
                                    @else
                                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.85rem;flex-shrink:0;">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight:700;font-size:.88rem;color:#1e293b;">{{ $message->sender->name }}</div>
                                            <div style="font-size:.75rem;color:#94a3b8;">إليك</div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($message->subject)
                                    <div style="font-weight:700;font-size:.875rem;color:#1e293b;margin-bottom:.15rem;">{{ $message->subject }}</div>
                                @endif
                                <div style="font-size:.82rem;color:#64748b;">{{ Str::limit($message->message, 55) }}</div>
                            </td>
                            <td>
                                @if($message->order)
                                    <span style="background:#eff6ff;color:#1e40af;border-radius:6px;padding:.25rem .7rem;font-size:.75rem;font-weight:700;">
                                        {{ $message->order->order_number }}
                                    </span>
                                @else
                                    <span style="color:#94a3b8;font-size:.82rem;">عام</span>
                                @endif
                            </td>
                            <td style="color:#94a3b8;font-size:.8rem;white-space:nowrap;">
                                <div>{{ $message->created_at->format('Y/m/d') }}</div>
                                <div>{{ $message->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                @if($message->receiver_id === auth()->id())
                                    @if($message->is_read)
                                        <span class="status-badge" style="background:#f0fdf4;color:#166534;">
                                            <i class="fas fa-check-double"></i> مقروءة
                                        </span>
                                    @else
                                        <span class="status-badge" style="background:#fffbeb;color:#92400e;">
                                            <i class="fas fa-envelope"></i> غير مقروءة
                                        </span>
                                    @endif
                                @else
                                    <span class="status-badge" style="background:#eff6ff;color:#1e40af;">
                                        <i class="fas fa-paper-plane"></i> مرسلة
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($message->sender_id === auth()->id())
                                    <a href="{{ route('messages.edit', $message) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    <form method="POST" action="{{ route('messages.destroy', $message) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
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
        </div>

        <!-- Mobile Cards -->
        <div class="d-md-none p-3">
            @foreach($messages as $message)
            <div class="message-row" style="background:{{ !$message->is_read && $message->receiver_id === auth()->id() ? '#fffbeb' : '#f8fafc' }};border-radius:14px;padding:1rem;margin-bottom:.75rem;border:1px solid {{ !$message->is_read && $message->receiver_id === auth()->id() ? '#fde68a' : '#f1f5f9' }};">
                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:34px;height:34px;background:{{ $message->sender_id===auth()->id() ? 'linear-gradient(135deg,#11998e,#38ef7d)' : 'linear-gradient(135deg,#667eea,#764ba2)' }};border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;flex-shrink:0;">
                            <i class="fas fa-{{ $message->sender_id===auth()->id() ? 'user' : 'building' }}"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:.88rem;color:#1e293b;">
                                {{ $message->sender_id===auth()->id() ? 'أنت' : $message->sender->name }}
                            </div>
                            <div style="font-size:.73rem;color:#94a3b8;">{{ $message->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @if($message->receiver_id === auth()->id())
                        <span style="font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:50px;background:{{ $message->is_read ? '#f0fdf4' : '#fffbeb' }};color:{{ $message->is_read ? '#166534' : '#92400e' }};">
                            {{ $message->is_read ? 'مقروءة' : 'غير مقروءة' }}
                        </span>
                    @else
                        <span style="font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:50px;background:#eff6ff;color:#1e40af;">مرسلة</span>
                    @endif
                </div>
                @if($message->subject)
                    <div style="font-weight:700;font-size:.85rem;color:#1e293b;margin-bottom:.3rem;">{{ $message->subject }}</div>
                @endif
                <div style="font-size:.82rem;color:#64748b;margin-bottom:.75rem;">{{ Str::limit($message->message, 80) }}</div>
                <div class="d-flex gap-2">
                    <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="fas fa-eye me-1"></i> عرض
                    </a>
                    @if($message->sender_id === auth()->id())
                    <a href="{{ route('messages.edit', $message) }}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endif
                    <form method="POST" action="{{ route('messages.destroy', $message) }}" onsubmit="return confirm('هل تريد حذف هذه الرسالة؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($messages->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $messages->links() }}
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="content-card">
                <div class="content-card-body empty-state">
                    <div class="empty-state-icon" style="width:90px;height:90px;background:linear-gradient(135deg,rgba(102,126,234,.1),rgba(118,75,162,.1));margin:0 auto 1.5rem;">
                        <i class="fas fa-comments" style="font-size:2.2rem;color:#667eea;"></i>
                    </div>
                    <h4 style="font-weight:800;color:#1e293b;margin-bottom:.5rem;">لا توجد رسائل حالياً</h4>
                    <p style="color:#94a3b8;font-size:.9rem;margin-bottom:1.75rem;">ابدأ المحادثة مع فريق الدعم وأحصل على المساعدة</p>
                    <a href="{{ route('messages.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle"></i> رسالة جديدة
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')
<script>
function filterMessages() {
    const filter = document.getElementById('filterStatus').value;
    document.querySelectorAll('.message-row').forEach(row => {
        let show = true;
        const badges = row.querySelectorAll('[style*="color"]');
        const text = row.innerText;
        if      (filter === 'unread') show = text.includes('غير مقروءة');
        else if (filter === 'read')   show = text.includes('مقروءة') && !text.includes('غير مقروءة');
        else if (filter === 'sent')   show = text.includes('مرسلة');
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endsection
