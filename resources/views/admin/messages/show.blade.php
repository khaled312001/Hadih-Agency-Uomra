@extends('layouts.admin')

@section('title', 'تفاصيل الرسالة - هدية')

@section('page-title', 'تفاصيل الرسالة')
@section('page-description', 'عرض تفاصيل الرسالة والمعلومات المرتبطة بها')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 mb-1 text-primary">
                        <i class="fas fa-comment me-2"></i>تفاصيل الرسالة
                    </h2>
                    <p class="text-muted mb-0">عرض تفاصيل الرسالة والمعلومات المرتبطة بها</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                    </a>
                    @if($message->sender_id === auth()->id())
                        <a href="{{ route('admin.messages.edit', $message) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit me-2"></i>تعديل
                        </a>
                    @endif
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="fas fa-trash me-2"></i>حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Message Details -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-comment-dots me-2 text-primary"></i>محتوى الرسالة
                    </h5>
                </div>
                <div class="card-body">
                    @if($message->subject)
                        <div class="mb-4">
                            <h4 class="text-primary">{{ $message->subject }}</h4>
                        </div>
                    @endif
                    
                    <div class="message-content p-4 bg-light rounded">
                        <p class="mb-0 fs-5">{{ $message->message }}</p>
                    </div>

                    @if($message->attachment)
                        <div class="mt-4">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-paperclip me-2"></i>مرفق
                            </h6>
                            <div class="attachment-preview">
                                @if($message->type === 'image')
                                    <img src="{{ asset('storage/' . $message->attachment) }}" alt="مرفق" class="img-fluid rounded" style="max-height: 300px;">
                                @elseif($message->type === 'video')
                                    <video controls class="img-fluid rounded" style="max-height: 300px;">
                                        <source src="{{ asset('storage/' . $message->attachment) }}" type="video/mp4">
                                        متصفحك لا يدعم تشغيل الفيديو.
                                    </video>
                                @else
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <i class="fas fa-file fa-2x text-muted me-3"></i>
                                        <div>
                                            <h6 class="mb-1">{{ basename($message->attachment) }}</h6>
                                            <small class="text-muted">ملف مرفق</small>
                                        </div>
                                        <a href="{{ asset('storage/' . $message->attachment) }}" class="btn btn-outline-primary btn-sm ms-auto" download>
                                            <i class="fas fa-download me-1"></i>تحميل
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Message Info -->
        <div class="col-lg-4">
            <!-- Message Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-info"></i>معلومات الرسالة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted">نوع الرسالة</label>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-{{ $message->type === 'text' ? 'font' : ($message->type === 'image' ? 'image' : ($message->type === 'video' ? 'video' : 'file')) }} me-2 text-primary"></i>
                                <span class="fw-bold">{{ ucfirst($message->type) }}</span>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted">الحالة</label>
                            <div>
                                @if($message->receiver_id === auth()->id())
                                    @if($message->is_read)
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-check me-1"></i>مقروءة
                                        </span>
                                    @else
                                        <span class="badge bg-warning fs-6">
                                            <i class="fas fa-envelope me-1"></i>غير مقروءة
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-primary fs-6">
                                        <i class="fas fa-paper-plane me-1"></i>مرسلة
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted">تاريخ الإرسال</label>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                <span class="fw-bold">{{ $message->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted">وقت الإرسال</label>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <span class="fw-bold">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>

                        @if($message->read_at)
                            <div class="col-12">
                                <label class="form-label text-muted">تاريخ القراءة</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-eye me-2 text-success"></i>
                                    <span class="fw-bold">{{ $message->read_at->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Participants -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2 text-success"></i>المشاركون
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Sender -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm me-3">
                            @if($message->sender->role === 'admin')
                                <div class="avatar-title bg-warning text-white rounded-circle">
                                    <i class="fas fa-crown"></i>
                                </div>
                            @else
                                <div class="avatar-title bg-primary text-white rounded-circle">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-0 {{ $message->sender->role === 'admin' ? 'text-warning' : 'text-primary' }}">
                                {{ $message->sender->name }}
                                @if($message->sender->role === 'admin')
                                    <i class="fas fa-crown ms-1" title="إدارة"></i>
                                @endif
                            </h6>
                            <small class="text-muted">المرسل</small>
                        </div>
                    </div>

                    <!-- Receiver -->
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-3">
                            @if($message->receiver->role === 'admin')
                                <div class="avatar-title bg-warning text-white rounded-circle">
                                    <i class="fas fa-crown"></i>
                                </div>
                            @else
                                <div class="avatar-title bg-primary text-white rounded-circle">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-0 {{ $message->receiver->role === 'admin' ? 'text-warning' : 'text-primary' }}">
                                {{ $message->receiver->name }}
                                @if($message->receiver->role === 'admin')
                                    <i class="fas fa-crown ms-1" title="إدارة"></i>
                                @endif
                            </h6>
                            <small class="text-muted">المستقبل</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Order -->
            @if($message->order)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-cart me-2 text-info"></i>الطلب المرتبط
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">رقم الطلب</h6>
                                <span class="badge bg-info fs-6">{{ $message->order->order_number }}</span>
                            </div>
                            <a href="{{ route('admin.orders.show', $message->order) }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye me-1"></i>عرض
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
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

.message-content {
    border-left: 4px solid #007bff;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.attachment-preview {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 1rem;
    background-color: #f8f9fa;
}

.card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}
</style>
@endsection
