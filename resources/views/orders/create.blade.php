@extends('layouts.user')

@section('title', 'إنشاء طلب عمرة جديد - هدية')
@section('page-title', 'إنشاء طلب عمرة جديد')
@section('page-description', 'ابدأ رحلتك الروحية بطلب عمرة جديدة')

@section('content')

<form method="POST" action="{{ route('orders.store') }}" id="orderCreateForm">
    @csrf

    <div class="row g-3">

        {{-- Package Selection --}}
        <div class="col-12">
            <div class="hd-form-section">
                <div class="hd-form-section__header">
                    <div class="hd-form-section__header-icon">
                        <i class="fas fa-kaaba"></i>
                    </div>
                    <div>
                        <div class="hd-form-section__header-title">اختيار حزمة العمرة</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.75);">اختر الحزمة المناسبة لك</div>
                    </div>
                </div>
                <div class="hd-form-section__body">
                    <div class="hd-form-group">
                        <label class="hd-label hd-label--required"><i class="fas fa-box"></i> حزمة العمرة</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-kaaba"></i>
                            <select name="umrah_package_id" id="umrah_package_id"
                                    class="hd-input hd-select @error('umrah_package_id') hd-input--error @enderror" required
                                    onchange="updatePackagePreview(this)">
                                <option value="">-- اختر حزمة العمرة --</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}"
                                            data-price="{{ $package->price }}"
                                            data-currency="{{ $package->currency }}"
                                            data-duration="{{ $package->duration }}"
                                            data-desc="{{ $package->description_ar }}"
                                            {{ (old('umrah_package_id') == $package->id || request('package') == $package->id) ? 'selected' : '' }}>
                                        {{ $package->name_ar }} — {{ number_format($package->price) }} {{ $package->currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('umrah_package_id')<div class="hd-error-msg">{{ $message }}</div>@enderror
                    </div>

                    {{-- Package Preview --}}
                    <div id="packagePreview" class="d-none">
                        <div style="background:#f8fafc;border-radius:14px;padding:1.25rem;border:1px solid #e2e8f0;margin-top:.5rem;">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div style="width:52px;height:52px;border-radius:14px;background:var(--hd-grad-primary);display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-kaaba" style="font-size:1.4rem;color:#fff;"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div id="pkgName" style="font-weight:800;font-size:1.05rem;color:#1e293b;"></div>
                                    <div id="pkgDesc" style="font-size:.8rem;color:#64748b;margin-top:.2rem;"></div>
                                </div>
                                <div class="col-auto text-end">
                                    <div id="pkgPrice" style="font-size:1.4rem;font-weight:800;color:var(--hd-primary);"></div>
                                    <div id="pkgDuration" style="font-size:.75rem;color:#94a3b8;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Customer Info (Only for Guests) --}}
        @guest
        <div class="col-12">
            <div class="hd-form-section">
                <div class="hd-form-section__header" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                    <div class="hd-form-section__header-icon">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <div>
                        <div class="hd-form-section__header-title">معلومات مقدم الطلب</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.75);">أدخل بياناتك للتواصل معك بخصوص الطلب</div>
                    </div>
                </div>
                <div class="hd-form-section__body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-user"></i> اسمك الكامل</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-user"></i>
                                    <input type="text" name="customer_name" class="hd-input @error('customer_name') hd-input--error @enderror"
                                           value="{{ old('customer_name') }}" placeholder="أدخل اسمك الكامل" required>
                                </div>
                                @error('customer_name')<div class="hd-error-msg">{{ $message }}</div>@error
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-envelope"></i>
                                    <input type="email" name="customer_email" class="hd-input @error('customer_email') hd-input--error @enderror"
                                           value="{{ old('customer_email') }}" placeholder="email@example.com" required>
                                </div>
                                @error('customer_email')<div class="hd-error-msg">{{ $message }}</div>@error
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label hd-label--required"><i class="fas fa-phone"></i> رقم الجوال</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-phone"></i>
                                    <input type="tel" name="customer_phone" class="hd-input @error('customer_phone') hd-input--error @enderror"
                                           value="{{ old('customer_phone') }}" placeholder="رقم الجوال" required>
                                </div>
                                @error('customer_phone')<div class="hd-error-msg">{{ $message }}</div>@error
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endguest

        {{-- Beneficiary Info --}}
        <div class="col-12">
            <div class="hd-form-section">
                <div class="hd-form-section__header" style="background:linear-gradient(135deg,#0f3460,#1a1a2e);">
                    <div class="hd-form-section__header-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div>
                        <div class="hd-form-section__header-title">معلومات المستفيد</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.75);">أدخل بيانات من ستُهدى إليه العمرة</div>
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
                                           value="{{ old('beneficiary_name') }}" placeholder="أدخل اسم المستفيد الكامل" required>
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
                                           value="{{ old('beneficiary_phone') }}" placeholder="رقم الهاتف" required>
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
                                                <option value="{{ $code }}" {{ old('whatsapp_country_code','+966')===$code?'selected':'' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('whatsapp_country_code')<div class="hd-error-msg">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-7 col-md-9">
                                        <div class="hd-input-wrap">
                                            <i class="hd-input-icon fab fa-whatsapp" style="color:#25d366;"></i>
                                            <input type="tel" name="whatsapp_phone" id="whatsapp_phone"
                                                   class="hd-input @error('whatsapp_phone') hd-input--error @enderror"
                                                   value="{{ old('whatsapp_phone') }}" placeholder="رقم الواتساب بدون كود الدولة" required>
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
                                              placeholder="أدخل عنوان المستفيد (اختياري)">{{ old('beneficiary_address') }}</textarea>
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
                                        <option value="">-- اختر نوع المستفيد --</option>
                                        <option value="deceased" {{ old('beneficiary_type')==='deceased'?'selected':'' }}>متوفى</option>
                                        <option value="sick"     {{ old('beneficiary_type')==='sick'?'selected':'' }}>مريض</option>
                                        <option value="elderly"  {{ old('beneficiary_type')==='elderly'?'selected':'' }}>مسن</option>
                                        <option value="disabled" {{ old('beneficiary_type')==='disabled'?'selected':'' }}>معاق</option>
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
                                              placeholder="أي معلومات إضافية عن المستفيد...">{{ old('beneficiary_details') }}</textarea>
                                </div>
                                @error('beneficiary_details')<div class="hd-error-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="col-12">
            <div class="hd-form-section">
                <div class="hd-form-section__header" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                    <div class="hd-form-section__header-icon"><i class="fas fa-sticky-note"></i></div>
                    <div>
                        <div class="hd-form-section__header-title">ملاحظات الطلب</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,.75);">أي تعليمات خاصة أو ملاحظات</div>
                    </div>
                </div>
                <div class="hd-form-section__body">
                    <div class="hd-form-group mb-0">
                        <label class="hd-label"><i class="fas fa-comment"></i> ملاحظات (اختياري)</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-comment"></i>
                            <textarea name="notes" rows="3"
                                      class="hd-input @error('notes') hd-input--error @enderror"
                                      placeholder="أضف أي ملاحظات أو طلبات خاصة...">{{ old('notes') }}</textarea>
                        </div>
                        @error('notes')<div class="hd-error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="col-12">
            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="hd-btn hd-btn--primary hd-btn--lg" id="submitBtn">
                    <i class="fas fa-paper-plane"></i> إرسال الطلب
                </button>
                <a href="{{ route('orders.index') }}" class="hd-btn hd-btn--secondary hd-btn--lg">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </div>

    </div>
</form>

@endsection

@section('scripts')
<script>
const packages = @json($packages);

function updatePackagePreview(select) {
    const id = parseInt(select.value);
    const pkg = packages.find(p => p.id === id);
    const preview = document.getElementById('packagePreview');
    if (!pkg) { preview.classList.add('d-none'); return; }
    preview.classList.remove('d-none');
    document.getElementById('pkgName').textContent = pkg.name_ar;
    document.getElementById('pkgDesc').textContent = pkg.description_ar || '';
    document.getElementById('pkgPrice').textContent = Number(pkg.price).toLocaleString('ar') + ' ' + pkg.currency;
    document.getElementById('pkgDuration').textContent = pkg.duration ? 'المدة: ' + pkg.duration : '';
}

// Trigger preview if old value exists
document.addEventListener('DOMContentLoaded', function() {
    const sel = document.getElementById('umrah_package_id');
    if (sel && sel.value) updatePackagePreview(sel);

    document.getElementById('orderCreateForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
    });
});
</script>
@endsection
