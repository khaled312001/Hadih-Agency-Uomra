<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - هدية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        body { background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem 0; }

        .auth-wrapper { width: 100%; max-width: 540px; padding: 1.5rem; }

        .auth-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 48px rgba(0,0,0,.12);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 2.25rem 2rem 1.75rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .auth-header::before {
            content: ''; position: absolute;
            top: -40px; right: -40px;
            width: 140px; height: 140px;
            background: rgba(102,126,234,.15); border-radius: 50%;
        }
        .auth-header::after {
            content: ''; position: absolute;
            bottom: -30px; left: -30px;
            width: 100px; height: 100px;
            background: rgba(118,75,162,.15); border-radius: 50%;
        }
        .auth-logo {
            position: relative; z-index: 1;
            width: 64px; height: 64px;
            background: rgba(255,255,255,.1);
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: .85rem;
            border: 2px solid rgba(255,255,255,.15);
        }
        .auth-logo img { height: 44px; border-radius: 10px; }
        .auth-logo i { font-size: 1.8rem; color: #a78bfa; }
        .auth-header h3 { color: #fff; font-weight: 800; margin: 0; font-size: 1.35rem; position: relative; z-index: 1; }
        .auth-header p { color: rgba(255,255,255,.55); margin: .3rem 0 0; font-size: .85rem; position: relative; z-index: 1; }

        .auth-body { padding: 2rem; }

        .input-wrap { position: relative; }
        .input-wrap .form-control, .input-wrap .form-select {
            padding-right: 2.6rem;
            border: 2px solid #e2e8f0;
            border-radius: 11px;
            font-size: .88rem;
            height: 46px;
            transition: all .2s;
        }
        .input-wrap .form-control:focus, .input-wrap .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,.1);
        }
        .input-wrap .ico { position: absolute; right: .85rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .85rem; pointer-events: none; }
        .input-wrap .ico-left { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .85rem; cursor: pointer; transition: color .2s; }
        .input-wrap .ico-left:hover { color: #667eea; }
        .input-wrap .form-control.pl { padding-left: 2.6rem; }

        .form-label { font-weight: 700; font-size: .8rem; color: #374151; margin-bottom: .35rem; }

        .step-divider {
            display: flex; align-items: center; gap: .75rem;
            margin: 1.4rem 0 1rem;
            font-size: .8rem; font-weight: 700; color: #667eea;
        }
        .step-divider::before, .step-divider::after {
            content: ''; flex: 1; height: 1px; background: #f1f5f9;
        }

        .btn-auth {
            width: 100%; height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none; border-radius: 14px;
            color: white; font-size: 1rem; font-weight: 700;
            transition: all .25s;
            box-shadow: 0 4px 18px rgba(102,126,234,.4);
            cursor: pointer; font-family: 'Cairo', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
        }
        .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(102,126,234,.5); filter: brightness(1.06); }
        .btn-auth:active { transform: scale(.98); }

        .trust-badge { text-align: center; margin-top: 1.5rem; font-size: .8rem; color: #94a3b8; }
        .trust-badge i { color: #22c55e; }

        .feature-pill {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50px;
            padding: .3rem .8rem;
            font-size: .75rem; color: rgba(255,255,255,.7);
            margin: .2rem;
        }
        .feature-pill i { color: #a78bfa; font-size: .75rem; }

        @media (max-width: 480px) {
            .auth-wrapper { padding: 1rem; }
            .auth-body { padding: 1.25rem; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="text-center mb-3">
        <a href="{{ url('/') }}" style="font-size:.85rem;color:#64748b;text-decoration:none;display:inline-flex;align-items:center;gap:.35rem;">
            <i class="fas fa-arrow-right"></i> العودة للرئيسية
        </a>
    </div>

    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="هدية" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-kaaba\'></i>'">
            </div>
            <h3>إنشاء حساب جديد</h3>
            <p>انضم إلى منصة هدية وابدأ رحلتك الروحانية</p>
            <div class="mt-2">
                <span class="feature-pill"><i class="fas fa-check-circle"></i> آمن 100%</span>
                <span class="feature-pill"><i class="fas fa-star"></i> خدمة مميزة</span>
                <span class="feature-pill"><i class="fas fa-headset"></i> دعم 24/7</span>
            </div>
        </div>

        <!-- Body -->
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4 border-0" style="border-radius:12px;font-size:.875rem;" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role" value="user">

                <!-- Personal Info -->
                <div class="step-divider"><i class="fas fa-user-circle"></i> المعلومات الشخصية</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <div class="input-wrap">
                            <i class="fas fa-user ico"></i>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="أدخل اسمك الكامل"
                                   required autocomplete="name" autofocus>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope ico"></i>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="example@email.com"
                                   required autocomplete="email">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="step-divider mt-4"><i class="fas fa-phone"></i> رقم الهاتف</div>
                <div class="row g-3">
                    <div class="col-5 col-sm-4">
                        <label for="country_code" class="form-label">رمز الدولة</label>
                        <div class="input-wrap">
                            <i class="fas fa-flag ico"></i>
                            <select id="country_code" name="country_code"
                                    class="form-select @error('country_code') is-invalid @enderror" required>
                                <option value="+966" {{ old('country_code','+966')=='+966'?'selected':'' }}>🇸🇦 +966</option>
                                <option value="+971" {{ old('country_code')=='+971'?'selected':'' }}>🇦🇪 +971</option>
                                <option value="+965" {{ old('country_code')=='+965'?'selected':'' }}>🇰🇼 +965</option>
                                <option value="+973" {{ old('country_code')=='+973'?'selected':'' }}>🇧🇭 +973</option>
                                <option value="+974" {{ old('country_code')=='+974'?'selected':'' }}>🇶🇦 +974</option>
                                <option value="+968" {{ old('country_code')=='+968'?'selected':'' }}>🇴🇲 +968</option>
                                <option value="+20"  {{ old('country_code')=='+20'?'selected':''  }}>🇪🇬 +20</option>
                                <option value="+962" {{ old('country_code')=='+962'?'selected':'' }}>🇯🇴 +962</option>
                                <option value="+963" {{ old('country_code')=='+963'?'selected':'' }}>🇸🇾 +963</option>
                            </select>
                            @error('country_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-7 col-sm-8">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <div class="input-wrap">
                            <i class="fas fa-mobile-alt ico"></i>
                            <input type="text" id="phone" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}"
                                   placeholder="501234567"
                                   required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="step-divider mt-4"><i class="fas fa-shield-alt"></i> كلمة المرور</div>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock ico"></i>
                            <input type="password" id="password" name="password"
                                   class="form-control pl @error('password') is-invalid @enderror"
                                   placeholder="8 أحرف على الأقل"
                                   required autocomplete="new-password">
                            <i class="fas fa-eye ico-left" id="togglePass1" onclick="togglePass('password','togglePass1')"></i>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="password-confirm" class="form-label">تأكيد كلمة المرور</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock ico"></i>
                            <input type="password" id="password-confirm" name="password_confirmation"
                                   class="form-control pl"
                                   placeholder="أعد كتابة كلمة المرور"
                                   required autocomplete="new-password">
                            <i class="fas fa-eye ico-left" id="togglePass2" onclick="togglePass('password-confirm','togglePass2')"></i>
                        </div>
                    </div>
                </div>

                <!-- Password strength indicator -->
                <div class="mt-2 mb-4">
                    <div style="height:4px;background:#f1f5f9;border-radius:4px;overflow:hidden;">
                        <div id="strengthBar" style="height:100%;width:0;border-radius:4px;transition:all .3s;"></div>
                    </div>
                    <div id="strengthText" style="font-size:.75rem;color:#94a3b8;margin-top:.3rem;"></div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-user-plus"></i> إنشاء الحساب
                </button>

                <div class="text-center mt-3" style="font-size:.875rem;color:#64748b;">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}" style="color:#667eea;font-weight:700;text-decoration:none;">تسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>

    <div class="trust-badge">
        <i class="fas fa-shield-alt"></i> بياناتك محمية وآمنة تماماً
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'text' ? 'fas fa-eye-slash ico-left' : 'fas fa-eye ico-left';
}

// Password strength
document.getElementById('password').addEventListener('input', function() {
    const val = this.value;
    const bar = document.getElementById('strengthBar');
    const txt = document.getElementById('strengthText');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const levels = [
        { w: '0%',   c: '',        t: '' },
        { w: '25%',  c: '#ef4444', t: 'ضعيفة جداً' },
        { w: '50%',  c: '#f59e0b', t: 'مقبولة' },
        { w: '75%',  c: '#3b82f6', t: 'جيدة' },
        { w: '100%', c: '#22c55e', t: 'ممتازة' },
    ];
    const l = levels[strength] || levels[0];
    bar.style.width = l.w;
    bar.style.background = l.c;
    txt.textContent = l.t ? 'قوة كلمة المرور: ' + l.t : '';
    txt.style.color = l.c;
});
</script>
</body>
</html>
