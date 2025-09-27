@extends('layouts.user')

@section('title', 'إنشاء طلب عمرة جديد - هدية')
@section('page-title', 'إنشاء طلب عمرة جديد')
@section('page-description', 'ابدأ رحلتك الروحية بطلب عمرة جديدة')

@section('content')
<style>
    .order-create-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        animation: slideUp 0.6s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .form-header::before {
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
    
    .form-header h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .form-header p {
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 2;
    }
    
    .form-body {
        padding: 2.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-label i {
        color: #667eea;
        font-size: 1.1rem;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: rgba(255, 255, 255, 0.95);
        transform: translateY(-2px);
    }
    
    .form-control:hover, .form-select:hover {
        border-color: #667eea;
        transform: translateY(-1px);
    }
    
    .btn {
        border-radius: 15px;
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn:hover::before {
        left: 100%;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border: none;
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
    }
    
    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(108, 117, 125, 0.4);
    }
    
    .package-preview {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .package-preview:hover {
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .package-name {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .package-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .currency-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
        gap: 1rem;
    }
    
    .step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    
    .step.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: scale(1.1);
    }
    
    .step.completed {
        background: #28a745;
        color: white;
    }
    
    .floating-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }
    
    .floating-element {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: floatAround 20s infinite linear;
    }
    
    .floating-element:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .floating-element:nth-child(2) {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 15%;
        animation-delay: -7s;
    }
    
    .floating-element:nth-child(3) {
        width: 100px;
        height: 100px;
        bottom: 20%;
        left: 20%;
        animation-delay: -14s;
    }
    
    @keyframes floatAround {
        0% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-30px) rotate(120deg); }
        66% { transform: translateY(15px) rotate(240deg); }
        100% { transform: translateY(0px) rotate(360deg); }
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .section-title {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.2rem;
    }
    
    .section-title i {
        color: #667eea;
        font-size: 1.3rem;
    }
    
    @media (max-width: 768px) {
        .form-body {
            padding: 1.5rem;
        }
        
        .form-header {
            padding: 1.5rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>

<div class="order-create-container">
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="form-card">
                    <!-- Header -->
                    <div class="form-header">
                        <img src="{{ asset('images/logo.jpg') }}" alt="هدية" style="height: 60px; width: auto;" class="mb-3" onerror="this.style.display='none'">
                        <h2>إنشاء طلب عمرة جديد</h2>
                        <p>املأ البيانات التالية لإنشاء طلب عمرة جديد</p>
                    </div>
                    
                    <!-- Form Body -->
                    <div class="form-body">
                        <form method="POST" action="{{ route('orders.store') }}" id="orderForm">
                            @csrf
                            
                            <!-- Package Selection Section -->
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-box"></i>
                                    اختيار حزمة العمرة
                                </div>
                                
                                <div class="form-group">
                                    <label for="umrah_package_id" class="form-label">
                                        <i class="fas fa-list"></i>
                                        حزمة العمرة
                                    </label>
                                    <select class="form-select @error('umrah_package_id') is-invalid @enderror" id="umrah_package_id" name="umrah_package_id" required>
                                        <option value="">اختر حزمة العمرة</option>
                                        @foreach($packages as $package)
                                        <option value="{{ $package->id }}" {{ old('umrah_package_id') == $package->id ? 'selected' : '' }}>
                                            {{ $package->name_ar }} - {{ number_format($package->price) }} {{ $package->currency }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('umrah_package_id')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Package Preview -->
                                <div id="packagePreview" class="package-preview" style="display: none;">
                                    <div class="package-name" id="packageName"></div>
                                    <div class="package-price">
                                        <span id="packagePrice"></span>
                                        <img id="packageCurrency" src="" alt="" class="currency-icon">
                                        <span id="packageCurrencyText"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Beneficiary Information Section -->
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-user"></i>
                                    معلومات المستفيد
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="beneficiary_name" class="form-label">
                                                <i class="fas fa-user-circle"></i>
                                                اسم المستفيد
                                            </label>
                                            <input type="text" class="form-control @error('beneficiary_name') is-invalid @enderror" 
                                                   id="beneficiary_name" name="beneficiary_name" 
                                                   value="{{ old('beneficiary_name') }}" 
                                                   placeholder="أدخل اسم المستفيد" required>
                                            @error('beneficiary_name')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="beneficiary_phone" class="form-label">
                                                <i class="fas fa-phone"></i>
                                                هاتف المستفيد
                                            </label>
                                            <input type="tel" class="form-control @error('beneficiary_phone') is-invalid @enderror" 
                                                   id="beneficiary_phone" name="beneficiary_phone" 
                                                   value="{{ old('beneficiary_phone') }}" 
                                                   placeholder="أدخل رقم الهاتف" required>
                                            @error('beneficiary_phone')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- WhatsApp Phone Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fab fa-whatsapp"></i>
                                                رقم واتساب للتواصل وإرسال فيديو الإثبات
                                            </label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="form-select @error('whatsapp_country_code') is-invalid @enderror" 
                                                            id="whatsapp_country_code" name="whatsapp_country_code" required>
                                                        <option value="">كود الدولة</option>
                                                        <option value="+966" {{ old('whatsapp_country_code') == '+966' ? 'selected' : '' }}>🇸🇦 السعودية (+966)</option>
                                                        <option value="+971" {{ old('whatsapp_country_code') == '+971' ? 'selected' : '' }}>🇦🇪 الإمارات (+971)</option>
                                                        <option value="+965" {{ old('whatsapp_country_code') == '+965' ? 'selected' : '' }}>🇰🇼 الكويت (+965)</option>
                                                        <option value="+973" {{ old('whatsapp_country_code') == '+973' ? 'selected' : '' }}>🇧🇭 البحرين (+973)</option>
                                                        <option value="+974" {{ old('whatsapp_country_code') == '+974' ? 'selected' : '' }}>🇶🇦 قطر (+974)</option>
                                                        <option value="+968" {{ old('whatsapp_country_code') == '+968' ? 'selected' : '' }}>🇴🇲 عمان (+968)</option>
                                                        <option value="+20" {{ old('whatsapp_country_code') == '+20' ? 'selected' : '' }}>🇪🇬 مصر (+20)</option>
                                                        <option value="+212" {{ old('whatsapp_country_code') == '+212' ? 'selected' : '' }}>🇲🇦 المغرب (+212)</option>
                                                        <option value="+213" {{ old('whatsapp_country_code') == '+213' ? 'selected' : '' }}>🇩🇿 الجزائر (+213)</option>
                                                        <option value="+216" {{ old('whatsapp_country_code') == '+216' ? 'selected' : '' }}>🇹🇳 تونس (+216)</option>
                                                        <option value="+218" {{ old('whatsapp_country_code') == '+218' ? 'selected' : '' }}>🇱🇾 ليبيا (+218)</option>
                                                        <option value="+249" {{ old('whatsapp_country_code') == '+249' ? 'selected' : '' }}>🇸🇩 السودان (+249)</option>
                                                        <option value="+964" {{ old('whatsapp_country_code') == '+964' ? 'selected' : '' }}>🇮🇶 العراق (+964)</option>
                                                        <option value="+963" {{ old('whatsapp_country_code') == '+963' ? 'selected' : '' }}>🇸🇾 سوريا (+963)</option>
                                                        <option value="+961" {{ old('whatsapp_country_code') == '+961' ? 'selected' : '' }}>🇱🇧 لبنان (+961)</option>
                                                        <option value="+962" {{ old('whatsapp_country_code') == '+962' ? 'selected' : '' }}>🇯🇴 الأردن (+962)</option>
                                                        <option value="+972" {{ old('whatsapp_country_code') == '+972' ? 'selected' : '' }}>🇵🇸 فلسطين (+972)</option>
                                                        <option value="+90" {{ old('whatsapp_country_code') == '+90' ? 'selected' : '' }}>🇹🇷 تركيا (+90)</option>
                                                        <option value="+98" {{ old('whatsapp_country_code') == '+98' ? 'selected' : '' }}>🇮🇷 إيران (+98)</option>
                                                        <option value="+93" {{ old('whatsapp_country_code') == '+93' ? 'selected' : '' }}>🇦🇫 أفغانستان (+93)</option>
                                                        <option value="+92" {{ old('whatsapp_country_code') == '+92' ? 'selected' : '' }}>🇵🇰 باكستان (+92)</option>
                                                        <option value="+91" {{ old('whatsapp_country_code') == '+91' ? 'selected' : '' }}>🇮🇳 الهند (+91)</option>
                                                        <option value="+880" {{ old('whatsapp_country_code') == '+880' ? 'selected' : '' }}>🇧🇩 بنغلاديش (+880)</option>
                                                        <option value="+94" {{ old('whatsapp_country_code') == '+94' ? 'selected' : '' }}>🇱🇰 سريلانكا (+94)</option>
                                                        <option value="+977" {{ old('whatsapp_country_code') == '+977' ? 'selected' : '' }}>🇳🇵 نيبال (+977)</option>
                                                        <option value="+1" {{ old('whatsapp_country_code') == '+1' ? 'selected' : '' }}>🇺🇸 الولايات المتحدة (+1)</option>
                                                        <option value="+44" {{ old('whatsapp_country_code') == '+44' ? 'selected' : '' }}>🇬🇧 المملكة المتحدة (+44)</option>
                                                        <option value="+33" {{ old('whatsapp_country_code') == '+33' ? 'selected' : '' }}>🇫🇷 فرنسا (+33)</option>
                                                        <option value="+49" {{ old('whatsapp_country_code') == '+49' ? 'selected' : '' }}>🇩🇪 ألمانيا (+49)</option>
                                                        <option value="+39" {{ old('whatsapp_country_code') == '+39' ? 'selected' : '' }}>🇮🇹 إيطاليا (+39)</option>
                                                        <option value="+34" {{ old('whatsapp_country_code') == '+34' ? 'selected' : '' }}>🇪🇸 إسبانيا (+34)</option>
                                                        <option value="+31" {{ old('whatsapp_country_code') == '+31' ? 'selected' : '' }}>🇳🇱 هولندا (+31)</option>
                                                        <option value="+32" {{ old('whatsapp_country_code') == '+32' ? 'selected' : '' }}>🇧🇪 بلجيكا (+32)</option>
                                                        <option value="+41" {{ old('whatsapp_country_code') == '+41' ? 'selected' : '' }}>🇨🇭 سويسرا (+41)</option>
                                                        <option value="+43" {{ old('whatsapp_country_code') == '+43' ? 'selected' : '' }}>🇦🇹 النمسا (+43)</option>
                                                        <option value="+46" {{ old('whatsapp_country_code') == '+46' ? 'selected' : '' }}>🇸🇪 السويد (+46)</option>
                                                        <option value="+47" {{ old('whatsapp_country_code') == '+47' ? 'selected' : '' }}>🇳🇴 النرويج (+47)</option>
                                                        <option value="+45" {{ old('whatsapp_country_code') == '+45' ? 'selected' : '' }}>🇩🇰 الدنمارك (+45)</option>
                                                        <option value="+358" {{ old('whatsapp_country_code') == '+358' ? 'selected' : '' }}>🇫🇮 فنلندا (+358)</option>
                                                        <option value="+7" {{ old('whatsapp_country_code') == '+7' ? 'selected' : '' }}>🇷🇺 روسيا (+7)</option>
                                                        <option value="+86" {{ old('whatsapp_country_code') == '+86' ? 'selected' : '' }}>🇨🇳 الصين (+86)</option>
                                                        <option value="+81" {{ old('whatsapp_country_code') == '+81' ? 'selected' : '' }}>🇯🇵 اليابان (+81)</option>
                                                        <option value="+82" {{ old('whatsapp_country_code') == '+82' ? 'selected' : '' }}>🇰🇷 كوريا الجنوبية (+82)</option>
                                                        <option value="+65" {{ old('whatsapp_country_code') == '+65' ? 'selected' : '' }}>🇸🇬 سنغافورة (+65)</option>
                                                        <option value="+60" {{ old('whatsapp_country_code') == '+60' ? 'selected' : '' }}>🇲🇾 ماليزيا (+60)</option>
                                                        <option value="+66" {{ old('whatsapp_country_code') == '+66' ? 'selected' : '' }}>🇹🇭 تايلاند (+66)</option>
                                                        <option value="+63" {{ old('whatsapp_country_code') == '+63' ? 'selected' : '' }}>🇵🇭 الفلبين (+63)</option>
                                                        <option value="+62" {{ old('whatsapp_country_code') == '+62' ? 'selected' : '' }}>🇮🇩 إندونيسيا (+62)</option>
                                                        <option value="+84" {{ old('whatsapp_country_code') == '+84' ? 'selected' : '' }}>🇻🇳 فيتنام (+84)</option>
                                                        <option value="+55" {{ old('whatsapp_country_code') == '+55' ? 'selected' : '' }}>🇧🇷 البرازيل (+55)</option>
                                                        <option value="+52" {{ old('whatsapp_country_code') == '+52' ? 'selected' : '' }}>🇲🇽 المكسيك (+52)</option>
                                                        <option value="+54" {{ old('whatsapp_country_code') == '+54' ? 'selected' : '' }}>🇦🇷 الأرجنتين (+54)</option>
                                                        <option value="+56" {{ old('whatsapp_country_code') == '+56' ? 'selected' : '' }}>🇨🇱 تشيلي (+56)</option>
                                                        <option value="+57" {{ old('whatsapp_country_code') == '+57' ? 'selected' : '' }}>🇨🇴 كولومبيا (+57)</option>
                                                        <option value="+51" {{ old('whatsapp_country_code') == '+51' ? 'selected' : '' }}>🇵🇪 بيرو (+51)</option>
                                                        <option value="+58" {{ old('whatsapp_country_code') == '+58' ? 'selected' : '' }}>🇻🇪 فنزويلا (+58)</option>
                                                        <option value="+27" {{ old('whatsapp_country_code') == '+27' ? 'selected' : '' }}>🇿🇦 جنوب أفريقيا (+27)</option>
                                                        <option value="+234" {{ old('whatsapp_country_code') == '+234' ? 'selected' : '' }}>🇳🇬 نيجيريا (+234)</option>
                                                        <option value="+254" {{ old('whatsapp_country_code') == '+254' ? 'selected' : '' }}>🇰🇪 كينيا (+254)</option>
                                                        <option value="+20" {{ old('whatsapp_country_code') == '+20' ? 'selected' : '' }}>🇪🇬 مصر (+20)</option>
                                                        <option value="+212" {{ old('whatsapp_country_code') == '+212' ? 'selected' : '' }}>🇲🇦 المغرب (+212)</option>
                                                        <option value="+213" {{ old('whatsapp_country_code') == '+213' ? 'selected' : '' }}>🇩🇿 الجزائر (+213)</option>
                                                        <option value="+216" {{ old('whatsapp_country_code') == '+216' ? 'selected' : '' }}>🇹🇳 تونس (+216)</option>
                                                        <option value="+218" {{ old('whatsapp_country_code') == '+218' ? 'selected' : '' }}>🇱🇾 ليبيا (+218)</option>
                                                        <option value="+249" {{ old('whatsapp_country_code') == '+249' ? 'selected' : '' }}>🇸🇩 السودان (+249)</option>
                                                        <option value="+251" {{ old('whatsapp_country_code') == '+251' ? 'selected' : '' }}>🇪🇹 إثيوبيا (+251)</option>
                                                        <option value="+255" {{ old('whatsapp_country_code') == '+255' ? 'selected' : '' }}>🇹🇿 تنزانيا (+255)</option>
                                                        <option value="+256" {{ old('whatsapp_country_code') == '+256' ? 'selected' : '' }}>🇺🇬 أوغندا (+256)</option>
                                                        <option value="+250" {{ old('whatsapp_country_code') == '+250' ? 'selected' : '' }}>🇷🇼 رواندا (+250)</option>
                                                        <option value="+257" {{ old('whatsapp_country_code') == '+257' ? 'selected' : '' }}>🇧🇮 بوروندي (+257)</option>
                                                        <option value="+258" {{ old('whatsapp_country_code') == '+258' ? 'selected' : '' }}>🇲🇿 موزمبيق (+258)</option>
                                                        <option value="+260" {{ old('whatsapp_country_code') == '+260' ? 'selected' : '' }}>🇿🇲 زامبيا (+260)</option>
                                                        <option value="+263" {{ old('whatsapp_country_code') == '+263' ? 'selected' : '' }}>🇿🇼 زيمبابوي (+263)</option>
                                                        <option value="+264" {{ old('whatsapp_country_code') == '+264' ? 'selected' : '' }}>🇳🇦 ناميبيا (+264)</option>
                                                        <option value="+267" {{ old('whatsapp_country_code') == '+267' ? 'selected' : '' }}>🇧🇼 بوتسوانا (+267)</option>
                                                        <option value="+268" {{ old('whatsapp_country_code') == '+268' ? 'selected' : '' }}>🇸🇿 إسواتيني (+268)</option>
                                                        <option value="+266" {{ old('whatsapp_country_code') == '+266' ? 'selected' : '' }}>🇱🇸 ليسوتو (+266)</option>
                                                        <option value="+27" {{ old('whatsapp_country_code') == '+27' ? 'selected' : '' }}>🇿🇦 جنوب أفريقيا (+27)</option>
                                                        <option value="+61" {{ old('whatsapp_country_code') == '+61' ? 'selected' : '' }}>🇦🇺 أستراليا (+61)</option>
                                                        <option value="+64" {{ old('whatsapp_country_code') == '+64' ? 'selected' : '' }}>🇳🇿 نيوزيلندا (+64)</option>
                                                        <option value="+679" {{ old('whatsapp_country_code') == '+679' ? 'selected' : '' }}>🇫🇯 فيجي (+679)</option>
                                                        <option value="+685" {{ old('whatsapp_country_code') == '+685' ? 'selected' : '' }}>🇼🇸 ساموا (+685)</option>
                                                        <option value="+676" {{ old('whatsapp_country_code') == '+676' ? 'selected' : '' }}>🇹🇴 تونغا (+676)</option>
                                                        <option value="+678" {{ old('whatsapp_country_code') == '+678' ? 'selected' : '' }}>🇻🇺 فانواتو (+678)</option>
                                                        <option value="+687" {{ old('whatsapp_country_code') == '+687' ? 'selected' : '' }}>🇳🇨 كاليدونيا الجديدة (+687)</option>
                                                        <option value="+689" {{ old('whatsapp_country_code') == '+689' ? 'selected' : '' }}>🇵🇫 بولينيزيا الفرنسية (+689)</option>
                                                        <option value="+690" {{ old('whatsapp_country_code') == '+690' ? 'selected' : '' }}>🇹🇰 توكيلاو (+690)</option>
                                                        <option value="+691" {{ old('whatsapp_country_code') == '+691' ? 'selected' : '' }}>🇫🇲 ميكرونيزيا (+691)</option>
                                                        <option value="+692" {{ old('whatsapp_country_code') == '+692' ? 'selected' : '' }}>🇲🇭 جزر مارشال (+692)</option>
                                                        <option value="+850" {{ old('whatsapp_country_code') == '+850' ? 'selected' : '' }}>🇰🇵 كوريا الشمالية (+850)</option>
                                                        <option value="+855" {{ old('whatsapp_country_code') == '+855' ? 'selected' : '' }}>🇰🇭 كمبوديا (+855)</option>
                                                        <option value="+856" {{ old('whatsapp_country_code') == '+856' ? 'selected' : '' }}>🇱🇦 لاوس (+856)</option>
                                                        <option value="+880" {{ old('whatsapp_country_code') == '+880' ? 'selected' : '' }}>🇧🇩 بنغلاديش (+880)</option>
                                                        <option value="+886" {{ old('whatsapp_country_code') == '+886' ? 'selected' : '' }}>🇹🇼 تايوان (+886)</option>
                                                        <option value="+960" {{ old('whatsapp_country_code') == '+960' ? 'selected' : '' }}>🇲🇻 المالديف (+960)</option>
                                                        <option value="+961" {{ old('whatsapp_country_code') == '+961' ? 'selected' : '' }}>🇱🇧 لبنان (+961)</option>
                                                        <option value="+962" {{ old('whatsapp_country_code') == '+962' ? 'selected' : '' }}>🇯🇴 الأردن (+962)</option>
                                                        <option value="+963" {{ old('whatsapp_country_code') == '+963' ? 'selected' : '' }}>🇸🇾 سوريا (+963)</option>
                                                        <option value="+964" {{ old('whatsapp_country_code') == '+964' ? 'selected' : '' }}>🇮🇶 العراق (+964)</option>
                                                        <option value="+965" {{ old('whatsapp_country_code') == '+965' ? 'selected' : '' }}>🇰🇼 الكويت (+965)</option>
                                                        <option value="+966" {{ old('whatsapp_country_code') == '+966' ? 'selected' : '' }}>🇸🇦 السعودية (+966)</option>
                                                        <option value="+967" {{ old('whatsapp_country_code') == '+967' ? 'selected' : '' }}>🇾🇪 اليمن (+967)</option>
                                                        <option value="+968" {{ old('whatsapp_country_code') == '+968' ? 'selected' : '' }}>🇴🇲 عمان (+968)</option>
                                                        <option value="+970" {{ old('whatsapp_country_code') == '+970' ? 'selected' : '' }}>🇵🇸 فلسطين (+970)</option>
                                                        <option value="+971" {{ old('whatsapp_country_code') == '+971' ? 'selected' : '' }}>🇦🇪 الإمارات (+971)</option>
                                                        <option value="+972" {{ old('whatsapp_country_code') == '+972' ? 'selected' : '' }}>🇮🇱 إسرائيل (+972)</option>
                                                        <option value="+973" {{ old('whatsapp_country_code') == '+973' ? 'selected' : '' }}>🇧🇭 البحرين (+973)</option>
                                                        <option value="+974" {{ old('whatsapp_country_code') == '+974' ? 'selected' : '' }}>🇶🇦 قطر (+974)</option>
                                                        <option value="+975" {{ old('whatsapp_country_code') == '+975' ? 'selected' : '' }}>🇧🇹 بوتان (+975)</option>
                                                        <option value="+976" {{ old('whatsapp_country_code') == '+976' ? 'selected' : '' }}>🇲🇳 منغوليا (+976)</option>
                                                        <option value="+977" {{ old('whatsapp_country_code') == '+977' ? 'selected' : '' }}>🇳🇵 نيبال (+977)</option>
                                                        <option value="+992" {{ old('whatsapp_country_code') == '+992' ? 'selected' : '' }}>🇹🇯 طاجيكستان (+992)</option>
                                                        <option value="+993" {{ old('whatsapp_country_code') == '+993' ? 'selected' : '' }}>🇹🇲 تركمانستان (+993)</option>
                                                        <option value="+994" {{ old('whatsapp_country_code') == '+994' ? 'selected' : '' }}>🇦🇿 أذربيجان (+994)</option>
                                                        <option value="+995" {{ old('whatsapp_country_code') == '+995' ? 'selected' : '' }}>🇬🇪 جورجيا (+995)</option>
                                                        <option value="+996" {{ old('whatsapp_country_code') == '+996' ? 'selected' : '' }}>🇰🇬 قيرغيزستان (+996)</option>
                                                        <option value="+998" {{ old('whatsapp_country_code') == '+998' ? 'selected' : '' }}>🇺🇿 أوزبكستان (+998)</option>
                                                    </select>
                                                    @error('whatsapp_country_code')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="tel" class="form-control @error('whatsapp_phone') is-invalid @enderror" 
                                                           id="whatsapp_phone" name="whatsapp_phone" 
                                                           value="{{ old('whatsapp_phone') }}" 
                                                           placeholder="أدخل رقم الواتساب بدون كود الدولة" required>
                                                    @error('whatsapp_phone')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle"></i>
                                                يجب توافر رقم واتساب لإرسال فيديو الإثبات والتواصل عليه
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="beneficiary_type" class="form-label">
                                        <i class="fas fa-heart"></i>
                                        نوع المستفيد
                                    </label>
                                    <select class="form-select @error('beneficiary_type') is-invalid @enderror" id="beneficiary_type" name="beneficiary_type" required>
                                        <option value="">اختر نوع المستفيد</option>
                                        <option value="deceased" {{ old('beneficiary_type') == 'deceased' ? 'selected' : '' }}>
                                            <i class="fas fa-pray"></i> متوفى
                                        </option>
                                        <option value="sick" {{ old('beneficiary_type') == 'sick' ? 'selected' : '' }}>
                                            <i class="fas fa-heartbeat"></i> مريض
                                        </option>
                                        <option value="elderly" {{ old('beneficiary_type') == 'elderly' ? 'selected' : '' }}>
                                            <i class="fas fa-user-clock"></i> مسن
                                        </option>
                                        <option value="disabled" {{ old('beneficiary_type') == 'disabled' ? 'selected' : '' }}>
                                            <i class="fas fa-wheelchair"></i> معاق
                                        </option>
                                    </select>
                                    @error('beneficiary_type')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="beneficiary_details" class="form-label">
                                        <i class="fas fa-info-circle"></i>
                                        تفاصيل إضافية
                                    </label>
                                    <textarea class="form-control @error('beneficiary_details') is-invalid @enderror" 
                                              id="beneficiary_details" name="beneficiary_details" 
                                              rows="4" placeholder="أدخل أي تفاصيل إضافية حول المستفيد">{{ old('beneficiary_details') }}</textarea>
                                    @error('beneficiary_details')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>إنشاء الطلب
                                </button>
                                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>إلغاء
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageSelect = document.getElementById('umrah_package_id');
    const packagePreview = document.getElementById('packagePreview');
    const packageName = document.getElementById('packageName');
    const packagePrice = document.getElementById('packagePrice');
    const packageCurrency = document.getElementById('packageCurrency');
    const packageCurrencyText = document.getElementById('packageCurrencyText');
    
    // Package data for preview
    const packages = @json($packages);
    
    packageSelect.addEventListener('change', function() {
        const selectedPackageId = this.value;
        const selectedPackage = packages.find(pkg => pkg.id == selectedPackageId);
        
        if (selectedPackage) {
            packageName.textContent = selectedPackage.name_ar;
            packagePrice.textContent = new Intl.NumberFormat('ar-SA').format(selectedPackage.price);
            packageCurrencyText.textContent = selectedPackage.currency;
            
            // Set currency icon
            const currencyIconPath = `/images/currencies/${selectedPackage.currency.toLowerCase()}.svg`;
            packageCurrency.src = currencyIconPath;
            packageCurrency.alt = selectedPackage.currency;
            
            packagePreview.style.display = 'block';
            packagePreview.style.animation = 'slideUp 0.5s ease-out';
        } else {
            packagePreview.style.display = 'none';
        }
    });
    
    // Form validation enhancement
    const form = document.getElementById('orderForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('يرجى ملء جميع الحقول المطلوبة');
        }
    });
    
    // Real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Phone number formatting
    const phoneInput = document.getElementById('beneficiary_phone');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.startsWith('966')) {
                value = value.substring(3);
            }
            if (value.length >= 9) {
                value = value.substring(0, 9);
            }
            this.value = value;
        }
    });
    
    // WhatsApp phone number formatting
    const whatsappPhoneInput = document.getElementById('whatsapp_phone');
    const whatsappCountryCodeSelect = document.getElementById('whatsapp_country_code');
    
    whatsappPhoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        
        // Remove country code if user types it
        const selectedCountryCode = whatsappCountryCodeSelect.value;
        if (selectedCountryCode && value.startsWith(selectedCountryCode.replace('+', ''))) {
            value = value.substring(selectedCountryCode.replace('+', '').length);
        }
        
        // Limit length based on country code
        let maxLength = 15; // Default max length
        if (selectedCountryCode) {
            switch(selectedCountryCode) {
                case '+966': // Saudi Arabia
                    maxLength = 9;
                    break;
                case '+971': // UAE
                    maxLength = 9;
                    break;
                case '+965': // Kuwait
                    maxLength = 8;
                    break;
                case '+973': // Bahrain
                    maxLength = 8;
                    break;
                case '+974': // Qatar
                    maxLength = 8;
                    break;
                case '+968': // Oman
                    maxLength = 8;
                    break;
                case '+20': // Egypt
                    maxLength = 10;
                    break;
                case '+1': // US/Canada
                    maxLength = 10;
                    break;
                case '+44': // UK
                    maxLength = 10;
                    break;
                default:
                    maxLength = 15;
            }
        }
        
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }
        
        this.value = value;
    });
    
    // Update placeholder based on selected country
    whatsappCountryCodeSelect.addEventListener('change', function() {
        const selectedCode = this.value;
        let placeholder = 'أدخل رقم الواتساب بدون كود الدولة';
        
        if (selectedCode) {
            switch(selectedCode) {
                case '+966':
                    placeholder = 'مثال: 501234567';
                    break;
                case '+971':
                    placeholder = 'مثال: 501234567';
                    break;
                case '+965':
                    placeholder = 'مثال: 12345678';
                    break;
                case '+973':
                    placeholder = 'مثال: 12345678';
                    break;
                case '+974':
                    placeholder = 'مثال: 12345678';
                    break;
                case '+968':
                    placeholder = 'مثال: 12345678';
                    break;
                case '+20':
                    placeholder = 'مثال: 1012345678';
                    break;
                case '+1':
                    placeholder = 'مثال: 1234567890';
                    break;
                case '+44':
                    placeholder = 'مثال: 1234567890';
                    break;
                default:
                    placeholder = 'أدخل رقم الواتساب بدون كود الدولة';
            }
        }
        
        whatsappPhoneInput.placeholder = placeholder;
    });
});
</script>
@endsection