@extends('layouts.user')

@section('title', 'تفاصيل الطلب #'.$order->order_number.' - هدية')
@section('page-title', 'تفاصيل الطلب')
@section('page-description', 'رقم الطلب: '.$order->order_number)

@section('page-actions')
<div class="d-flex gap-2">
    <a href="{{ route('orders.edit', $order) }}" class="hd-btn hd-btn--warning hd-btn--sm">
        <i class="fas fa-edit"></i> <span class="d-none d-sm-inline">تعديل</span>
    </a>
    <a href="{{ route('orders.index') }}" class="hd-btn hd-btn--secondary hd-btn--sm">
        <i class="fas fa-arrow-right"></i> <span class="d-none d-sm-inline">رجوع</span>
    </a>
</div>
@endsection

@section('content')

{{-- Page Banner --}}
<div class="hd-page-banner mb-3">
    <div class="hd-page-banner__content d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
        <div>
            <div class="hd-page-banner__title">
                <i class="fas fa-shopping-cart me-2" style="color:#a78bfa;"></i>
                طلب عمرة — {{ $order->order_number }}
            </div>
            <div class="hd-page-banner__sub">
                أُنشئ في {{ $order->created_at->format('Y/m/d — H:i') }} &nbsp;•&nbsp;
                {{ $order->created_at->diffForHumans() }}
            </div>
        </div>
        <span class="hd-badge hd-badge--{{ $order->status }}">
            @switch($order->status)
                @case('pending')     <i class="fas fa-clock"></i> في الانتظار   @break
                @case('confirmed')   <i class="fas fa-check"></i> مؤكد          @break
                @case('assigned')    <i class="fas fa-user-check"></i> مُكلَّف   @break
                @case('in_progress') <i class="fas fa-spinner fa-spin"></i> جاري @break
                @case('completed')   <i class="fas fa-check-circle"></i> مكتمل  @break
                @case('cancelled')   <i class="fas fa-times-circle"></i> ملغي    @break
            @endswitch
        </span>
    </div>
</div>

<div class="row g-3">

    {{-- ===== MAIN COLUMN ===== --}}
    <div class="col-12 col-lg-8">

        {{-- Order Timeline --}}
        <div class="hd-card mb-3">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-primary);">
                        <i class="fas fa-stream"></i>
                    </div>
                    <div>
                        <div class="hd-card-header__title">مسار الطلب</div>
                        <div class="hd-card-header__sub">الحالة الحالية والخطوات القادمة</div>
                    </div>
                </div>
            </div>
            <div class="hd-card-body">
                @php
                    $steps = [
                        ['key'=>'pending',     'label'=>'في الانتظار',  'icon'=>'fa-clock',        'done'=>true],
                        ['key'=>'confirmed',   'label'=>'مؤكد',         'icon'=>'fa-check',         'done'=>in_array($order->status,['confirmed','assigned','in_progress','completed'])],
                        ['key'=>'assigned',    'label'=>'مُكلَّف',       'icon'=>'fa-user-check',    'done'=>in_array($order->status,['assigned','in_progress','completed'])],
                        ['key'=>'in_progress', 'label'=>'قيد التنفيذ',  'icon'=>'fa-spinner',       'done'=>in_array($order->status,['in_progress','completed'])],
                        ['key'=>'completed',   'label'=>'مكتمل',        'icon'=>'fa-check-circle',  'done'=>$order->status==='completed'],
                    ];
                    $current = $order->status;
                @endphp
                <div class="hd-timeline">
                    @foreach($steps as $step)
                    <div class="hd-timeline-item">
                        <div class="hd-timeline-dot {{ $step['key']===$current ? 'hd-timeline-dot--active' : ($step['done'] ? 'hd-timeline-dot--done' : 'hd-timeline-dot--pending') }}">
                            <i class="fas {{ $step['icon'] }}"></i>
                        </div>
                        <div class="hd-timeline-content">
                            <div class="hd-timeline-title" style="{{ $step['key']===$current ? 'color:var(--hd-primary);' : '' }}">
                                {{ $step['label'] }}
                                @if($step['key']===$current)
                                    <span class="hd-badge hd-badge--primary ms-2" style="font-size:.65rem;">الحالية</span>
                                @endif
                            </div>
                            <div class="hd-timeline-time">
                                @if($step['key']==='pending')    {{ $order->created_at->format('Y/m/d H:i') }}
                                @elseif($step['key']==='assigned' && $order->assigned_at)   {{ $order->assigned_at->format('Y/m/d H:i') }}
                                @elseif($step['key']==='completed' && $order->completed_at) {{ $order->completed_at->format('Y/m/d H:i') }}
                                @elseif($step['done']) مكتمل
                                @else في انتظار...
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Order Info --}}
        <div class="hd-card mb-3">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-info);">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="hd-card-header__title">معلومات الطلب</div>
                </div>
            </div>
            <div class="hd-info-grid">
                <div class="hd-info-row">
                    <div class="hd-info-row__key">رقم الطلب</div>
                    <div class="hd-info-row__val"><strong style="color:var(--hd-primary);">{{ $order->order_number }}</strong></div>
                </div>
                <div class="hd-info-row">
                    <div class="hd-info-row__key">الحزمة</div>
                    <div class="hd-info-row__val">{{ $order->umrahPackage->name_ar }}</div>
                </div>
                <div class="hd-info-row">
                    <div class="hd-info-row__key">المستفيد</div>
                    <div class="hd-info-row__val"><strong>{{ $order->beneficiary_name }}</strong></div>
                </div>
                <div class="hd-info-row">
                    <div class="hd-info-row__key">هاتف المستفيد</div>
                    <div class="hd-info-row__val" dir="ltr">{{ $order->beneficiary_phone }}</div>
                </div>
                @if($order->whatsapp_phone)
                <div class="hd-info-row">
                    <div class="hd-info-row__key">واتساب</div>
                    <div class="hd-info-row__val" dir="ltr">
                        <i class="fab fa-whatsapp" style="color:#25d366;"></i>
                        {{ $order->whatsapp_country_code }}{{ $order->whatsapp_phone }}
                    </div>
                </div>
                @endif
                @if($order->beneficiary_address)
                <div class="hd-info-row">
                    <div class="hd-info-row__key">العنوان</div>
                    <div class="hd-info-row__val">{{ $order->beneficiary_address }}</div>
                </div>
                @endif
                <div class="hd-info-row">
                    <div class="hd-info-row__key">نوع المستفيد</div>
                    <div class="hd-info-row__val">
                        <span class="hd-tag hd-tag--primary">{{ $order->beneficiary_type }}</span>
                    </div>
                </div>
                <div class="hd-info-row">
                    <div class="hd-info-row__key">المبلغ</div>
                    <div class="hd-info-row__val">
                        <strong style="font-size:1.05rem;color:#059669;">
                            {{ number_format($order->total_amount, 2) }}
                            <img src="{{ \App\Helpers\CurrencyHelper::getCurrencyImage($order->currency) }}" alt="{{ $order->currency }}" style="width:16px;height:16px;border-radius:50%;vertical-align:middle;">
                            {{ $order->currency }}
                        </strong>
                    </div>
                </div>
                <div class="hd-info-row">
                    <div class="hd-info-row__key">تاريخ الإنشاء</div>
                    <div class="hd-info-row__val">{{ $order->created_at->format('Y/m/d — H:i') }}</div>
                </div>
                @if($order->assigned_at)
                <div class="hd-info-row">
                    <div class="hd-info-row__key">تاريخ التخصيص</div>
                    <div class="hd-info-row__val">{{ $order->assigned_at->format('Y/m/d — H:i') }}</div>
                </div>
                @endif
                @if($order->completed_at)
                <div class="hd-info-row">
                    <div class="hd-info-row__key">تاريخ الإكمال</div>
                    <div class="hd-info-row__val">{{ $order->completed_at->format('Y/m/d — H:i') }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Notes --}}
        @if($order->notes || $order->beneficiary_details)
        <div class="hd-card mb-3">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-warning);">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                    <div class="hd-card-header__title">ملاحظات وتفاصيل</div>
                </div>
            </div>
            <div class="hd-card-body">
                @if($order->beneficiary_details)
                    <div style="font-size:.78rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.5rem;">تفاصيل المستفيد</div>
                    <div style="background:#fffbeb;border-right:3px solid #f59e0b;border-radius:10px;padding:.9rem 1rem;margin-bottom:1rem;font-size:.88rem;color:#78350f;">{{ $order->beneficiary_details }}</div>
                @endif
                @if($order->notes)
                    <div style="font-size:.78rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.5rem;">ملاحظات الطلب</div>
                    <div style="background:#f0f9ff;border-right:3px solid #3b82f6;border-radius:10px;padding:.9rem 1rem;font-size:.88rem;color:#1e40af;">{{ $order->notes }}</div>
                @endif
            </div>
        </div>
        @endif

        {{-- Payments --}}
        @if($order->payments->count() > 0)
        <div class="hd-card mb-3">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-success);">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="hd-card-header__title">معلومات الدفع</div>
                </div>
            </div>
            <div class="hd-card-body">
                @foreach($order->payments as $payment)
                <div style="background:#f8fafc;border-radius:12px;padding:1rem;border:1px solid #f1f5f9;margin-bottom:.65rem;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong style="font-size:.88rem;">{{ $payment->payment_id }}</strong>
                        <span class="hd-badge hd-badge--{{ $payment->status==='completed'?'completed':($payment->status==='pending'?'pending':'cancelled') }}">
                            @switch($payment->status)
                                @case('pending')   في الانتظار @break
                                @case('completed') مكتمل      @break
                                @case('failed')    فشل         @break
                                @default           {{ $payment->status }}
                            @endswitch
                        </span>
                    </div>
                    <div style="font-size:1rem;font-weight:800;color:#059669;">{{ number_format($payment->amount,2) }} {{ $payment->currency }}</div>
                    <div style="font-size:.75rem;color:#94a3b8;margin-top:.25rem;">{{ $payment->created_at->format('Y/m/d H:i') }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-12 col-lg-4">

        {{-- Package Info --}}
        <div class="hd-card mb-3">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-teal);">
                        <i class="fas fa-kaaba"></i>
                    </div>
                    <div class="hd-card-header__title">معلومات الحزمة</div>
                </div>
            </div>
            <div class="hd-card-body text-center">
                @if($order->umrahPackage->image)
                    <img src="{{ asset('storage/'.$order->umrahPackage->image) }}" alt="{{ $order->umrahPackage->name_ar }}"
                         style="width:100%;height:140px;object-fit:cover;border-radius:12px;margin-bottom:1rem;">
                @else
                    <div style="width:100%;height:120px;background:var(--hd-grad-primary);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                        <i class="fas fa-kaaba" style="font-size:2.5rem;color:rgba(255,255,255,.6);"></i>
                    </div>
                @endif
                <div style="font-size:1rem;font-weight:800;color:#1e293b;margin-bottom:.4rem;">{{ $order->umrahPackage->name_ar }}</div>
                @if($order->umrahPackage->description_ar)
                    <div style="font-size:.82rem;color:#64748b;margin-bottom:.65rem;">{{ Str::limit($order->umrahPackage->description_ar,90) }}</div>
                @endif
                @if($order->umrahPackage->duration)
                    <span class="hd-tag hd-tag--primary mb-2"><i class="fas fa-clock"></i> {{ $order->umrahPackage->duration }}</span><br>
                @endif
                <div style="font-size:1.25rem;font-weight:900;color:var(--hd-primary);margin-top:.5rem;">
                    {{ number_format($order->umrahPackage->price,2) }} {{ $order->umrahPackage->currency }}
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="hd-card">
            <div class="hd-card-header">
                <div class="hd-card-header__left">
                    <div class="hd-card-header__icon" style="background:var(--hd-grad-purple);">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="hd-card-header__title">الإجراءات</div>
                </div>
            </div>
            <div class="hd-card-body d-grid gap-2">
                @if(!in_array($order->status,['completed','cancelled']))
                <a href="{{ route('orders.edit', $order) }}" class="hd-btn hd-btn--warning hd-btn--full">
                    <i class="fas fa-edit"></i> تعديل الطلب
                </a>
                @endif
                <a href="{{ route('messages.create') }}?order={{ $order->id }}" class="hd-btn hd-btn--success hd-btn--full">
                    <i class="fas fa-comment-dots"></i> مراسلة الدعم
                </a>
                <a href="{{ route('orders.index') }}" class="hd-btn hd-btn--secondary hd-btn--full">
                    <i class="fas fa-list"></i> جميع الطلبات
                </a>
                <a href="{{ route('home') }}" class="hd-btn hd-btn--ghost hd-btn--full">
                    <i class="fas fa-home"></i> الصفحة الرئيسية
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
