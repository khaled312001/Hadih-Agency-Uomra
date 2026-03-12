@extends('layouts.user')

@section('title', 'تعديل طلب العمرة - هدية')
@section('page-title', 'تعديل طلب العمرة')
@section('page-description', 'تعديل بيانات الطلب رقم {{ $order->order_number }}')

@section('content')

<form method="POST" action="{{ route('orders.update', $order) }}" id="orderEditForm">
    @csrf
    @method('PUT')

    <div class="row g-3">

        {{-- Package Info (read-only) --}}
        <div class="col-12">
            <div class="hd-card">
                <div class="hd-card-header">
                    <div class="hd-card-header__left">
                        <div class="hd-card-header__icon" style="background:var(--hd-grad-primary);">
                            <i class="fas fa-kaaba"></i>
                        </div>
                        <span class="hd-card-header__title">حزمة العمرة المختارة</span>
                    </div>
                    <span class="hd-badge" style="background:#f0fdf4;color:#22c55e;">
                        <i class="fas fa-lock"></i> غير قابلة للتعديل
                    </span>
                </div>
                <div class="hd-card-body--sm">
                    <div style="background:#f8fafc;border-radius:14px;padding:1.25rem;border:1px solid #e2e8f0;">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <div style="width:52px;height:52px;border-radius:14px;background:var(--hd-grad-primary);display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-kaaba" style="font-size:1.4rem;color:#fff;"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div style="font-weight:800;font-size:1.05rem;color:#1e293b;">{{ $order->umrahPackage->name_ar }}</div>
                                @if($order->umrahPackage->description_ar)
                                    <div style="font-size:.8rem;color:#64748b;margin-top:.2rem;">{{ $order->umrahPackage->description_ar }}</div>
                                @endif
                            </div>
                            <div class="col-auto text-end">
                                <div style="font-size:1.4rem;font-weight:800;color:var(--hd-primary);">
                                    {{ number_format($order->umrahPackage->price) }} {{ $order->umrahPackage->currency }}
                                </div>
                                @if($order->umrahPackage->duration)
                                    <div style="font-size:.75rem;color:#94a3b8;">المدة: {{ $order->umrahPackage->duration }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Beneficiary Info --}}
        <div class="col-12">
            <div class="hd-form-section">
                <div class="hd-form-section__header" style="background:linear-gradient(135deg,#0f3460,#1a1a2e);">
                    <div class="hd-form-section__header-icon"><i class="fas fa-user-circle"></i></div>
                    <div>
                        <div class="hd-form-section__header-title">معلومات المستفيد</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.75);">عدّل بيانات المستفيد</div>
                    </div>
                </div>
                <div class="hd-form-section__body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-user"></i> اسم المستفيد</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-user"></i>
                                    <input type="text" name="beneficiary_name"
                                           class="hd-input @error('beneficiary_name') hd-input--error @enderror"
                                           value="{{ old('beneficiary_name', $order->beneficiary_name) }}"
                                           placeholder="أدخل اسم المستفيد" required>
                                </div>
                                @error('beneficiary_name')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-phone"></i> هاتف المستفيد</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-phone"></i>
                                    <input type="tel" name="beneficiary_phone"
                                           class="hd-input @error('beneficiary_phone') hd-input--error @enderror"
                                           value="{{ old('beneficiary_phone', $order->beneficiary_phone) }}"
                                           placeholder="رقم الهاتف" required>
                                </div>
                                @error('beneficiary_phone')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required">
                                    <i class="fab fa-whatsapp" style="color:#25d366;"></i>
                                    رقم واتساب للتواصل وإرسال فيديو الإثبات
                                </label>
                                <div class="row g-2">
                                    <div class="col-5 col-md-3">
                                        <select name="whatsapp_country_code" id="whatsapp_country_code"
                                                class="hd-input hd-select @error('whatsapp_country_code') hd-input--error @enderror" required>
                                            <option value="">كود الدولة</option>
                                            @foreach(['+966'=>'🇸🇦 +966','+971'=>'🇦🇪 +971','+965'=>'🇰🇼 +965','+973'=>'🇧🇭 +973','+974'=>'🇶🇦 +974','+968'=>'🇴🇲 +968','+20'=>'🇪🇬 +20','+212'=>'🇲🇦 +212','+213'=>'🇩🇿 +213','+216'=>'🇹🇳 +216','+249'=>'🇸🇩 +249','+964'=>'🇮🇶 +964','+962'=>'🇯🇴 +962','+963'=>'🇸🇾 +963','+961'=>'🇱🇧 +961','+92'=>'🇵🇰 +92','+91'=>'🇮🇳 +91','+880'=>'🇧🇩 +880','+1'=>'🇺🇸 +1','+44'=>'🇬🇧 +44'] as $code=>$label)
                                                <option value="{{ $code }}" {{ old('whatsapp_country_code',$order->whatsapp_country_code)===$code?'selected':'' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('whatsapp_country_code')<div class="hd-error-msg">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-7 col-md-9">
                                        <div class="hd-input-wrap">
                                            <i class="hd-input-icon fab fa-whatsapp" style="color:#25d366;"></i>
                                            <input type="tel" name="whatsapp_phone"
                                                   class="hd-input @error('whatsapp_phone') hd-input--error @enderror"
                                                   value="{{ old('whatsapp_phone', $order->whatsapp_phone) }}"
                                                   placeholder="رقم الواتساب بدون كود الدولة" required>
                                        </div>
                                        @error('whatsapp_phone')<div class="hd-error-msg">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div style="font-size:.75rem;color:#94a3b8;margin-top:.35rem;">
                                    <i class="fas fa-info-circle me-1"></i>يجب توافر رقم واتساب لإرسال فيديو الإثبات
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-map-marker-alt"></i> عنوان المستفيد</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-map-marker-alt"></i>
                                    <textarea name="beneficiary_address" rows="2"
                                              class="hd-input @error('beneficiary_address') hd-input--error @enderror"
                                              placeholder="أدخل عنوان المستفيد">{{ old('beneficiary_address', $order->beneficiary_address) }}</textarea>
                                </div>
                                @error('beneficiary_address')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-heart"></i> نوع المستفيد</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-heart"></i>
                                    <select name="beneficiary_type"
                                            class="hd-input hd-select @error('beneficiary_type') hd-input--error @enderror" required>
                                        <option value="">اختر نوع المستفيد</option>
                                        <option value="deceased" {{ old('beneficiary_type',$order->beneficiary_type)==='deceased'?'selected':'' }}>متوفى</option>
                                        <option value="sick"     {{ old('beneficiary_type',$order->beneficiary_type)==='sick'?'selected':'' }}>مريض</option>
                                        <option value="elderly"  {{ old('beneficiary_type',$order->beneficiary_type)==='elderly'?'selected':'' }}>مسن</option>
                                        <option value="disabled" {{ old('beneficiary_type',$order->beneficiary_type)==='disabled'?'selected':'' }}>معاق</option>
                                    </select>
                                </div>
                                @error('beneficiary_type')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-info-circle"></i> تفاصيل إضافية</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-info-circle"></i>
                                    <textarea name="beneficiary_details" rows="2"
                                              class="hd-input @error('beneficiary_details') hd-input--error @enderror"
                                              placeholder="أي معلومات إضافية...">{{ old('beneficiary_details', $order->beneficiary_details) }}</textarea>
                                </div>
                                @error('beneficiary_details')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="col-12">
            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="hd-btn hd-btn--primary hd-btn--lg">
                    <i class="fas fa-save"></i> حفظ التغييرات
                </button>
                <a href="{{ route('orders.show', $order) }}" class="hd-btn hd-btn--secondary hd-btn--lg">
                    <i class="fas fa-eye"></i> عرض الطلب
                </a>
                <a href="{{ route('orders.index') }}" class="hd-btn hd-btn--ghost">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </div>

    </div>
</form>

@endsection
