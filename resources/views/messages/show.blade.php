@extends('layouts.user')

@section('title', 'تفاصيل الرسالة - هدية')
@section('page-title', 'تفاصيل الرسالة')
@section('page-description', 'عرض تفاصيل الرسالة')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="هدية" style="height: 60px; width: auto;" class="mb-3">
                <h5 class="card-title mb-0">تفاصيل الرسالة</h5>
            </div>
            <div class="card-body">
                @if($message->subject)
                    <div class="mb-3">
                        <strong>الموضوع:</strong> {{ $message->subject }}
                    </div>
                @endif
                <div class="mb-3">
                    <strong>المرسل:</strong> {{ $message->sender->name }}
                </div>
                <div class="mb-3">
                    <strong>المستقبل:</strong> {{ $message->receiver->name }}
                </div>
                <div class="mb-3">
                    <strong>نوع الرسالة:</strong>
                    <span class="badge bg-{{ $message->type === 'text' ? 'primary' : ($message->type === 'image' ? 'success' : ($message->type === 'video' ? 'info' : 'warning')) }}">
                        <i class="fas fa-{{ $message->type === 'text' ? 'font' : ($message->type === 'image' ? 'image' : ($message->type === 'video' ? 'video' : 'file')) }} me-1"></i>
                        {{ $message->type === 'text' ? 'نص' : ($message->type === 'image' ? 'صورة' : ($message->type === 'video' ? 'فيديو' : 'ملف')) }}
                    </span>
                </div>
                
                @if($message->message)
                    <div class="mb-3">
                        <strong>محتوى الرسالة:</strong>
                        <div class="mt-2 p-3 bg-light rounded">
                            <p class="mb-0">{{ $message->message }}</p>
                        </div>
                    </div>
                @endif

                @if($message->attachment)
                    <div class="mb-3">
                        <strong>المرفق:</strong>
                        <div class="mt-2">
                            @if($message->type === 'image')
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $message->attachment) }}" 
                                         alt="مرفق" 
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-height: 300px;">
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $message->attachment) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           download>
                                            <i class="fas fa-download me-1"></i>تحميل الصورة
                                        </a>
                                    </div>
                                </div>
                            @elseif($message->type === 'video')
                                <div class="text-center">
                                    <video controls class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                        <source src="{{ asset('storage/' . $message->attachment) }}" type="video/mp4">
                                        متصفحك لا يدعم تشغيل الفيديو.
                                    </video>
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $message->attachment) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           download>
                                            <i class="fas fa-download me-1"></i>تحميل الفيديو
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="me-3">
                                        <i class="fas fa-file fa-2x text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ basename($message->attachment) }}</h6>
                                        <small class="text-muted">ملف مرفق</small>
                                    </div>
                                    <a href="{{ asset('storage/' . $message->attachment) }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       download>
                                        <i class="fas fa-download me-1"></i>تحميل
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <strong>التاريخ:</strong> {{ $message->created_at->format('Y-m-d H:i') }}
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للرسائل
                    </a>
                    @if($message->sender_id === auth()->id())
                        <a href="{{ route('messages.edit', $message) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>تعديل
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
