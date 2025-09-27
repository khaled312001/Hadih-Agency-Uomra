<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة طلب جديد - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            z-index: 1000;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            border-radius: 10px;
            margin: 5px 10px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(-5px);
        }
        
        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #fff;
            border-radius: 2px;
        }
        
        .main-content {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin-right: 250px;
            padding: 0;
        }
        
        .content-wrapper {
            padding: 30px;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-right: 0;
            }
            
            .content-wrapper {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4">
            <div class="text-center mb-4">
                <img src="/images/logo.jpg" alt="هدية" style="height: 40px; width: auto;" class="mb-3" onerror="this.style.display='none'">
                <h4 class="text-white mb-0">هدية</h4>
                <small class="text-white-50">لوحة تحكم الإدارة</small>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i>المستخدمين
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart me-2"></i>الطلبات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}">
                        <i class="fas fa-box me-2"></i>حزم العمرة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog me-2"></i>الإعدادات
                    </a>
                </li>
            </ul>
            
            <hr class="text-white-50">
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">
                        <i class="fas fa-home me-2"></i>الموقع الرئيسي
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white p-0 w-100 text-start">
                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-wrapper">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">إضافة طلب جديد</h2>
                    <p class="text-muted mb-0">أضف طلب جديد إلى النظام</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>العودة للطلبات
                </a>
            </div>

            <!-- Form Card -->
            <div class="content-card">
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.orders.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="umrah_package_id" class="form-label">حزمة العمرة <span class="text-danger">*</span></label>
                                    <select class="form-select @error('umrah_package_id') is-invalid @enderror" id="umrah_package_id" name="umrah_package_id" required>
                                        <option value="">اختر حزمة العمرة</option>
                                        @foreach($packages as $package)
                                            <option value="{{ $package->id }}" {{ old('umrah_package_id') == $package->id ? 'selected' : '' }}>
                                                {{ $package->name_ar }} - {{ number_format($package->price) }} {{ $package->currency }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('umrah_package_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">المستخدم <span class="text-danger">*</span></label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                        <option value="">اختر المستخدم</option>
                                        @foreach(\App\Models\User::where('role', 'user')->get() as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="beneficiary_name" class="form-label">اسم المستفيد <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('beneficiary_name') is-invalid @enderror" id="beneficiary_name" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required>
                                    @error('beneficiary_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="beneficiary_phone" class="form-label">هاتف المستفيد <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('beneficiary_phone') is-invalid @enderror" id="beneficiary_phone" name="beneficiary_phone" value="{{ old('beneficiary_phone') }}" required>
                                    @error('beneficiary_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Phone Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fab fa-whatsapp"></i>
                                        رقم واتساب للتواصل وإرسال فيديو الإثبات <span class="text-danger">*</span>
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
                                                <option value="+61" {{ old('whatsapp_country_code') == '+61' ? 'selected' : '' }}>🇦🇺 أستراليا (+61)</option>
                                                <option value="+64" {{ old('whatsapp_country_code') == '+64' ? 'selected' : '' }}>🇳🇿 نيوزيلندا (+64)</option>
                                            </select>
                                            @error('whatsapp_country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-8">
                                            <input type="tel" class="form-control @error('whatsapp_phone') is-invalid @enderror" 
                                                   id="whatsapp_phone" name="whatsapp_phone" 
                                                   value="{{ old('whatsapp_phone') }}" 
                                                   placeholder="أدخل رقم الواتساب بدون كود الدولة" required>
                                            @error('whatsapp_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
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
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="beneficiary_type" class="form-label">نوع المستفيد <span class="text-danger">*</span></label>
                                    <select class="form-select @error('beneficiary_type') is-invalid @enderror" id="beneficiary_type" name="beneficiary_type" required>
                                        <option value="">اختر نوع المستفيد</option>
                                        <option value="deceased" {{ old('beneficiary_type') == 'deceased' ? 'selected' : '' }}>متوفى</option>
                                        <option value="sick" {{ old('beneficiary_type') == 'sick' ? 'selected' : '' }}>مريض</option>
                                        <option value="elderly" {{ old('beneficiary_type') == 'elderly' ? 'selected' : '' }}>مسن</option>
                                        <option value="disabled" {{ old('beneficiary_type') == 'disabled' ? 'selected' : '' }}>معاق</option>
                                    </select>
                                    @error('beneficiary_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">حالة الطلب</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                        <option value="assigned" {{ old('status') == 'assigned' ? 'selected' : '' }}>تم التخصيص</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="beneficiary_address" class="form-label">عنوان المستفيد</label>
                            <textarea class="form-control @error('beneficiary_address') is-invalid @enderror" id="beneficiary_address" name="beneficiary_address" rows="3" placeholder="أدخل عنوان المستفيد">{{ old('beneficiary_address') }}</textarea>
                            @error('beneficiary_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="beneficiary_details" class="form-label">تفاصيل إضافية</label>
                            <textarea class="form-control @error('beneficiary_details') is-invalid @enderror" id="beneficiary_details" name="beneficiary_details" rows="3" placeholder="أدخل أي تفاصيل إضافية حول المستفيد">{{ old('beneficiary_details') }}</textarea>
                            @error('beneficiary_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="أدخل أي ملاحظات حول الطلب">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>إنشاء الطلب
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // WhatsApp phone number formatting
        const whatsappPhoneInput = document.getElementById('whatsapp_phone');
        const whatsappCountryCodeSelect = document.getElementById('whatsapp_country_code');
        
        if (whatsappPhoneInput && whatsappCountryCodeSelect) {
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
        }
    });
    </script>
</body>
</html>
