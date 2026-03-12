@extends('layouts.user')

@section('title', 'تفاصيل الرسالة - هدية')
@section('page-title', 'تفاصيل الرسالة')
@section('page-description', 'عرض تفاصيل الرسالة')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Message Card --}}
        <div class="hd-card mb-3">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-primary);">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <span class="hd-card-header__title">
                        {{ $message->subject ?: 'رسالة بدون موضوع' }}
                    </span>
                </div>
                <div>
                    @php
                        $typeMap = ['text'=>['icon'=>'font','label'=>'نص','color'=>'#667eea'],
                                    'image'=>['icon'=>'image','label'=>'صورة','color'=>'#22c55e'],
                                    'video'=>['icon'=>'video','label'=>'فيديو','color'=>'#3b82f6'],
                                    'file'=>['icon'=>'file','label'=>'ملف','color'=>'#f59e0b']];
                        $t = $typeMap[$message->type] ?? $typeMap['text'];
                    @endphp
                    <span class="hd-badge" style="background:{{ $t['color'] }}20;color:{{ $t['color'] }};">
                        <i class="fas fa-{{ $t['icon'] }}"></i> {{ $t['label'] }}
                    </span>
                </div>
            </div>
            <div class="hd-card-body--sm">

                {{-- Sender / Receiver --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="hd-info-row">
                            <div class="hd-info-row__label"><i class="fas fa-user-circle"></i> المرسل</div>
                            <div class="hd-info-row__value">
                                <div class="hd-user-cell">
                                    <div class="hd-avatar hd-avatar--sm" style="background:var(--hd-grad-primary);">
                                        {{ mb_substr($message->sender->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700;font-size:.875rem;">{{ $message->sender->name }}</div>
                                        @if($message->sender->role === 'admin')
                                            <span class="hd-badge hd-badge--admin" style="font-size:.68rem;">مدير</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="hd-info-row">
                            <div class="hd-info-row__label"><i class="fas fa-user-check"></i> المستقبل</div>
                            <div class="hd-info-row__value">
                                <div class="hd-user-cell">
                                    <div class="hd-avatar hd-avatar--sm" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
                                        {{ mb_substr($message->receiver->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700;font-size:.875rem;">{{ $message->receiver->name }}</div>
                                        @if($message->receiver->role === 'admin')
                                            <span class="hd-badge hd-badge--admin" style="font-size:.68rem;">مدير</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hd-divider"></div>

                {{-- Meta --}}
                <div class="row g-2 mb-3">
                    <div class="col-auto">
                        <div style="font-size:.78rem;color:#94a3b8;">
                            <i class="fas fa-calendar me-1"></i>{{ $message->created_at->format('Y/m/d H:i') }}
                        </div>
                    </div>
                    @if($message->order)
                    <div class="col-auto">
                        <div style="font-size:.78rem;color:#3b82f6;">
                            <i class="fas fa-shopping-cart me-1"></i>
                            الطلب: {{ $message->order->order_number }}
                        </div>
                    </div>
                    @endif
                    <div class="col-auto">
                        @if($message->is_read)
                            <span style="font-size:.78rem;color:#22c55e;"><i class="fas fa-check-double me-1"></i>مقروءة</span>
                        @else
                            <span style="font-size:.78rem;color:#f59e0b;"><i class="fas fa-envelope me-1"></i>غير مقروءة</span>
                        @endif
                    </div>
                </div>

                {{-- Message body --}}
                @if($message->message)
                    <div style="background:#f8fafc;border-radius:14px;padding:1.25rem;border:1px solid #e2e8f0;line-height:1.8;color:#334155;">
                        {{ $message->message }}
                    </div>
                @endif

                {{-- Attachment --}}
                @if($message->attachment)
                    <div class="mt-3">
                        <div style="font-weight:700;font-size:.82rem;color:#64748b;margin-bottom:.5rem;">
                            <i class="fas fa-paperclip me-1"></i> المرفق
                        </div>
                        @if($message->type === 'image')
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $message->attachment) }}"
                                     alt="مرفق" style="max-height:300px;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,.1);">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $message->attachment) }}"
                                       class="hd-btn hd-btn--outline-primary hd-btn--sm" download>
                                        <i class="fas fa-download"></i> تحميل الصورة
                                    </a>
                                </div>
                            </div>
                        @elseif($message->type === 'video')
                            <div class="text-center">
                                <video controls style="max-height:300px;border-radius:14px;width:100%;">
                                    <source src="{{ asset('storage/' . $message->attachment) }}" type="video/mp4">
                                    متصفحك لا يدعم تشغيل الفيديو.
                                </video>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $message->attachment) }}"
                                       class="hd-btn hd-btn--outline-primary hd-btn--sm" download>
                                        <i class="fas fa-download"></i> تحميل الفيديو
                                    </a>
                                </div>
                            </div>
                        @else
                            <div style="background:#f8fafc;border-radius:12px;padding:.875rem 1rem;border:1px solid #e2e8f0;display:flex;align-items:center;gap:1rem;">
                                <i class="fas fa-file-alt" style="font-size:2rem;color:var(--hd-primary);"></i>
                                <div class="flex-grow-1">
                                    <div style="font-weight:700;font-size:.875rem;">{{ basename($message->attachment) }}</div>
                                    <div style="font-size:.75rem;color:#94a3b8;">ملف مرفق</div>
                                </div>
                                <a href="{{ asset('storage/' . $message->attachment) }}"
                                   class="hd-btn hd-btn--outline-primary hd-btn--sm" download>
                                    <i class="fas fa-download"></i> تحميل
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('messages.index') }}" class="hd-btn hd-btn--secondary">
                <i class="fas fa-arrow-right"></i> العودة للرسائل
            </a>
            @if($message->sender_id === auth()->id())
                <a href="{{ route('messages.edit', $message) }}" class="hd-btn hd-btn--warning">
                    <i class="fas fa-edit"></i> تعديل
                </a>
            @endif
        </div>

    </div>
</div>

@endsection
