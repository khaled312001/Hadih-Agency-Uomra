@extends('layouts.user')

@section('title', 'الرسائل - هدية')
@section('page-title', 'الرسائل')
@section('page-description', 'تواصل مع فريق العمل ومتابعة المحادثات')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 text-primary">
                    <i class="fas fa-comments me-2"></i>الرسائل
                </h3>
                <p class="text-muted mb-0">تواصل مع فريق العمل ومتابعة المحادثات</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('messages.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>رسالة جديدة
                </a>
                <button class="btn btn-outline-primary btn-lg" onclick="refreshMessages()">
                    <i class="fas fa-sync-alt me-2"></i>تحديث
                </button>
            </div>
        </div>
    </div>
</div>

    @if($messages->count() > 0)
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope fa-2x mb-2"></i>
                        <h4 class="mb-1">{{ $messages->count() }}</h4>
                        <small>إجمالي الرسائل</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope-open fa-2x mb-2"></i>
                        <h4 class="mb-1">{{ $messages->where('is_read', false)->count() }}</h4>
                        <small>رسائل غير مقروءة</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h4 class="mb-1">{{ $messages->where('is_read', true)->count() }}</h4>
                        <small>رسائل مقروءة</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages List -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2 text-primary"></i>قائمة الرسائل
                            </h5>
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-sm" id="filterStatus" onchange="filterMessages()">
                                    <option value="">جميع الرسائل</option>
                                    <option value="unread">غير مقروءة</option>
                                    <option value="read">مقروءة</option>
                                    <option value="sent">مرسلة</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">المرسل/المستقبل</th>
                                        <th class="border-0">الرسالة</th>
                                        <th class="border-0">الطلب</th>
                                        <th class="border-0">التاريخ</th>
                                        <th class="border-0">الحالة</th>
                                        <th class="border-0">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr class="message-row {{ !$message->is_read && $message->receiver_id === auth()->id() ? 'table-warning' : '' }}">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        @if($message->sender_id === auth()->id())
                                                            <div class="avatar-title bg-success text-white rounded-circle">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        @else
                                                            <div class="avatar-title bg-primary text-white rounded-circle">
                                                                <i class="fas fa-building"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if($message->sender_id === auth()->id())
                                                            <h6 class="mb-0 text-success">أنت</h6>
                                                            <small class="text-muted">إلى: {{ $message->receiver->name }}</small>
                                                        @else
                                                            <h6 class="mb-0 text-primary">{{ $message->sender->name }}</h6>
                                                            <small class="text-muted">إلى: أنت</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="message-preview">
                                                    @if($message->subject)
                                                        <h6 class="mb-1 text-dark">{{ $message->subject }}</h6>
                                                    @endif
                                                    <p class="mb-1 fw-bold">{{ Str::limit($message->message, 50) }}</p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-{{ $message->type === 'text' ? 'font' : ($message->type === 'image' ? 'image' : ($message->type === 'video' ? 'video' : 'file')) }} me-1"></i>
                                                        {{ ucfirst($message->type) }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                @if($message->order)
                                                    <span class="badge bg-info">
                                                        {{ $message->order->order_number }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">عام</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div>
                                                    <small class="text-muted">{{ $message->created_at->format('Y-m-d') }}</small>
                                                    <br>
                                                    <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                @if($message->receiver_id === auth()->id())
                                                    @if($message->is_read)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>مقروءة
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-envelope me-1"></i>غير مقروءة
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-paper-plane me-1"></i>مرسلة
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('messages.show', $message) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($message->sender_id === auth()->id())
                                                        <a href="{{ route('messages.edit', $message) }}" class="btn btn-outline-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    <form method="POST" action="{{ route('messages.destroy', $message) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
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
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-comments fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-3">لا توجد رسائل حالياً</h4>
                        <p class="text-muted mb-4">ابدأ المحادثة مع فريق العمل</p>
                        <a href="{{ route('messages.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>رسالة جديدة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

<style>
.message-row {
    transition: all 0.3s ease;
}

.message-row:hover {
    background-color: rgba(0,123,255,0.05);
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.message-preview {
    max-width: 300px;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}

.btn-outline-primary:hover,
.btn-outline-warning:hover,
.btn-outline-danger:hover {
    transform: translateY(-1px);
}

.table th {
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}
</style>

<script>
function refreshMessages() {
    location.reload();
}

function filterMessages() {
    const filter = document.getElementById('filterStatus').value;
    const rows = document.querySelectorAll('.message-row');
    
    rows.forEach(row => {
        let show = true;
        
        if (filter === 'unread') {
            const statusBadge = row.querySelector('.badge');
            show = statusBadge && statusBadge.textContent.includes('غير مقروءة');
        } else if (filter === 'read') {
            const statusBadge = row.querySelector('.badge');
            show = statusBadge && statusBadge.textContent.includes('مقروءة');
        } else if (filter === 'sent') {
            const statusBadge = row.querySelector('.badge');
            show = statusBadge && statusBadge.textContent.includes('مرسلة');
        }
        
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endsection
