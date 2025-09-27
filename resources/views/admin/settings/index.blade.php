@extends('layouts.admin')

@section('title', 'إعدادات الموقع')
@section('page-title', 'إعدادات الموقع')
@section('page-description', 'إدارة إعدادات الموقع العامة')

@section('content')
    <!-- Settings Cards -->
    <div class="row">
        <!-- General Settings -->
        <div class="col-lg-6 mb-4">
            <div class="content-card animate-on-scroll">
                <div class="settings-header">
                    <h3 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        الإعدادات العامة
                    </h3>
                    <p class="mb-0 mt-2">إعدادات الموقع الأساسية</p>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="site_name" class="form-label">اسم الموقع</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" 
                                   value="{{ old('site_name', 'هدية') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="site_description" class="form-label">وصف الموقع</label>
                            <textarea class="form-control" id="site_description" name="site_description" rows="3">{{ old('site_description', 'منصة حجز حزم العمرة') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">البريد الإلكتروني للتواصل</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                   value="{{ old('contact_email', 'info@hadih.com') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" 
                                   value="{{ old('contact_phone', '+966 50 123 4567') }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary hover-lift">
                            <i class="fas fa-save me-2"></i>حفظ الإعدادات
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Payment Settings -->
        <div class="col-lg-6 mb-4">
            <div class="content-card animate-on-scroll">
                <div class="settings-header">
                    <h3 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        إعدادات الدفع
                    </h3>
                    <p class="mb-0 mt-2">إعدادات طرق الدفع المتاحة</p>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.settings.payment') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">طرق الدفع المتاحة</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="payment_visa" name="payment_methods[]" value="visa" checked>
                                <label class="form-check-label" for="payment_visa">
                                    <i class="fab fa-cc-visa me-2"></i>فيزا
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="payment_mastercard" name="payment_methods[]" value="mastercard" checked>
                                <label class="form-check-label" for="payment_mastercard">
                                    <i class="fab fa-cc-mastercard me-2"></i>ماستركارد
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="payment_mada" name="payment_methods[]" value="mada" checked>
                                <label class="form-check-label" for="payment_mada">
                                    <i class="fas fa-credit-card me-2"></i>مدى
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="default_currency" class="form-label">العملة الافتراضية</label>
                            <select class="form-select" id="default_currency" name="default_currency">
                                <option value="SAR" selected>ريال سعودي (SAR)</option>
                                <option value="USD">دولار أمريكي (USD)</option>
                                <option value="EUR">يورو (EUR)</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="payment_enabled" name="payment_enabled" checked>
                                <label class="form-check-label" for="payment_enabled">
                                    تفعيل نظام الدفع
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary hover-lift">
                            <i class="fas fa-save me-2"></i>حفظ إعدادات الدفع
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Email Settings -->
        <div class="col-lg-6 mb-4">
            <div class="content-card animate-on-scroll">
                <div class="settings-header">
                    <h3 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        إعدادات البريد الإلكتروني
                    </h3>
                    <p class="mb-0 mt-2">إعدادات إرسال الرسائل</p>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.settings.email') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="smtp_host" class="form-label">خادم SMTP</label>
                            <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                                   value="{{ old('smtp_host', 'smtp.gmail.com') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="smtp_port" class="form-label">منفذ SMTP</label>
                            <input type="number" class="form-control" id="smtp_port" name="smtp_port" 
                                   value="{{ old('smtp_port', '587') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="smtp_username" class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" id="smtp_username" name="smtp_username" 
                                   value="{{ old('smtp_username') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="smtp_password" class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" id="smtp_password" name="smtp_password">
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_enabled" name="email_enabled">
                                <label class="form-check-label" for="email_enabled">
                                    تفعيل إرسال الرسائل
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary hover-lift">
                            <i class="fas fa-save me-2"></i>حفظ إعدادات البريد
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- System Settings -->
        <div class="col-lg-6 mb-4">
            <div class="content-card animate-on-scroll">
                <div class="settings-header">
                    <h3 class="mb-0">
                        <i class="fas fa-server me-2"></i>
                        إعدادات النظام
                    </h3>
                    <p class="mb-0 mt-2">إعدادات النظام العامة</p>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.settings.system') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="maintenance_mode" class="form-label">وضع الصيانة</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode">
                                <label class="form-check-label" for="maintenance_mode">
                                    تفعيل وضع الصيانة
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="registration_enabled" class="form-label">التسجيل</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="registration_enabled" name="registration_enabled" checked>
                                <label class="form-check-label" for="registration_enabled">
                                    السماح بالتسجيل الجديد
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="max_orders_per_user" class="form-label">الحد الأقصى للطلبات لكل مستخدم</label>
                            <input type="number" class="form-control" id="max_orders_per_user" name="max_orders_per_user" 
                                   value="{{ old('max_orders_per_user', '10') }}" min="1">
                        </div>
                        
                        <div class="mb-3">
                            <label for="order_expiry_days" class="form-label">مدة انتهاء الطلب (بالأيام)</label>
                            <input type="number" class="form-control" id="order_expiry_days" name="order_expiry_days" 
                                   value="{{ old('order_expiry_days', '30') }}" min="1">
                        </div>
                        
                        <button type="submit" class="btn btn-primary hover-lift">
                            <i class="fas fa-save me-2"></i>حفظ إعدادات النظام
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Card -->
    <div class="row">
        <div class="col-12">
            <div class="content-card animate-on-scroll">
                <div class="settings-header">
                    <h3 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        إحصائيات النظام
                    </h3>
                    <p class="mb-0 mt-2">نظرة عامة على إحصائيات النظام</p>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="stats-icon users">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stats-number">{{ \App\Models\User::count() }}</div>
                                <div class="stats-label">إجمالي المستخدمين</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="stats-icon orders">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="stats-number">{{ \App\Models\Order::count() }}</div>
                                <div class="stats-label">إجمالي الطلبات</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="stats-icon packages">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="stats-number">{{ \App\Models\UmrahPackage::count() }}</div>
                                <div class="stats-label">حزم العمرة</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="stats-icon revenue">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="stats-number">{{ number_format(\App\Models\Order::sum('total_amount'), 0) }}</div>
                                <div class="stats-label">إجمالي الإيرادات (ريال)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .settings-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .settings-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endsection
