@extends('layouts.admin')

@section('title', 'إعدادات الموقع')
@section('page-title', 'إعدادات الموقع')
@section('page-description', 'إدارة إعدادات الموقع العامة')

@section('content')

{{-- System Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:var(--hd-grad-primary);">
                <i class="fas fa-users"></i>
            </div>
            <div class="hd-stat__value">{{ \App\Models\User::count() }}</div>
            <div class="hd-stat__label">المستخدمون</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="hd-stat__value" style="color:#22c55e;">{{ \App\Models\Order::count() }}</div>
            <div class="hd-stat__label">الطلبات</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <i class="fas fa-kaaba"></i>
            </div>
            <div class="hd-stat__value" style="color:#3b82f6;">{{ \App\Models\UmrahPackage::count() }}</div>
            <div class="hd-stat__label">حزم العمرة</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="hd-stat">
            <div class="hd-stat__icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                <i class="fas fa-coins"></i>
            </div>
            <div class="hd-stat__value" style="color:#f59e0b;">{{ number_format(\App\Models\Order::sum('total_amount'), 0) }}</div>
            <div class="hd-stat__label">إجمالي الإيرادات</div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- General Settings --}}
    <div class="col-lg-6">
        <div class="hd-form-section h-100">
            <div class="hd-form-section__header">
                <div class="hd-form-section__header-icon"><i class="fas fa-cog"></i></div>
                <div>
                    <div class="hd-form-section__header-title">الإعدادات العامة</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.75);">إعدادات الموقع الأساسية</div>
                </div>
            </div>
            <div class="hd-form-section__body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf @method('PUT')

                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-globe"></i> اسم الموقع</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-globe"></i>
                            <input type="text" name="site_name" class="hd-input"
                                   value="{{ old('site_name', 'هدية') }}" required>
                        </div>
                    </div>

                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-info-circle"></i> وصف الموقع</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-info-circle"></i>
                            <textarea name="site_description" rows="2" class="hd-input"
                                      placeholder="وصف مختصر للموقع">{{ old('site_description', 'منصة حجز حزم العمرة') }}</textarea>
                        </div>
                    </div>

                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-envelope"></i> البريد الإلكتروني للتواصل</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-envelope"></i>
                            <input type="email" name="contact_email" class="hd-input"
                                   value="{{ old('contact_email', 'info@hadih.com') }}" required>
                        </div>
                    </div>

                    <div class="hd-form-group mb-0">
                        <label class="hd-label"><i class="fas fa-phone"></i> رقم الهاتف</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-phone"></i>
                            <input type="tel" name="contact_phone" class="hd-input"
                                   value="{{ old('contact_phone', '+966 50 123 4567') }}">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="hd-btn hd-btn--primary">
                            <i class="fas fa-save"></i> حفظ الإعدادات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Payment Settings --}}
    <div class="col-lg-6">
        <div class="hd-form-section h-100">
            <div class="hd-form-section__header" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
                <div class="hd-form-section__header-icon"><i class="fas fa-credit-card"></i></div>
                <div>
                    <div class="hd-form-section__header-title">إعدادات الدفع</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.75);">إعدادات طرق الدفع المتاحة</div>
                </div>
            </div>
            <div class="hd-form-section__body">
                <form method="POST" action="{{ route('admin.settings.payment') }}">
                    @csrf @method('PUT')

                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-list"></i> طرق الدفع المتاحة</label>
                        <div class="d-flex flex-column gap-2">
                            @foreach(['visa'=>['fab fa-cc-visa','فيزا'],'mastercard'=>['fab fa-cc-mastercard','ماستركارد'],'mada'=>['fas fa-credit-card','مدى']] as $val=>$info)
                            <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer;padding:.5rem .75rem;border-radius:10px;background:#f8fafc;border:1px solid #e2e8f0;">
                                <input type="checkbox" name="payment_methods[]" value="{{ $val }}" checked
                                       style="accent-color:var(--hd-primary);">
                                <i class="{{ $info[0] }}" style="font-size:1.1rem;color:#667eea;"></i>
                                <span style="font-weight:600;font-size:.875rem;">{{ $info[1] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-coins"></i> العملة الافتراضية</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-coins"></i>
                            <select name="default_currency" class="hd-input hd-select">
                                <option value="SAR" selected>ريال سعودي (SAR)</option>
                                <option value="USD">دولار أمريكي (USD)</option>
                                <option value="EUR">يورو (EUR)</option>
                            </select>
                        </div>
                    </div>

                    <div class="hd-form-group mb-0">
                        <label style="display:flex;align-items:center;gap:.75rem;cursor:pointer;padding:.75rem 1rem;border-radius:12px;background:#f8fafc;border:1px solid #e2e8f0;">
                            <input type="checkbox" name="payment_enabled" id="payment_enabled" checked
                                   style="width:1.1rem;height:1.1rem;accent-color:var(--hd-primary);">
                            <div>
                                <div style="font-weight:700;font-size:.875rem;">تفعيل نظام الدفع</div>
                                <div style="font-size:.75rem;color:#94a3b8;">السماح بعمليات الدفع الإلكتروني</div>
                            </div>
                        </label>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="hd-btn hd-btn--success">
                            <i class="fas fa-save"></i> حفظ إعدادات الدفع
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Email Settings --}}
    <div class="col-lg-6">
        <div class="hd-form-section h-100">
            <div class="hd-form-section__header" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <div class="hd-form-section__header-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <div class="hd-form-section__header-title">إعدادات البريد الإلكتروني</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.75);">إعدادات إرسال الرسائل</div>
                </div>
            </div>
            <div class="hd-form-section__body">
                <form method="POST" action="{{ route('admin.settings.email') }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-server"></i> خادم SMTP</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-server"></i>
                                    <input type="text" name="smtp_host" class="hd-input"
                                           value="{{ old('smtp_host','smtp.gmail.com') }}" placeholder="smtp.gmail.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hd-form-group">
                                <label class="hd-label"><i class="fas fa-hashtag"></i> المنفذ</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-hashtag"></i>
                                    <input type="number" name="smtp_port" class="hd-input"
                                           value="{{ old('smtp_port','587') }}" placeholder="587">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-user"></i> اسم المستخدم</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-user"></i>
                            <input type="text" name="smtp_username" class="hd-input"
                                   value="{{ old('smtp_username') }}" placeholder="user@gmail.com">
                        </div>
                    </div>

                    <div class="hd-form-group">
                        <label class="hd-label"><i class="fas fa-key"></i> كلمة المرور</label>
                        <div class="hd-input-wrap">
                            <i class="hd-input-icon fas fa-key"></i>
                            <input type="password" id="smtpPass" name="smtp_password"
                                   class="hd-input hd-input--with-action" placeholder="••••••••">
                            <i class="hd-input-action fas fa-eye" onclick="togglePass('smtpPass',this)"></i>
                        </div>
                    </div>

                    <div class="hd-form-group mb-0">
                        <label style="display:flex;align-items:center;gap:.75rem;cursor:pointer;padding:.75rem 1rem;border-radius:12px;background:#f8fafc;border:1px solid #e2e8f0;">
                            <input type="checkbox" name="email_enabled" id="email_enabled"
                                   style="width:1.1rem;height:1.1rem;accent-color:#3b82f6;">
                            <div>
                                <div style="font-weight:700;font-size:.875rem;">تفعيل إرسال الرسائل</div>
                                <div style="font-size:.75rem;color:#94a3b8;">إرسال إشعارات البريد الإلكتروني</div>
                            </div>
                        </label>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="hd-btn hd-btn--primary" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                            <i class="fas fa-save"></i> حفظ إعدادات البريد
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- System Settings --}}
    <div class="col-lg-6">
        <div class="hd-form-section h-100">
            <div class="hd-form-section__header" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                <div class="hd-form-section__header-icon"><i class="fas fa-server"></i></div>
                <div>
                    <div class="hd-form-section__header-title">إعدادات النظام</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.75);">إعدادات النظام العامة</div>
                </div>
            </div>
            <div class="hd-form-section__body">
                <form method="POST" action="{{ route('admin.settings.system') }}">
                    @csrf @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label style="display:flex;align-items:center;justify-content:space-between;padding:.875rem 1rem;border-radius:12px;background:#fff3cd;border:1px solid #fde68a;cursor:pointer;">
                                <div>
                                    <div style="font-weight:700;font-size:.875rem;color:#92400e;">وضع الصيانة</div>
                                    <div style="font-size:.75rem;color:#a16207;">تعطيل الموقع مؤقتاً للصيانة</div>
                                </div>
                                <input type="checkbox" name="maintenance_mode" id="maintenance_mode"
                                       style="width:1.1rem;height:1.1rem;accent-color:#f59e0b;">
                            </label>
                        </div>
                        <div class="col-12">
                            <label style="display:flex;align-items:center;justify-content:space-between;padding:.875rem 1rem;border-radius:12px;background:#f0fdf4;border:1px solid #dcfce7;cursor:pointer;">
                                <div>
                                    <div style="font-weight:700;font-size:.875rem;color:#166534;">السماح بالتسجيل</div>
                                    <div style="font-size:.75rem;color:#15803d;">قبول تسجيل مستخدمين جدد</div>
                                </div>
                                <input type="checkbox" name="registration_enabled" id="registration_enabled" checked
                                       style="width:1.1rem;height:1.1rem;accent-color:#22c55e;">
                            </label>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="hd-form-group mb-0">
                                <label class="hd-label"><i class="fas fa-list-ol"></i> الحد الأقصى للطلبات</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-list-ol"></i>
                                    <input type="number" name="max_orders_per_user" class="hd-input"
                                           value="{{ old('max_orders_per_user','10') }}" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="hd-form-group mb-0">
                                <label class="hd-label"><i class="fas fa-calendar-times"></i> مدة انتهاء الطلب</label>
                                <div class="hd-input-wrap">
                                    <i class="hd-input-icon fas fa-calendar-times"></i>
                                    <input type="number" name="order_expiry_days" class="hd-input"
                                           value="{{ old('order_expiry_days','30') }}" min="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="hd-btn hd-btn--warning">
                            <i class="fas fa-save"></i> حفظ إعدادات النظام
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
function togglePass(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'text' ? 'hd-input-action fas fa-eye-slash' : 'hd-input-action fas fa-eye';
}
</script>
@endsection
